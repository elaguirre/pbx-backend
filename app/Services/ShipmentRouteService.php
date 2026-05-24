<?php

namespace App\Services;

use App\Enums\ShipmentOrderPieceStatus;
use App\Enums\ShipmentRouteStatus;
use App\Models\Shipment;
use App\Models\ShipmentOrderPiece;
use App\Models\ShipmentRoute;
use Illuminate\Support\Collection;

class ShipmentRouteService
{
    public function __construct(protected DeliveryAddressResolver $deliveryAddressResolver) {}

    public function syncForShipment(int $shipmentId): void
    {
        $entityAddressIds = $this->collectEntityAddressIdsForShipment($shipmentId);

        ShipmentRoute::query()
            ->where('shipment_id', $shipmentId)
            ->whereNotIn('entity_address_id', $entityAddressIds)
            ->delete();

        $existingEntityAddressIds = ShipmentRoute::query()
            ->where('shipment_id', $shipmentId)
            ->pluck('entity_address_id')
            ->all();

        $maxOrder = (int) ShipmentRoute::query()
            ->where('shipment_id', $shipmentId)
            ->max('order');

        foreach ($entityAddressIds as $entityAddressId) {
            if (in_array($entityAddressId, $existingEntityAddressIds, true)) {
                continue;
            }

            $maxOrder += 10;

            ShipmentRoute::query()->create([
                'shipment_id' => $shipmentId,
                'entity_address_id' => $entityAddressId,
                'order' => $maxOrder,
            ]);
        }
    }

    /**
     * @return list<int>
     */
    public function collectEntityAddressIdsForShipment(int $shipmentId): array
    {
        $pieces = ShipmentOrderPiece::query()
            ->where('shipment_id', $shipmentId)
            ->with('orderPiece.order.client')
            ->get();

        $entityAddressIds = [];

        foreach ($pieces as $piece) {
            $entityAddressId = $this->deliveryAddressResolver->resolveForOrderPiece($piece->orderPiece);

            if ($entityAddressId) {
                $entityAddressIds[$entityAddressId] = $entityAddressId;
            }
        }

        return array_values($entityAddressIds);
    }

    public function computeStatus(ShipmentRoute $route): ShipmentRouteStatus
    {
        $pieces = $this->piecesForRoute($route);

        if ($pieces->isEmpty()) {
            return ShipmentRouteStatus::Pending;
        }

        $orderIds = $pieces
            ->pluck('orderPiece.order_id')
            ->filter()
            ->unique()
            ->values();

        foreach ($orderIds as $orderId) {
            $orderPieces = $pieces->filter(
                fn (ShipmentOrderPiece $row) => (int) $row->orderPiece?->order_id === (int) $orderId,
            );

            if ($orderPieces->contains(
                fn (ShipmentOrderPiece $row) => $row->status !== ShipmentOrderPieceStatus::Delivered,
            )) {
                return ShipmentRouteStatus::Pending;
            }
        }

        return ShipmentRouteStatus::Complete;
    }

    /**
     * @param  Collection<int, ShipmentRoute>  $routes
     */
    public function attachStatuses(Collection $routes): void
    {
        if ($routes->isEmpty()) {
            return;
        }

        $shipmentId = (int) $routes->first()->shipment_id;

        $pieces = ShipmentOrderPiece::query()
            ->where('shipment_id', $shipmentId)
            ->with('orderPiece.order')
            ->get();

        foreach ($routes as $route) {
            $route->setAttribute('status', $this->computeStatusFromPieces($route, $pieces)->value);
        }
    }

    /**
     * @param  Collection<int, ShipmentOrderPiece>  $allPieces
     */
    protected function computeStatusFromPieces(ShipmentRoute $route, Collection $allPieces): ShipmentRouteStatus
    {
        $routePieces = $allPieces->filter(
            fn (ShipmentOrderPiece $row) => $this->pieceBelongsToRoute($row, $route),
        );

        if ($routePieces->isEmpty()) {
            return ShipmentRouteStatus::Pending;
        }

        $orderIds = $routePieces
            ->pluck('orderPiece.order_id')
            ->filter()
            ->unique()
            ->values();

        foreach ($orderIds as $orderId) {
            $orderPieces = $routePieces->filter(
                fn (ShipmentOrderPiece $row) => (int) $row->orderPiece?->order_id === (int) $orderId,
            );

            if ($orderPieces->contains(
                fn (ShipmentOrderPiece $row) => $row->status !== ShipmentOrderPieceStatus::Delivered,
            )) {
                return ShipmentRouteStatus::Pending;
            }
        }

        return ShipmentRouteStatus::Complete;
    }

    protected function piecesForRoute(ShipmentRoute $route): Collection
    {
        return ShipmentOrderPiece::query()
            ->where('shipment_id', $route->shipment_id)
            ->with('orderPiece.order')
            ->get()
            ->filter(fn (ShipmentOrderPiece $row) => $this->pieceBelongsToRoute($row, $route));
    }

    protected function pieceBelongsToRoute(ShipmentOrderPiece $row, ShipmentRoute $route): bool
    {
        if (! $row->orderPiece) {
            return false;
        }

        $entityAddressId = $this->deliveryAddressResolver->resolveForOrderPiece($row->orderPiece);

        return $entityAddressId && (int) $entityAddressId === (int) $route->entity_address_id;
    }

    public function moveUp(ShipmentRoute $route): void
    {
        $previous = ShipmentRoute::query()
            ->where('shipment_id', $route->shipment_id)
            ->where('order', '<', $route->order)
            ->orderByDesc('order')
            ->first();

        if (! $previous) {
            return;
        }

        $this->swapOrder($route, $previous);
    }

    public function moveDown(ShipmentRoute $route): void
    {
        $next = ShipmentRoute::query()
            ->where('shipment_id', $route->shipment_id)
            ->where('order', '>', $route->order)
            ->orderBy('order')
            ->first();

        if (! $next) {
            return;
        }

        $this->swapOrder($route, $next);
    }

    protected function swapOrder(ShipmentRoute $a, ShipmentRoute $b): void
    {
        $orderA = $a->order;
        $a->update(['order' => $b->order]);
        $b->update(['order' => $orderA]);
    }
}

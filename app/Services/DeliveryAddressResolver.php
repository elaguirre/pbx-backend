<?php

namespace App\Services;

use App\Enums\EntityAddressType;
use App\Models\EntityAddress;
use App\Models\Order;
use App\Models\OrderPiece;
use Illuminate\Support\Collection;

class DeliveryAddressResolver
{
    /** Prioridad al elegir dirección de entrega del cliente. */
    private const ENTITY_ADDRESS_TYPE_PRIORITY = [
        EntityAddressType::Shipping,
        EntityAddressType::Home,
        EntityAddressType::Work,
        EntityAddressType::Mailing,
        EntityAddressType::Billing,
    ];

    public function resolveForOrder(Order $order): ?int
    {
        if ($order->delivery_address_id) {
            $address = EntityAddress::query()->find($order->delivery_address_id);

            if ($address) {
                return (int) $address->id;
            }
        }

        $order->loadMissing('client');

        $entityId = $order->client?->entity_id;

        if (! $entityId) {
            return null;
        }

        return $this->resolveForEntityId((int) $entityId);
    }

    public function resolveForOrderPiece(OrderPiece $orderPiece): ?int
    {
        $orderPiece->loadMissing('order.client');

        if (! $orderPiece->order) {
            return null;
        }

        return $this->resolveForOrder($orderPiece->order);
    }

    public function resolveForEntityId(int $entityId): ?int
    {
        $addresses = EntityAddress::query()
            ->where('entity_id', $entityId)
            ->orderBy('id')
            ->get();

        return $this->pickDeliveryAddress($addresses);
    }

    /**
     * @param  Collection<int, EntityAddress>  $addresses
     */
    protected function pickDeliveryAddress(Collection $addresses): ?int
    {
        if ($addresses->isEmpty()) {
            return null;
        }

        if ($addresses->count() === 1) {
            return (int) $addresses->first()->id;
        }

        foreach (self::ENTITY_ADDRESS_TYPE_PRIORITY as $type) {
            $match = $addresses->first(fn (EntityAddress $address) => $address->type === $type);

            if ($match) {
                return (int) $match->id;
            }
        }

        return (int) $addresses->first()->id;
    }
}

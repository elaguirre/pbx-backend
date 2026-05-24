<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShipmentOrderPieceRequest;
use App\Models\ShipmentOrderPiece;
use App\Services\ShipmentRouteService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/shipment-order-pieces')]
class ShipmentOrderPieceController extends Controller
{
    public function __construct(protected ShipmentRouteService $shipmentRouteService) {}
    #[Route('GET', '/', middleware: 'can:shipment_order_pieces.view')]
    public function index(): JsonResponse
    {
        return response()->json(ShipmentOrderPiece::queryBuilder()->resolve());
    }

    #[Route('GET', '/{shipment_order_piece}', middleware: 'can:shipment_order_pieces.view')]
    public function show(ShipmentOrderPiece $shipment_order_piece): JsonResponse
    {
        return response()->json(
            ShipmentOrderPiece::queryBuilder()->whereKey($shipment_order_piece->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:shipment_order_pieces.add')]
    public function store(ShipmentOrderPieceRequest $request): JsonResponse
    {
        $row = ShipmentOrderPiece::query()->create($request->validated());

        $this->shipmentRouteService->syncForShipment((int) $row->shipment_id);

        return response()->message('Pieza agregada al embarque correctamente.', 201, data: $row);
    }

    #[Route('PUT', '/{shipment_order_piece}', middleware: 'can:shipment_order_pieces.edit')]
    public function update(ShipmentOrderPieceRequest $request, ShipmentOrderPiece $shipment_order_piece): JsonResponse
    {
        $shipment_order_piece->update($request->validated());

        $this->shipmentRouteService->syncForShipment((int) $shipment_order_piece->shipment_id);

        return response()->message('Pieza del embarque actualizada correctamente.', data: $shipment_order_piece);
    }

    #[Route('DELETE', '/{shipment_order_piece}', middleware: 'can:shipment_order_pieces.delete')]
    public function destroy(ShipmentOrderPiece $shipment_order_piece): JsonResponse
    {
        $shipmentId = (int) $shipment_order_piece->shipment_id;

        $shipment_order_piece->delete();

        $this->shipmentRouteService->syncForShipment($shipmentId);

        return response()->message('Pieza quitada del embarque correctamente.');
    }
}

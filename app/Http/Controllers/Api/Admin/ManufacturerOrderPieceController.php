<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManufacturerOrderPieceRequest;
use App\Models\ManufacturerOrderPiece;
use App\Enums\ManufacturerOrderPieceStatus;
use App\Services\ManufacturerLaborCostCalculator;
use App\Services\ManufacturerOrderPieceManufacturingService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/manufacturer-order-pieces')]
class ManufacturerOrderPieceController extends Controller
{
    public function __construct(
        protected ManufacturerLaborCostCalculator $laborCosts,
        protected ManufacturerOrderPieceManufacturingService $manufacturing,
    ) {}

    #[Route('GET', '/', middleware: 'can:manufacturer_order_pieces.view')]
    public function index(): JsonResponse
    {
        $resolved = ManufacturerOrderPiece::queryBuilder()->resolve();

        return response()->json($this->resolveAssignments($resolved));
    }

    #[Route('GET', '/{manufacturer_order_piece}', middleware: 'can:manufacturer_order_pieces.view')]
    public function show(ManufacturerOrderPiece $manufacturer_order_piece): JsonResponse
    {
        $assignment = ManufacturerOrderPiece::queryBuilder()
            ->whereKey($manufacturer_order_piece->getKey())
            ->firstOrFail();

        return response()->json($this->resolveAssignments($assignment));
    }

    #[Route('POST', '/', middleware: 'can:manufacturer_order_pieces.add')]
    public function store(ManufacturerOrderPieceRequest $request): JsonResponse
    {
        $assignment = ManufacturerOrderPiece::query()->create([
            ...$request->validated(),
            'status' => ManufacturerOrderPieceStatus::Pending,
        ]);
        $this->manufacturing->syncAssignmentStatus($assignment);
        $assignment->refresh()->load(['orderPiece', 'availableStatus', 'statusOfCompletedPieces']);

        return response()->message('Pieza asignada a la orden correctamente.', 201, data: $this->resolveAssignments($assignment));
    }

    #[Route('PUT', '/{manufacturer_order_piece}', middleware: 'can:manufacturer_order_pieces.edit')]
    public function update(ManufacturerOrderPieceRequest $request, ManufacturerOrderPiece $manufacturer_order_piece): JsonResponse
    {
        $manufacturer_order_piece->update($request->validated());
        $this->manufacturing->syncAssignmentStatus($manufacturer_order_piece->refresh());
        $manufacturer_order_piece->load(['orderPiece', 'availableStatus', 'statusOfCompletedPieces']);

        return response()->message('Asignación actualizada correctamente.', data: $this->resolveAssignments($manufacturer_order_piece));
    }

    protected function resolveAssignments(mixed $resolved): mixed
    {
        $resolved = $this->manufacturing->appendManufacturingAttributes($resolved);

        return $this->laborCosts->appendManufacturerOrderPieceLaborCosts($resolved);
    }

    #[Route('DELETE', '/{manufacturer_order_piece}', middleware: 'can:manufacturer_order_pieces.delete')]
    public function destroy(ManufacturerOrderPiece $manufacturer_order_piece): JsonResponse
    {
        $manufacturer_order_piece->delete();

        return response()->message('Pieza quitada de la orden correctamente.');
    }
}

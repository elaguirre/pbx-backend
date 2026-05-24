<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManufacturingFollowUpRequest;
use App\Models\ManufacturerOrderPiece;
use App\Models\ManufacturingFollowUp;
use App\Services\ManufacturerOrderPieceManufacturingService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/manufacturing-follow-up')]
class ManufacturingFollowUpController extends Controller
{
    public function __construct(protected ManufacturerOrderPieceManufacturingService $manufacturing) {}

    #[Route('GET', '/')]
    public function index(): JsonResponse
    {
        $user = auth()->user();

        abort_unless(
            $user->can('manufacturing_follow_up.view')
            || $user->can('manufacturer_order_pieces.view'),
            403,
            'No tiene permiso para consultar seguimiento de manufactura.',
        );

        return response()->json(ManufacturingFollowUp::queryBuilder()->resolve());
    }

    #[Route('GET', '/{mfg_follow_up}', middleware: 'can:manufacturing_follow_up.view')]
    public function show(ManufacturingFollowUp $mfg_follow_up): JsonResponse
    {
        return response()->json(
            ManufacturingFollowUp::queryBuilder()
                ->whereKey($mfg_follow_up->getKey())
                ->firstOrFail(),
        );
    }

    #[Route('POST', '/', middleware: 'can:manufacturing_follow_up.add')]
    public function store(ManufacturingFollowUpRequest $request): JsonResponse
    {
        $followUp = ManufacturingFollowUp::query()->create($request->validated());
        $followUp->load('user');
        $this->syncAssignmentFromFollowUp($followUp);

        return response()->message('Seguimiento registrado correctamente.', 201, data: $followUp);
    }

    #[Route('PUT', '/{mfg_follow_up}', middleware: 'can:manufacturing_follow_up.edit')]
    public function update(
        ManufacturingFollowUpRequest $request,
        ManufacturingFollowUp $mfg_follow_up,
    ): JsonResponse {
        $mfg_follow_up->update($request->validated());
        $mfg_follow_up->refresh()->load('user');
        $this->syncAssignmentFromFollowUp($mfg_follow_up);

        return response()->message('Seguimiento actualizado correctamente.', data: $mfg_follow_up);
    }

    #[Route('DELETE', '/{mfg_follow_up}', middleware: 'can:manufacturing_follow_up.delete')]
    public function destroy(ManufacturingFollowUp $mfg_follow_up): JsonResponse
    {
        $assignmentId = $mfg_follow_up->manufacturer_order_piece_id;
        $mfg_follow_up->delete();

        $assignment = ManufacturerOrderPiece::query()->find($assignmentId);

        if ($assignment) {
            $this->manufacturing->syncAssignmentStatus($assignment);
        }

        return response()->message('Seguimiento eliminado correctamente.');
    }

    protected function syncAssignmentFromFollowUp(ManufacturingFollowUp $followUp): void
    {
        $assignment = $followUp->relationLoaded('manufacturerOrderPiece')
            ? $followUp->manufacturerOrderPiece
            : ManufacturerOrderPiece::query()->find($followUp->manufacturer_order_piece_id);

        if ($assignment) {
            $this->manufacturing->syncAssignmentStatus($assignment);
        }
    }
}

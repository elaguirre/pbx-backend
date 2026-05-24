<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\OrderPieceStatusRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderPieceStatusRequest;
use App\Models\OrderPieceStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/order-piece-statuses')]
class OrderPieceStatusController extends Controller
{
    #[Route('GET', '/', middleware: 'can:order_piece_statuses.view')]
    public function index(): JsonResponse
    {
        return response()->json(OrderPieceStatus::queryBuilder()->resolve());
    }

    #[Route('GET', '/{order_piece_status}', middleware: 'can:order_piece_statuses.view')]
    public function show(OrderPieceStatus $order_piece_status): JsonResponse
    {
        $status = OrderPieceStatus::queryBuilder()
            ->whereKey($order_piece_status->getKey())
            ->firstOrFail();

        return response()->json($status);
    }

    #[Route('POST', '/', middleware: 'can:order_piece_statuses.add')]
    public function store(OrderPieceStatusRequest $request): JsonResponse
    {
        $status = DB::transaction(function () use ($request) {
            $data = $request->validated();

            $this->clearExclusiveRole($this->resolveRole($data['role'] ?? null));

            return OrderPieceStatus::query()->create($data);
        });

        return response()->message('Estado de pieza creado correctamente.', 201, data: $status);
    }

    #[Route('PUT', '/{order_piece_status}', middleware: 'can:order_piece_statuses.edit')]
    public function update(OrderPieceStatusRequest $request, OrderPieceStatus $order_piece_status): JsonResponse
    {
        DB::transaction(function () use ($request, $order_piece_status) {
            $data = $request->validated();

            $this->clearExclusiveRole($this->resolveRole($data['role'] ?? null), $order_piece_status->getKey());

            $order_piece_status->update($data);
        });

        return response()->message('Estado de pieza actualizado correctamente.', data: $order_piece_status->fresh());
    }

    #[Route('DELETE', '/{order_piece_status}', middleware: 'can:order_piece_statuses.delete')]
    public function destroy(OrderPieceStatus $order_piece_status): JsonResponse
    {
        $order_piece_status->delete();

        return response()->message('Estado de pieza eliminado correctamente.');
    }

    private function resolveRole(mixed $role): ?OrderPieceStatusRole
    {
        if ($role instanceof OrderPieceStatusRole) {
            return $role;
        }

        if (! is_string($role) || $role === '') {
            return null;
        }

        return OrderPieceStatusRole::tryFrom($role);
    }

    private function clearExclusiveRole(?OrderPieceStatusRole $role, ?int $exceptId = null): void
    {
        if (! $role) {
            return;
        }

        $query = OrderPieceStatus::query()->where('role', $role);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        $query->update(['role' => null]);
    }
}

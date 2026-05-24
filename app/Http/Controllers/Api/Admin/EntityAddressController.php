<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EntityAddressRequest;
use App\Models\EntityAddress;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/entity-addresses')]
class EntityAddressController extends Controller
{
    #[Route('GET', '/', middleware: 'can:entity_addresses.view')]
    public function index(): JsonResponse
    {
        return response()->json(EntityAddress::queryBuilder()->resolve());
    }

    #[Route('GET', '/{entity_address}', middleware: 'can:entity_addresses.view')]
    public function show(EntityAddress $entity_address): JsonResponse
    {
        return response()->json(
            EntityAddress::queryBuilder()->whereKey($entity_address->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:entity_addresses.add')]
    public function store(EntityAddressRequest $request): JsonResponse
    {
        $address = EntityAddress::query()->create($request->validated());

        return response()->message('Dirección creada correctamente.', 201, data: $address);
    }

    #[Route('PUT', '/{entity_address}', middleware: 'can:entity_addresses.edit')]
    public function update(EntityAddressRequest $request, EntityAddress $entity_address): JsonResponse
    {
        $entity_address->update($request->validated());

        return response()->message('Dirección actualizada correctamente.', data: $entity_address);
    }

    #[Route('DELETE', '/{entity_address}', middleware: 'can:entity_addresses.delete')]
    public function destroy(EntityAddress $entity_address): JsonResponse
    {
        $entity_address->delete();

        return response()->message('Dirección eliminada correctamente.');
    }
}

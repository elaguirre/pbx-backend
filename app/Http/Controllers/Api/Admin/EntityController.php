<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EntityRequest;
use App\Models\Entity;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/entities')]
class EntityController extends Controller
{
    #[Route('GET', '/', middleware: 'can:entities.view')]
    public function index(): JsonResponse
    {
        return response()->json(Entity::queryBuilder()->resolve());
    }

    #[Route('GET', '/{entity}', middleware: 'can:entities.view')]
    public function show(Entity $entity): JsonResponse
    {
        return response()->json(
            Entity::queryBuilder()->whereKey($entity->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:entities.add')]
    public function store(EntityRequest $request): JsonResponse
    {
        $entity = Entity::query()->create($request->validated());

        return response()->message('Entidad creada correctamente.', 201, data: $entity);
    }

    #[Route('PUT', '/{entity}', middleware: 'can:entities.edit')]
    public function update(EntityRequest $request, Entity $entity): JsonResponse
    {
        $entity->update($request->validated());

        return response()->message('Entidad actualizada correctamente.', data: $entity);
    }

    #[Route('DELETE', '/{entity}', middleware: 'can:entities.delete')]
    public function destroy(Entity $entity): JsonResponse
    {
        $entity->delete();

        return response()->message('Entidad eliminada correctamente.');
    }
}

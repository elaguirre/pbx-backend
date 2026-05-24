<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use Illuminate\Http\Request;
use App\Models\{Role, User};
use Illuminate\Http\JsonResponse;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/roles')]
class RoleController extends Controller
{
    #[Route('GET', '/')]
    public function index(Request $request): JsonResponse
    {
        return response()->json(Role::queryBuilder()->resolve());
    }

    #[Route('GET', '{role}')]
    public function show(Role $role): JsonResponse
    {
        return response()->json($role);
    }

    #[Route('POST', '/', middleware: 'can:roles.save')]
    public function store(RoleRequest $request): JsonResponse
    {
        $role = Role::create($request->validated());

        return response()->message('Se creó el registro correctamente.', 201, data: $role);
    }

    #[Route('PUT', '{role}', middleware: 'can:roles.save')]
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        if ($role->id == 1 && !auth()->user()->isAn('root')) {
            return response()->message('No tienes permisos para editar el rol Root.', 400);
        }

        $role->update($request->validated());

        return response()->message('Se editó el registro correctamente.', data: $role);
    }

    #[Route('PUT', '{role}/users', middleware: 'can:roles.save')]
    public function updateUsers(Request $request, Role $role): JsonResponse
    {
        $users = User::whereIn('id', $request->collect('user_ids', []))->get();

        $users->map(function ($user) use ($role) {
            Bouncer::sync($user)->roles($role->id);
        });

        return response()->message('Se editó el registro correctamente.', data: $role);
    }

    #[Route('DELETE', '{role}', middleware: 'can:roles.delete')]
    public function destroy(Role $role): JsonResponse
    {
        $role->abilities()->sync([]);
        $role->delete();

        return response()->message('Se eliminó el registro correctamente.');
    }

    // Abilities
    #[Route('GET', '{role}/abilities', middleware: 'can:roles.access')]
    public function getAbilities(Role $role): JsonResponse
    {
        return response()->json($role->getAbilities());
    }

    #[Route('PUT', '{role}/abilities', middleware: 'can:roles.save')]
    public function updateAbilities(Request $request, Role $role): JsonResponse
    {
        $role->abilities()->sync($request->get('ability_ids', []));

        return response()->message('Se editó el registro correctamente.', data: $role);
    }
}

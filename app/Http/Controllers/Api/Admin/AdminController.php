<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/admins')]
class AdminController extends Controller
{
    #[Route('GET', '/', middleware: 'can:users.view')]
    public function index(Request $request): JsonResponse
    {
        return response()->json(User::queryBuilder()
            ->filterByRole($request->get('rol'))
            ->resolve());
    }

    #[Route('GET', '{admin}', middleware: 'can:users.view')]
    public function show(User $admin): JsonResponse
    {
        return response()->json($admin);
    }

    #[Route('POST', '/', middleware: 'can:users.add')]
    public function store(AdminRequest $request): JsonResponse
    {
        if ($request->get('role_id') == 1 && ! auth()->user()->isAn('root')) {
            return response()->message('No tienes permisos para asignar el rol Root.', 400);
        }

        $admin = User::create($request->validated());

        if ($request->get('password')) {
            $admin->update(['password_digest' => $request->get('password')]);
        }

        Bouncer::sync($admin)->roles($request->get('role_id'));

        return response()->message(__('response.store'), 201, data: $admin);
    }

    #[Route('PUT', '{admin}', middleware: 'can:users.edit')]
    public function update(AdminRequest $request, User $admin): JsonResponse
    {
        if ($request->get('role_id') == 1 && ! auth()->user()->isAn('root')) {
            return response()->message('No tienes permisos para asignar el rol Root.', 400);
        }

        $admin->update($request->validated());

        if ($request->get('password')) {
            $admin->update(['password_digest' => $request->get('password')]);
        }

        Bouncer::sync($admin)->roles($request->get('role_id'));

        return response()->message(__('response.update'), data: $admin);
    }

    #[Route('DELETE', '{admin}', middleware: 'can:users.delete')]
    public function destroy(User $admin): JsonResponse
    {
        $admin->delete();

        return response()->message(__('response.delete'));
    }

    #[Route('GET', '{admin}/abilities', middleware: 'can:users.permissions')]
    public function getAbilities(User $admin): JsonResponse
    {
        return response()->json($admin->getAbilities());
    }

    #[Route('PUT', '{admin}/abilities', middleware: 'can:users.permissions')]
    public function updateAbilities(Request $request, User $admin): JsonResponse
    {
        $admin->abilities()->sync($request->get('ability_ids', []));

        return response()->message('Permisos actualizados correctamente.', data: $admin);
    }
}

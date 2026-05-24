<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/clients')]
class ClientController extends Controller
{
    #[Route('GET', '/', middleware: 'can:clients.view')]
    public function index(): JsonResponse
    {
        return response()->json(Client::queryBuilder()->resolve());
    }

    #[Route('GET', '/{client}', middleware: 'can:clients.view')]
    public function show(Client $client): JsonResponse
    {
        return response()->json(
            Client::queryBuilder()->whereKey($client->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:clients.add')]
    public function store(ClientRequest $request): JsonResponse
    {
        $client = Client::query()->create($request->validated());

        return response()->message('Cliente creado correctamente.', 201, data: $client);
    }

    #[Route('PUT', '/{client}', middleware: 'can:clients.edit')]
    public function update(ClientRequest $request, Client $client): JsonResponse
    {
        $client->update($request->validated());

        return response()->message('Cliente actualizado correctamente.', data: $client);
    }

    #[Route('DELETE', '/{client}', middleware: 'can:clients.delete')]
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->message('Cliente eliminado correctamente.');
    }
}

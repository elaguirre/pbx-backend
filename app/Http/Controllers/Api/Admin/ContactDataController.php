<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactDataRequest;
use App\Models\ContactData;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\{Middleware, Prefix, Route};

#[Middleware('auth')]
#[Prefix('admin/contact-data')]
class ContactDataController extends Controller
{
    #[Route('GET', '/', middleware: 'can:contact_data.view')]
    public function index(): JsonResponse
    {
        return response()->json(ContactData::queryBuilder()->resolve());
    }

    #[Route('GET', '/{contactData}', middleware: 'can:contact_data.view')]
    public function show(ContactData $contactData): JsonResponse
    {
        return response()->json(
            ContactData::queryBuilder()->whereKey($contactData->getKey())->firstOrFail()
        );
    }

    #[Route('POST', '/', middleware: 'can:contact_data.add')]
    public function store(ContactDataRequest $request): JsonResponse
    {
        $contactData = ContactData::query()->create($request->validated());

        return response()->message('Dato de contacto creado correctamente.', 201, data: $contactData);
    }

    #[Route('PUT', '/{contactData}', middleware: 'can:contact_data.edit')]
    public function update(ContactDataRequest $request, ContactData $contactData): JsonResponse
    {
        $contactData->update($request->validated());

        return response()->message('Dato de contacto actualizado correctamente.', data: $contactData);
    }

    #[Route('DELETE', '/{contactData}', middleware: 'can:contact_data.delete')]
    public function destroy(ContactData $contactData): JsonResponse
    {
        $contactData->delete();

        return response()->message('Dato de contacto eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\V1\ContactResource;
use App\Http\Resources\V1\ContactsResource;
use App\Http\Services\V1\ContactsService;
use Illuminate\Http\Response;

class ContactsApiController extends Controller
{

    /**
     * @var ContactsService
     */
    private ContactsService $contactsService;

    public function __construct(ContactsService $contactsService)
    {
        $this->contactsService = $contactsService;
    }

    /**
     * Возвращает контакты пользователя
     *
     * @return ContactsResource
     */
    public function index(): ContactsResource
    {
        return new ContactsResource($this->contactsService->getContacts());
    }

    /**
     * @param StoreContactRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(StoreContactRequest $request)
    {
        $validatedData = $request->validated();

        $contact = $this->contactsService->storeContact($validatedData);

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Возвращает указанный контакт
     *
     * @param int $id
     * @return ContactResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id): ContactResource
    {
        $contact = $this->contactsService->getContact($id);

        $this->authorize('view', $contact);

        return new ContactResource($contact);

    }

    /**
     * Запрос на обновление существующего контакта
     *
     * @param UpdateContactRequest $request
     * @param int $id
     * @return ContactResource
     */
    public function update(UpdateContactRequest $request, int $id)
    {
        $contact = $this->contactsService->getContact($id);

        $validatedData = $request->validated();

        $this->contactsService->updateContact($validatedData, $contact);

        return new ContactResource($contact);

    }

    /**
     * Запрос на удаление существующего контакта
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $contact = $this->contactsService->getContact($id);

        $this->contactsService->deleteContact($contact);

        return new Response('Контакт удален', 200);

    }
}

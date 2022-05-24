<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Services\V1\ContactsService;
use App\Models\Contact;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('contacts.index');
    }

    /**
     * Запрашивает контакты и возвращает коллекцию записей для работы с асинхронным datatables
     * @return mixed
     * @throws \Exception
     */
    public function dataTablesData(string $favouriteCriteria = 'all')
    {
        $contacts = $this->contactsService->getContacts($favouriteCriteria);

        return Datatables::of($contacts)->make(true);
    }

    /**
     * Обработка ajax запроса на переключение статуса "в избранном"
     * @param int $id
     * @return array
     */
    public function toggleFavourite(int $id): array
    {
        $contact = $this->contactsService->getContact($id);

        $this->contactsService->toggleFavourite($contact);

        return [
            'status' => 'success',
            'message' => $contact->is_favourite ? 'Добавлено в избранное' : 'Удалено из избранного',
        ];

    }

    public function create()
    {
        return view('contacts.create-edit', ['model' => new Contact()]);
    }

    /**
     * Запрос на сохранение нового контакта
     * @param StoreContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContactRequest $request)
    {
        $validatedData = $request->validated();

        $this->contactsService->storeContact($validatedData);

        if ($request->after_save === 'continue') {
            return redirect()->route('contacts.create')->with(['success' => 'Запись добавлена']);
        }

        return redirect()->route('contacts.index')->with(['success' => 'Запись добавлена']);

    }


    /**
     * Страница добавления-редактирования контакта
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        $contact = $this->contactsService->getContact($id);

        $this->authorize('edit', $contact);

        return view('contacts.create-edit', ['model' => $contact]);

    }

    /**
     * Запрос на обновление существующего контакта
     *
     * @param UpdateContactRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateContactRequest $request, int $id)
    {
        $contact = $this->contactsService->getContact($id);

        $validatedData = $request->validated();

        $this->contactsService->updateContact($validatedData, $contact);

        if ($request->after_save === 'continue') {
            return redirect()->route('contacts.edit', $contact->id)->with(['success' => 'Запись обновлена']);
        }

        return redirect()->route('contacts.index')->with(['success' => 'Запись обновлена']);

    }

    /**
     * Страница просмотра контакта
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id)
    {
        $contact = $this->contactsService->getContact($id);

        $this->authorize('view', $contact);

        return view('contacts.show', ['model' => $contact]);

    }

    /**
     * Запрос на удаление существующего контакта
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|string[]
     */
    public function destroy(int $id)
    {
        $contact = $this->contactsService->getContact($id);

        try {

            $this->contactsService->deleteContact($contact);

        } catch (\Exception $e) {

            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'message' => 'Ошибка удаления записи: ' . $e->getMessage(),
                ];
            }

            return redirect()->route('contacts.index')->with(['error' => 'Ошибка удаления записи: ' . $e->getMessage()]);

        }

        if (request()->ajax()) {
            return [
                'status' => 'success',
                'message' => 'Запись удалена',
            ];
        }

        return back()->with(['success' => 'Запись удалена']);

    }

}

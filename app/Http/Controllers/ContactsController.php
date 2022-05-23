<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Services\ContactsService;
use App\Models\Contact;
use Yajra\DataTables\DataTables;
use function PHPUnit\Framework\throwException;

class ContactsController extends Controller
{

    private $contactsService;

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
        $items = $this->contactsService->getContacts($favouriteCriteria);
        return Datatables::of($items)->make(true);
    }

    /**
     * Обработка ajax запроса на переключение статуса "в избранном"
     * @param int $id
     * @return string[]
     */
    public function toggleFavourite(Contact $contact): array
    {

        try {

            $this->authorize('edit', $contact);

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Запись не найдена или доступ к ней отсутствует',
            ];

        }

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
     * @param Contact $contact
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);
        return view('contacts.create-edit', ['model' => $contact]);
    }

    /**
     * Запрос на сохранение существующего контакта
     *
     * @param StoreContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreContactRequest $request, Contact $contact)
    {

        $this->authorize('update', $contact);

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
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        return view('contacts.show', ['model' => $contact]);
    }

    public function destroy(Contact $contact)
    {

        try {

            $this->authorize('delete', $contact);

        } catch (\Exception $e) {

            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'message' => 'Ошибка удаления записи: ' . $e->getMessage(),
                ];
            }

            return redirect()->route('contacts.index')->with(['error' => 'Ошибка удаления записи: ' . $e->getMessage()]);

        }

        $this->contactsService->deleteContact($contact);

        if (request()->ajax()) {
            return [
                'status' => 'success',
                'message' => 'Запись удалена',
            ];
        }

        return redirect()->route('contacts.index')->with(['success' => 'Запись удалена']);


    }

}

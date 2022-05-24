<?php

namespace App\Http\Services\V1;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class ContactsService
{

    /**
     * Возвращает коллекцию контактов владельца
     * @param string $favouriteCriteria - фильтр по признаку "избранное"
     * @return Collection
     */
    public function getContacts(string $favouriteCriteria = 'all'): Collection
    {
        $qb = auth()->user()->contacts()->newQuery();

        switch ($favouriteCriteria) {

            case 'favouritesOnly':
                $qb->favouritesOnly();
                break;

            case 'nonFavouritesOnly':
                $qb->nonFavouritesOnly();
                break;

        }

        return $qb->get();
    }

    /**
     * Возвращает контакт владельца
     * @param int $id
     * @return Contact
     */
    public function getContact(int $id): ?Contact
    {
        $contact = Contact::find($id);

        return empty($contact) ? abort(404, 'Контакт не найден') : $contact;
    }

    /**
     * Переключает статус "в избранном"
     * @param Contact $contact
     * @return void
     */
    public function toggleFavourite(Contact $contact)
    {
        $this->authorize('edit', $contact);

        $contact->update(['is_favourite' => !$contact->is_favourite]);
    }


    /**
     * Сохранить новый контакт
     * @param array $validatedData
     * @return Contact
     */
    public function storeContact(array $validatedData): Contact
    {
        return auth()->user()->contacts()->create($validatedData);
    }

    /**
     * Обновить существующий контакт
     * @param array $validatedData
     * @param Contact|null $contact
     * @return void
     */
    public function updateContact(array $validatedData, ?Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($validatedData);
    }

    /**
     * Удалить существующий контакт
     * @param Contact|null $contact
     * @return void
     */
    public function deleteContact(?Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();
    }

    /**
     * Генерирует случайные контакты и сохраняет их для текущего пользователя
     *
     * @param int $num
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateRandomContacts(int $num = 10)
    {
        $contacts = Contact::factory()->count($num)->make();

        $contacts->each(function ($contact) {
            auth()->user()->contacts()->save($contact);
        });

    }

    /**
     * Проверка доступа к контакту
     *
     * @param string $ability
     * @param object|null $model
     * @return void
     */
    private function authorize(string $ability, ?object $model)
    {
        $response = Gate::inspect($ability, $model);

        if (!$response->allowed()) {
            abort(403, 'Доступ запрещен.');
        }

    }

}

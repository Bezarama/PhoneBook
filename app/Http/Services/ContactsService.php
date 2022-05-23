<?php

namespace App\Http\Services;

use App\Models\Contact;
use Illuminate\Support\Collection;

class ContactsService
{
    private $model;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

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
        return auth()->user()->contacts->find($id);
    }

    /**
     * Переключает статус "в избранном"
     * @param Contact $contact
     * @return void
     */
    public function toggleFavourite(Contact $contact)
    {
        $contact->update(['is_favourite' => !$contact->is_favourite]);
    }


    /**
     * Сохранить новый контакт
     * @param array $validatedData
     * @return void
     */
    public function storeContact(array $validatedData)
    {

        $user = auth()->user();

        $model = $this->model->fill($validatedData + ['user_id' => $user->id]);
        $user->contacts()->save($model);

    }

    /**
     * Обновить существующий контакт
     * @param array $validatedData
     * @param Contact $contact
     * @return void
     */
    public function updateContact(array $validatedData, Contact $contact)
    {
        $contact->update($validatedData);
    }

    /**
     * Удалить существующий контакт
     * @param Contact $contact
     * @return void
     */
    public function deleteContact(Contact $contact)
    {
        $contact->delete();
    }

}

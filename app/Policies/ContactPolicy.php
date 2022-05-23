<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contact $contact
     * @return bool
     */
    public function view(User $user, Contact $contact): bool
    {
        return $this->commonCRUDcheck($user, $contact);
    }

    /**
     * Determine whether the user can edit the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contact $contact
     * @return bool
     */
    public function edit(User $user, Contact $contact): bool
    {
        return $this->commonCRUDcheck($user, $contact);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contact $contact
     * @return bool
     */
    public function update(User $user, Contact $contact): bool
    {
        return $this->commonCRUDcheck($user, $contact);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contact $contact
     * @return bool
     */
    public function delete(User $user, Contact $contact): bool
    {
        return $this->commonCRUDcheck($user, $contact);
    }

    /**
     * Возвращает результат проверки принадлежности записи пользователю
     *
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    private function commonCRUDcheck(User $user, Contact $contact): bool
    {
        return $user->id === $contact->user_id;
    }
}

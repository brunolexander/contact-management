<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Factory as Validator;
use Illuminate\View\Factory as View;

class ContactService
{
    public function __construct(
        protected Contact $contact,
        protected Validator $validator,
        protected View $view
    ) {}

    /**
     * Get registered contacts
     */
    public function contactList(): Collection
    {
        return $this->contact->all();
    }

    /**
     * Add contact
     */
    public function createContact($data)
    {
        $validated = $this->validator->validate($data, [
            'name' => 'required|max:60',
            'email' => 'required|email|max:200|unique:contacts,email',
            'contact' => 'required|digits:9'
        ], [
            'name' => 'The name field is required.',
            'name.max' => 'The name must not exceed 60 characters.',
            'email' => 'The email field must be valid.',
            'email.max' => 'The email must not exceed 200 characters.',
            'email.unique' => 'The given email is already in use.',
            'contact' => 'The contact field is required.',
            'contact.digits' => 'The contact field must be 9 digits.'
        ]);

        $contact = $this->contact->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
        ]);

        return ['html' => $this->view->make('components.contact', $contact)->render()];
    }
}
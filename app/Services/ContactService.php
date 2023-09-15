<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Factory as Validator;
use Illuminate\View\Factory as View;
use Illuminate\Validation\Rule;

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
    public function createContact($data): array
    {
        $validated = $this->validator->validate($data, [
            'name' => 'required|max:60',
            'email' => ['required', 'email', 'max:200', Rule::unique('contacts', 'email')->whereNull('deleted_at')],
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

    /**
     * Edit contact
     */
    public function updateContact($data): array
    {
        $validated = $this->validator->validate($data, [
            'id' => 'required|int',
            'name' => 'required|max:60',
            'email' => ['required', 'email', 'max:200', Rule::unique('contacts', 'email')->whereNot('id', $data['id'])],
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

        $contact = $this->contact->findOrFail($validated['id']);
        $contact->name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->contact = $validated['contact'];
        $contact->save();

        return ['html' => $this->view->make('components.contact', $contact)->render()];
    }

    /**
     * Soft delete contact
     */
    public function deleteContact($data): array
    {
        $validated = $this->validator->validate($data, [
            'id' => 'required|int'
        ]);

        $contact = $this->contact->findOrFail($validated['id']);
        $contact->delete();

        return ['message' => 'Contact deleted successfully.'];
    }
}
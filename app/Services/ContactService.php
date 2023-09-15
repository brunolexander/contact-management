<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    public function __construct(
        protected Contact $contact 
    ) {}

    /**
     * Get registered contacts
     */
    public function contactList(): Collection
    {
        return $this->contact->all();
    }
}
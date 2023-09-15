<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\View\Factory as View;

class ContactController extends Controller
{
    public function __construct(
        protected View $view,
        protected ContactService $contact_service
    ) {}

    public function index()
    {
        return $this->view->make('contacts', [
            'contacts' => $this->contact_service->contactList()
        ]);
    }
}

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

    public function index(Request $request)
    {
        return $this->view->make('contacts', [
            'contacts' => $this->contact_service->contactList()
        ]);
    }

    public function create(Request $request)
    {
        return $this->contact_service->createContact($request->input());
    }

    public function save(Request $request)
    {
        return $this->contact_service->updateContact($request->input());
    }

    public function destroy(Request $request)
    {
        return $this->contact_service->deleteContact($request->input());
    }
}

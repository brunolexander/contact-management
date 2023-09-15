@extends('layouts.app')

@section('title', 'Home')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/contacts.css') }}">

@endsection

@section('content')

@csrf

<nav class="navbar bg-body-tertiary navbar-expand mb-5">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="/login"><i class="fa-solid fa-right-to-bracket fa-sm"></i> Login</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Welcome, {{ auth()->user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/logout"><i class="fa-solid fa-power-off fa-sm"></i> Logout</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h3 class="mb-4">Contact List</h3>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control search-contact" placeholder="Search...">
                </div>
                
                {{-- Only allows adding contacts if logged in --}}
                @auth  
                    <div class="col-auto">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#newContactModal" class="btn btn-primary">
                            <i class="fa-solid fa-add"></i> Add new
                        </button>
                    </div>
                @endauth
            </div>
        </div>

        <div class="card-body">
            <ul class="list-group contact-list-filtered"></ul>

            <ul class="list-group contact-list d-none">
                @forelse ($contacts as $contact)
                    @include('components.contact', $contact)
                @empty
                    <li class="list-group-item text-center has-no-contacts">
                        There are no contacts registered.
                    </li>
                @endforelse
            </ul>
        </div>

    </div>
</div>

{{-- New contact modal --}}
<div class="modal fade" id="newContactModal" tabindex="-1" aria-labelledby="newContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newContactModalLabel">New contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="newContactForm">                    
                    <div class="alert alert-danger text-break" style="display: none" role="alert">
                        <i class="fa-solid fa-circle-xmark fa-lg me-2" ></i> <span class="alert-message"></span>
                    </div>

                    <div class="alert alert-success" style="display: none" role="alert">
                        <i class="fa-solid fa-circle-check fa-lg me-2"></i> The contact was successfully created! 
                    </div>

                    <div class="mb-3">
                        <label for="contactName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="contactName" autocomplete="noautocomplete" maxlength="60">
                    </div>

                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="contactEmail" autocomplete="noautocomplete" maxlength="200">
                    </div>

                    <div class="mb-3">
                        <label for="contactPhone" class="form-label">Contact</label>
                        <input type="text" class="form-control form-input-contact" name="contact" maxlength="9" autocomplete="noautocomplete">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save">Save</button>
                <button type="button" disabled class="btn btn-primary btn-save-loading" style="display: none">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Edit contact modal --}}
<div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editContactModalLabel">Edit contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="editContactForm"> 
                    <input type="number" hidden id="editContactId" name="id">  

                    <div class="alert alert-danger text-break" style="display: none" role="alert">
                        <i class="fa-solid fa-circle-xmark fa-lg me-2" ></i> <span class="alert-message"></span>
                    </div>

                    <div class="alert alert-success" style="display: none" role="alert">
                        <i class="fa-solid fa-circle-check fa-lg me-2"></i> The contact was successfully updated! 
                    </div>

                    <div class="mb-3">
                        <label for="editContactName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="editContactName" autocomplete="noautocomplete" maxlength="60">
                    </div>

                    <div class="mb-3">
                        <label for="editContactEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="editContactEmail" autocomplete="noautocomplete" maxlength="200">
                    </div>

                    <div class="mb-3">
                        <label for="editContactPhone" class="form-label">Contact</label>
                        <input type="text" class="form-control form-input-contact" name="contact" id="editContactPhone" maxlength="9" autocomplete="noautocomplete">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-update">Save</button>
                <button type="button" disabled class="btn btn-primary btn-update-loading" style="display: none">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Delete contact modal --}}
<div class="modal fade" id="deleteContactModal" tabindex="-1" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteContactModalLabel">Delete contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">Are you sure you want to delete this contact?</div>

                <div class="alert alert-danger text-break" style="display: none" role="alert">
                    <i class="fa-solid fa-circle-xmark fa-lg me-2" ></i> <span class="alert-message"></span>
                </div>

                <div class="alert alert-success" style="display: none" role="alert">
                    <i class="fa-solid fa-circle-check fa-lg me-2"></i> The contact was successfully deleted! 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-delete">Delete</button>
                <button type="button" disabled class="btn btn-danger btn-delete-loading" style="display: none">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('js/contacts.js') }}"></script>

@endsection
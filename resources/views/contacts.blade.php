@extends('layouts.app')

@section('title', 'Home')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/contacts.css') }}">

@endsection

@section('content')

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

        <div class="card-body contact-list">
            <ul class="list-group">
                @forelse ($contacts as $contact)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto pe-0">
                                <img src="{{ asset('img/user.png') }}" alt="Phone icon" class="contact-image">
                            </div>

                            <div class="col">
                                <h6 class="mb-0">{{ $contact->name }}</h6>
                                <small>
                                    <i class="fa-solid fa-envelope fa-sm"></i> {{ $contact->email }}
                                    &nbsp;<br class="d-md-none">
                                    <i class="fa-solid fa-phone fa-sm"></i> {{ $contact->contact }}
                                </small>
                            </div>

                            {{-- Only allows removing contacts if logged in --}}
                            @auth  
                                <div class="col-auto">
                                    <button type="button" value="{{ $contact->id }}" class="btn btn-light btn text-danger btn-delete-contact" title="Delete contact">
                                        <i class="fa-solid fa-trash-can fa-lg"></i>
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-center">
                        There are no contacts registered.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="newContactModal" tabindex="-1" aria-labelledby="newContactModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="newContactModalLabel">New contact</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="#" method="POST" id="newContactForm">
                @csrf
                
                <div class="alert alert-danger" style="display: none" role="alert">
                    <i class="fa-solid fa-circle-xmark fa-lg me-2" ></i> <span class="alert-message"></span>
                </div>

                <div class="alert alert-success" style="display: none" role="alert">
                    <i class="fa-solid fa-circle-check fa-lg me-2"></i> The contact was successfully created! 
                </div>

                <div class="mb-3">
                    <label for="contactName" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="contactName">
                </div>

                <div class="mb-3">
                    <label for="contactEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="contactEmail">
                </div>

                <div class="mb-3">
                    <label for="contactPhone" class="form-label">Contact</label>
                    <input type="number" class="form-control" name="contact" id="contactPhone">
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

@endsection

@section('scripts')

<script src="{{ asset('js/contacts.js') }}"></script>

@endsection
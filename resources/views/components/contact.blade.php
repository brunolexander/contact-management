<li class="list-group-item" data-id="{{ $id }}" data-name="{{ $name }}" data-email="{{ $email }}" data-contact="{{ $contact }}">
    <div class="row align-items-center">
        <div class="col-auto pe-0">
            <img src="{{ asset('img/user.png') }}" alt="Phone icon" class="contact-image">
        </div>

        <div class="col">
            <h6 class="mb-0">{{ $name }}</h6>
            <small>
                <i class="fa-solid fa-envelope fa-sm"></i> {{ $email }}
                &nbsp;<br class="d-md-none">
                <i class="fa-solid fa-phone fa-sm"></i> {{ $contact }}
            </small>
        </div>

        {{-- Only allows removing and editing contacts if logged in --}}
        @auth  
            <div class="col-auto">
                <button type="button" class="btn btn-light btn text-success btn-edit-contact" title="Edit contact">
                    <i class="fa-solid fa-pen fa-lg"></i>
                </button>

                <button type="button" value="{{ $id }}" class="btn btn-light btn text-danger btn-delete-contact" title="Delete contact">
                    <i class="fa-solid fa-trash-can fa-lg"></i>
                </button>
            </div>
        @endauth
    </div>
</li>
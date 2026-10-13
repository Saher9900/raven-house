@if(session('success'))
    <div class="container flash-raven">
        <div class="alert alert-raven-success alert-dismissible fade show rounded-4 mb-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="{{ __('website.general.close') }}"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container flash-raven">
        <div class="alert alert-raven-error alert-dismissible fade show rounded-4 mb-0" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="{{ __('website.general.close') }}"></button>
        </div>
    </div>
@endif

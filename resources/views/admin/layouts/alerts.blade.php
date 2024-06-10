@if(session()->get('warning'))
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        {{ session()->get('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->get('info'))
    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
        {{ session()->get('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->get('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session()->get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->get('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session()->get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

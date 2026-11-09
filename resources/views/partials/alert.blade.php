@if(session()->has('success'))
    <div class="alert alert-success alert-auto-hide">
        {{ session()->get('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-auto-hide">
        {!! session()->get('error') !!}
    </div>
@endif

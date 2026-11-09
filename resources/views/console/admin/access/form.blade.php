<div class="col-sm-12 col-12 col-md-12">
    <div class="form-group mb-3">
        <label for="name">Name</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Input Name" value="{{ old('name') ?? (!isset($admin) ? '' : $admin->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="email">E-Mail</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Input E-Mail" value="{{ old('email') ?? (!isset($admin) ? '' : $admin->email) }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="password">Password</label>
        <div class="input-group" id="show_hide_password">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Input Password">
            <div class="input-group-addon">
                <button type="button" class="btn btn-secondary" id="togglePassword">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                </button>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function(event) {
                event.preventDefault();

                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "fa-eye-slash" );
                    $('#show_hide_password i').removeClass( "fa-eye" );
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "fa-eye-slash" );
                    $('#show_hide_password i').addClass( "fa-eye" );
                }
            });
        });
    </script>
@endpush
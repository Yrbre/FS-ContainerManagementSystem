<div class="col-lg-6">
    <div class="form-group mb-3">
        <label for="name">Nama</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama user" value="{{  old('name') ?? (!isset($admin) ? '' : $admin->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="username">Username</label>
        <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{  old('username') ?? (!isset($admin) ? '' : $admin->username) }}">
        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Input Email" value="{{  old('email') ?? (!isset($admin) ? '' : $admin->email) }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    

    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" value="">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="confirm_password">Konfirmasi Password</label>
        <input name="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" placeholder="Konfirmasi password" value="">
        @error('confirm_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    


    <div class="form-group mb-3">
        <label for="Role">Role</label>
        <select class="form-select @error('role') is-invalid @enderror" name="role" aria-label="Default select example">
            
            @isset($admin->role)
                <option value="" disabled>Pilih Role ...</option>
                @foreach ($roles as $r)
                    <option value="{{ $r }}" {{ $r == $admin->role ? 'selected' : '' }}>{{ $r }}</option>  
                @endforeach
            @else
                <option value="" disabled selected>Pilih Role ...</option>
                @foreach ($roles as $r)
                    <option value="{{ $r }}" >{{ $r }}</option>  
                @endforeach

                

            @endisset
            
        </select>
        @error('role')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="col-lg-6">

    <div class="form-group mb-3">
        <label for="signature">Tanda Tangan</label>
        <input name="signature" type="file" class="form-control @error('signature') is-invalid @enderror" id="signature" placeholder="Token" value="{{  old('signature') ?? (!isset($admin) ? '' : $admin->signature) }}">

        {{-- isset file signature --}}
        @isset($admin->signature)
            <div class="mt-3">
                <img src="{{ url($admin->signature) }}" alt="" class="rounded" width="150" height="150">
            </div>
        @endisset


        @error('signature')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>


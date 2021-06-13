@extends('auth.layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="text-center">
            <a href="{{ route('home') }}" class="mb-5 d-block auth-logo">
                Sistem Informasi Penggajian
            </a>
        </div>
    </div>
</div>
<div class="row align-items-center justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Selamat Datang !</h5>
                    <p class="text-muted">Silahkan Login Untuk Masuk.</p>
                </div>
                <div class="p-2 mt-4">
                    <form method="POST" action="{{ route('auth') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Enter username">
                            @if($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="userpassword">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" name="password" placeholder="Enter password" autocomplete="current-password">
                            @if($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="mt-3 text-end">
                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

        <div class="mt-5 text-center">
            <p>© <script>document.write(new Date().getFullYear())</script> Sistem Informasi Penggajian</p>
        </div>

    </div>
</div>

@endsection

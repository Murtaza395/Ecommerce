@extends('layouts.main')
@section('main')
    <center class="bg-dark">
        <div class="h3 text-light py-2">Login Form</div>
    </center>
    <section>
        <div class="card container">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-header">
                <h2 class="text-center fst-italic"><span>Welcome</span><br>Please Login first!</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6">
                        @if (file_exists(public_path('images/favicon.png')))
                            <img src="{{ asset('images/favicon.png') }}" alt="store" height="400px" width="100%">
                        @else
                            <p>Image Not found</p>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="d-flex justify-content-center align-items-center" style="height:350px;">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <P class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="pass"
                                            class="form-control @error('password') is-invalid @enderror">
                                        <button type="button" id="passBtn"><i class="fa-solid fa-eye-slash mt-2"
                                                id="passIcon"></i></button>
                                        @error('password')
                                            <P class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group">
                                        <input type="submit" value="Login" class="form-control btn btn-primary mt-3">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="row mt-3">
                                            <label for="remember">Remember Me</label>
                                            <input type="checkbox" id="remember" name="remember">
                                        </div>
                                        <a href="{{ route('emailPage') }}">Forget Password?</a>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <p class="mt-3">Don't have an account? <a href="{{ route('register') }}">Register
                                                here</a></p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('showPass')
    <script>
        $(document).ready(function() {
            $("#passBtn").on("click", (e) => {
                e.preventDefault();
                var a = $("#pass");
                var icon = $("#passIcon");
                if (a.attr("type") === 'password') {
                    a.attr("type", 'text');
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                } else {
                    a.attr("type", "password");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                }
            })
        });
    </script>
@endPush

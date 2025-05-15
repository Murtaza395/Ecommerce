@extends('layouts.main')
@section('main')
<section>
    <div class="card container">
        <div class="card-header">
            <h2 class="text-center fst-italic"><span>Welcome!</span><br>Reset Your Password!</h2>
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
                    <div class="d-flex justify-content-center align-items-center" style="height:250px">
                        <form action="{{route('password.update')}}" method="POST">
                            @csrf
                        <div class="row">
                            <input type="hidden" name="token" value="{{ request()->token }}">
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="pass" class="form-control @error('password') is-invalid @enderror">
                                <button type="button" id="passBtn"><i class="fa-solid fa-eye-slash mt-2"
                                        id="passIcon"></i></button>
                                        @error('password')
                                        <P class="invalid-feedback"> {{$message}} </p>
                                    @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="cPass"
                                    class="form-control @error('password_confirmation') is-invalid @enderror">
                                <button type="button" id="cPassbtn"><i class="fa-solid fa-eye-slash mt-2"
                                        id="cPassicon"></i></button>
                                        @error('password_confirmation')
                                        <P class="invalid-feedback"> {{$message}} </p>
                                    @enderror
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" value="Update Password" class="form-control btn btn-primary mt-3">
                        </div>

                    </form>
                </div>
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
     $("#cPassbtn").on("click", (e) => {
         e.preventDefault();
         var pass = $("#cPass");
         var cIcon = $("#cPassicon");
         if (pass.attr("type") === 'password') {
             pass.attr("type", 'text');
             cIcon.removeClass("fa-eye-slash").addClass("fa-eye");
         } else {
             pass.attr("type", "password");
             cIcon.removeClass("fa-eye").addClass("fa-eye-slash");
         }
     })
 })
</script>
@endpush
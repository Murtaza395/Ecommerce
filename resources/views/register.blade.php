@extends('layouts.main')
@section('main')
    <header>
        @if(!empty($message))
        {{$message}}
        @endif
        <center class="container">
            <h1 class="text-light bg-dark font-bold p-1">Register Yourself</h1>
        </center>
    </header>
    <section>
        <div class="card container">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
    
            @endif
            <div class="card-header">
                <h2 class="text-center fst-italic"><span>welcome!</span><br>Please Register first!</h2>
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
                        <form action="{{route('store')}}" method="post">
                            @csrf
                            <div class="row">
                                <label for="f-name" class="form-label">First Name</label>
                                <div class="input-group">
                                <input type="text" name="f_name" value="{{old('f_name')}}" class="form-control @error('f_name') is-invalid @enderror">
                                @error('f_name')
                                    <P class="invalid-feedback"> {{$message}} </p>
                                @enderror
                                    </div>
                            </div>
                            <div class="row">
                                <label for="l-name" class="form-label">Last Name</label>
                                <div class="input-group">
                                <input type="text" name="l_name" class="form-control @error('l_name') is-invalid @enderror">
                                @error('l_name')
                                <P class="invalid-feedback"> {{$message}} </p>
                            @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                            </div>
                                <span id="emailError"></span>
                                @error('email')
                                <P class="invalid-feedback"> {{$message}} </p>
                            @enderror

                            </div>
                            <div class="row">
                                <label for="password" class="form-label">Password</label>
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
                             <div class="input-group">
                                <input type="submit" value="Signup" class="form-control btn btn-primary mt-3">
                            </div>
                            </div>

                        </form>
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
   
    $("#email").on('blur',function(){
        var emailVal= $('#email').val();
        if(emailVal.length > 0){
        $.ajax({
            url: "{{route('email.check')}}",
            method:'get',
            data: {email:emailVal},
            success: function(result){
                if(result.status===false){
                    $('#emailError').html('');
                    $('#emailError').html(result.message).addClass("text-danger");
                }
                else{
                    $('#emailError').html('');
                    $('#emailError').html(result.message).removeClass("text-danger").addClass("text-success");
                }
            },
            error: function(xhr) {
                    var errorMessage = xhr.responseJSON?.message || "Something went wrong!";
                    $('#emailError')
                        .html(errorMessage)
                        .removeClass("text-success")
                        .addClass("text-danger");
                }
        })
    }
    })
    })
</script>
@endpush
{{-- @vite(['resources/js/echo.js']) --}}
<script>
window.Echo.channel('message').listen('RealtimeMsg',(event)=>{
    console.log(event);
})
</script>
<script>
    function setLanguage(locale) {
        // Send an asynchronous request to the server to set the language
        fetch(`/lang/${locale}`)
            .then(response => {
                if (response.ok) {
                    // Reload the page to apply the language change
                    window.location.reload();
                } else {
                    console.error('Failed to set the language');
                }
            });
    }
</script>

</body>

</html>

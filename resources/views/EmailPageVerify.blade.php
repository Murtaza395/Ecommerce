<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>General Store App</title>
</head>

<body>
    <main>
        <center class="bg-dark py-2">
            <p class="text-light fs-4">Please Verify your Email</p>
        </center>
        <section class="d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-4 col-sm-6 col-lg-4 col-10"> 
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <h3>Enter your Email here</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('emailVer')}}" method="post">
                            @csrf
                        <input type="email" name="email" class="form-control text-center" placeholder="Enter your email" required>
                        @if(Session::has('error'))
                        <p class="invalid-feedback d-block">{{Session::get('error')}}</p>
                        @endif
                        <input type="submit" value="Submit" class="form-control btn btn-info rounded-3 mt-3">
                    </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;1,400&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            background: url(https://images.unsplash.com/photo-1520995075477-7fddc4fc8cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1953&q=80) center/cover #004494;
            position: relative
        }
    </style>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>Learning Activity</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-5 shadow p-5 rounded bg-white">
                <h5>Welcome to Learning Activity</h5>

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible mt-2" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('auth.check') }}" method="post">
                    @csrf
                    <div class="form-floating my-3">
                        <input type="text" name="email" class="form-control form-control-sm" id="email"
                            placeholder="Username" value="{{ old('email') }}">
                        <label for="email">email : admin@mail.com</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control form-control-sm" id="pwd"
                            placeholder="Password">
                        <label for="pwd">password : admin</label>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary d-block">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

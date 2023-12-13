<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Core css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <!-- CSS only -->
</head>
<body>
        <div class="app">
            <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
                <div class="d-flex flex-column justify-content-between w-100">
                    <div class="container d-flex justify-content-center h-100">
                        <div class="row align-items-center w-100">
                            <div class="col-md-7 col-lg-6 m-h-auto m-0 p-0">
                                <div class="card shadow-lg">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between m-b-30">
                                            <h2 class="m-b-0">Sign In</h2>
                                            <img width="120px" class="img-fluid" alt="" src="assets/images/logo/logo.png">
                                        </div>
                                        <form action="{{route('login')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="font-weight-semibold" for="userName">Username:</label>
                                                <div class="input-affix">
                                                    <i class="prefix-icon anticon anticon-user"></i>
                                                    <input type="text" class="form-control" name="username" id="userName" placeholder="Username">
                                                </div>
                                                @error('username')
                                                    <small class="text-danger">{{$message}}</small>                                                
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-semibold" for="password">Password:</label>
                                                <div class="input-affix m-b-10">
                                                    <i class="prefix-icon anticon anticon-lock"></i>
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                                </div>
                                                @error('password')
                                                    <small class="text-danger">{{$message}}</small>                                                
                                                @enderror
                                                <a class="float-right font-size-13 text-muted" href="">Forget Password?</a>
                                                
                                            </div>
                                            <div class="form-group mt-5">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                                </div>
                                            </div>
                                            <center>
                                                <a class="float-center font-size-13 text-muted" href="{{route('signup')}}">Create an account.</a>
                                            </center>
                                            @if (session())
                                            <center>
                                                <p class="text-danger">
                                                    {{session('status')}}
                                                </p>
                                            </center>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-flex p-h-40 justify-content-center">
                        <span class="">© 2022 Olive</span>
                        {{-- <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-dark text-link" href="">Legal</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-dark text-link" href="">Privacy</a>
                            </li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
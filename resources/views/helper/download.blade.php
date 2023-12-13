<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download Olive App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .section-body{
            position: absolute; top:50%; left:50%; 
            transform: translate(-50%, -50%);
        }
        .row{
            margin-top: 30px;
        }
        .card{
            width: 200px;
            text-align: center;
            border-radius: 5px;
        }
        
        .card .card-body i{
            font-size: 40px;
            color: rgb(51, 51, 51);
        }
        .card .card-body a{
            font-size: 1.2rem;
            text-decoration: none;
        }
        img{
            max-width: 120px !important;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="main-content container">
        <section class="section ">
            <div class="section-body">
                <div class="text-center">
                    <img alt="image" src="{{asset('admin/assets/img/logo.png')}}">
                </div>
                
                <div class="text-center container">
                    <p style="color: rgb(39, 131, 39)">Download Olive App from...</p>
                </div>
                
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <i class="fab fa-apple" style="color: rgb(179, 198, 194)"></i>
                                <br>
                                <a href="{{$iosUrl}}">App Store</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <i class="fab fa-android" style="color: rgb(33, 197, 164)"></i>
                                <br>
                                <a href="{{$playUrl}}">Google Play</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
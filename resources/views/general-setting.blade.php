@extends('layouts.header')
@section('pagetitle', 'Settings')
@section('maincontent')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
       
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Settings</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        
                        {{-- Privacy Policy --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Privacy Policy</h4>
                                <button class="btn btn-primary rounded" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body collapse" id="collapseExample">
                                <form action="{{url('updatesetting')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$privacy->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title (Not changable)</label>
                                                <input type="text" name="title" value="{{$privacy->title}}" class="form-control" readonly placeholder="Ex : Privacy Policy">
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select type="text" name="status" class="form-control">
                                                    <option @if ($privacy->status == 1) selected @endif value="1">Active</option>
                                                    <option @if ($privacy->status == 0) selected @endif value="0">Deactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Summary</label>
                                            <textarea name="summary" class="summernote-simple" style="display: none;">{{$privacy->description}}</textarea>
                                            <span class="text-danger">
                                                @error('summary')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Terms & Conditions --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Terms & Conditions</h4>
                                <button class="btn btn-primary rounded" type="button" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample" id="collapse2">
                                    <i class="fas fa-plus"></i>
                                </button>
                                {{-- <button class="btn btn-primary rounded" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add User</button> --}}
                            </div>
                            <div class="card-body collapse" id="collapseExample1">
                                <form action="{{url('updatesetting')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$tnc->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" readonly name="title" class="form-control" value="{{$tnc->title}}" placeholder="Ex : Terms & Conditions">
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select type="text" name="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Summary</label>
                                            <textarea name="summary" class="summernote-simple" style="display: none;">{{$tnc->description}}</textarea>
                                            <span class="text-danger">
                                                @error('summary')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- About App --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>About</h4>
                                <button class="btn btn-primary rounded" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample" id="collapse3">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body collapse" id="collapseExample2">
                                <form action="{{url('updatesetting')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$about->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" readonly class="form-control" value="{{$about->title}}" placeholder="Ex : About us">
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select type="text" name="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Summary</label>
                                            <textarea name="summary" class="summernote-simple" style="display: none;">{{$about->description}}</textarea>
                                            <span class="text-danger">
                                                @error('summary')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Play Store App url --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Playstore App URL</h4>
                                <button class="btn btn-primary rounded" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample" id="collapse4">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body collapse" id="collapseExample4">
                                <form action="{{url('updatesetting')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$play->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" readonly class="form-control" value="{{$play->title}}" placeholder="Ex :https/playstore.google.com/">
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select type="text" name="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>URL</label>
                                            <input class="form-control" required name="summary" class="mb-3" value="{{$play->description}}" placeholder="Ex :https://playstore.google.com/"/>
                                            
                                            <span class="text-danger">
                                                @error('summary')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- IOS App url --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>App Store URL</h4>
                                <button class="btn btn-primary rounded" type="button" data-toggle="collapse" data-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample" id="collapse5">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body collapse" id="collapseExample5">
                                <form action="{{url('updatesetting')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$ios->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" readonly class="form-control" value="{{$ios->title}}" >
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select type="text" name="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                              <div class="form-group">
                                                <label>URL</label>
                                                <input class="form-control" required name="summary" class="mb-3" value="{{$ios->description}}" placeholder="Ex :https://store.apple.com/">
                                                <span class="text-danger">
                                                    @error('summary')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                              </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- IOS App url --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>App QR code</h4>
                                <button class="btn btn-primary rounded" type="button" data-toggle="collapse" data-target="#collapseExample6" aria-expanded="false" aria-controls="collapseExample" id="collapse6">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body collapse" id="collapseExample6">
                                <form action="{{url('updatesetting')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$app_qr->id}}" name="id">
                                    <input type="hidden" name="status" value="1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" readonly class="form-control" value="{{$app_qr->title}}" >
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                              <div class="form-group">
                                                <label>URL</label>
                                                <input class="form-control" required name="summary" class="mb-3" value="{{$app_qr->description}}" placeholder="Ex :https://store.apple.com/">
                                                <span class="text-danger">
                                                    @error('summary')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                              </div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <div class="text-center">
                                                <p id="printarea" style="display:flex;justify-content: center; align-items:center; vertical-align:middle; padding:50px; width: 100%; ">
                                                    {!! QrCode::size(250)->generate($app_qr->description); !!}
                                                </p>
                                                <span id="btnConvert" onclick="downloadimage()" class="btn btn-outline-primary mb-2">Download</span>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row d-flex justify-content-center">
                                        
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Change link
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <script>
        function downloadimage() {
            /*var container = document.getElementById("image-wrap");*/ /*specific element on page*/
            var container = document.getElementById("printarea");; /* full page */
            html2canvas(container, { allowTaint: true }).then(function (canvas) {

                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "Olive_qr.jpg";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }
    </script>
    <script>
        $('#collapse').click(function() {
            $("i", this).toggleClass("fa-minus fa-plus");
        });
        $('#collapse2').click(function() {
            $("i", this).toggleClass("fa-minus fa-plus");
        });
        $('#collapse3').click(function() {
            $("i", this).toggleClass("fa-minus fa-plus");
        });
        $('#collapse4').click(function() {
            $("i", this).toggleClass("fa-minus fa-plus");
        });
        $('#collapse5').click(function() {
            $("i", this).toggleClass("fa-minus fa-plus");
        });
        $('#collapse6').click(function() {
            $("i", this).toggleClass("fa-minus fa-plus");
        });
    </script>

@endsection

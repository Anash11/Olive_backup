@extends('layouts.header')
@section('pagetitle','Add Banner')
@section('maincontent')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Banner</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Add Banner</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <form action="{{url('/addbanner')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label>Select Seller</label>
                                            <select class="form-control" name="seller_id" id="">
                                                <option selected value="">Select store</option>
                                                @foreach ($sellers as $seller)
                                                    <option value="{{ $seller->id }}">{{ $seller->business_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('image') {{$message}} @enderror</span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control">
                                                <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Banner Image</label>
                                            <input type="file" name="image" class="form-control">
                                            <span class="text-danger">@error('image') {{$message}} @enderror</span>
                                        </div>
                                        <div class="form-group col-md-12 col-12 mb-2">
                                          <label>Description</label>
                                          <textarea type="text" class="summernote-simple" style="display: none;" name="description" ></textarea>
                                          
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    {{-- End main section --}}
@endsection
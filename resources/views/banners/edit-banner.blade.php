@extends('layouts.header')
@section('pagetitle','Edit Banner')
@section('maincontent')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Banner</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit Banner</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <form action="{{url('/updatebanner')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$banner->id}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="../{{$banner->image}}" title="{{$banner->name}}" alt="{{$banner->name}}" style="max-height: 120px" class="img-thumbnail">
                                        </div>

                                        <div class="col-md-12 mb-3 mt-3">
                                            <label>Select Seller</label>
                                            <select class="form-control" name="seller_id" id="">
                                                <option value="">Select store</option>
                                                @foreach ($sellers as $seller)
                                                    <option @if ($seller->id == $banner->seller_id) selected @endif value="{{ $seller->id }}">{{ $seller->business_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('image') {{$message}} @enderror</span>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="name" value="{{$banner->name}}" class="form-control">
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
                                          <textarea type="text" class="summernote-simple" style="display: none;" name="description" >{{$banner->description}} </textarea>
                                          
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
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
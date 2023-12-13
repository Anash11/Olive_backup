@extends('layouts.header')
@section('pagetitle','Add Category')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Category</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit Category</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <form action="{{url('/updatecategory')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="FK_admin_id" value="1" id="">
                                <input type="hidden" name="id" value="{{$category->id}}" id="">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" value="{{$category->title}}" class="form-control">
                                                <span class="text-danger">@error('title') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Category Image</label>

                                                <input type="file" name="image" class="form-control">
                                                {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}
                                                <span class="text-danger">@error('image') {{$message}} @enderror</span>

                                        </div>
                                        <div class="col-md-12">
                                            <label>Summary</label>
                                            <textarea name="summary" class="summernote-simple" style="display: none;">
                                                {{$category->summary}}
                                            </textarea> 
                                            <span class="text-danger">@error('summary') {{$message}} @enderror</span>

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
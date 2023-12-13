@extends('layouts.header')
@section('pagetitle','Manage Default Image')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Default Image</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Manage Default Image</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <form action="{{url('/adddefaultimg')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select type="text" name="cat_id" class="form-control defaultImg">
                                                    <option selected disabled value="">Select category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->title}}</option> 
                                                    @endforeach
                                                </select>
                                                
                                                <span class="text-danger">@error('cat_id') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Category Default Image</label>

                                                <input type="file" name="image" class="form-control" >
                                                {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}
                                                <span class="text-danger">@error('image') {{$message}} @enderror</span>

                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <h5 id="preview">Preview </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="img_div">
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    {{-- End main section --}}

    <script>
    $(document).ready(function() {
        // get images
        $(document).on('change', '.defaultImg', function(e) {
            e.preventDefault();
            var cat_id = $(this).val();
            $('#img_div').html('');

            // alert(cat_id);
            $.ajax({
                type: 'GET',
                url: "{{url('/category/default/all')}}"+"/"+ cat_id ,
                success: function(data) {
                        data.forEach(element => {

                        var img = element.image;
                        $('#img_div').append('<div class="col-md-4 mb-5">'+
                                            '<button style="position: absolute; right:0; top:-10px;" value="'+element.id+'" class="btn btn-primary" id="deleteImg"><i class="fas fa-times text-white"></i></button>'+
                                            '<img width="100%" src="/'+img+'" alt="">'+
                                        '</div>'); 

                        });
                    
                }
            });
        });

        // delete image
        $(document).on('click', '#deleteImg', function(e) {
            e.preventDefault();
            var cat_id = $(this).val();

            // alert(cat_id);
            $.ajax({
                type: 'GET',
                url: "{{url('/category/default/delete')}}"+"/"+ cat_id ,
                success: function(data) {
                    window.location.reload();
                    toastr.success(data.success); 
                }
            });
        });
    });
    </script>
@endsection
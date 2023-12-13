@extends('layouts.header')
@section('pagetitle','Banners')
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Banners</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Banners</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Banners</h4>
                            <a href="{{url('addbanner')}}" class="btn btn-primary rounded"><i class="fas fa-plus"></i> Add Banner</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Seller Name</th>
                                    <th>Banner</th>
                                    <th>created_at</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td>{{$banner->name}}</td>
                                            <td>{{$banner->seller->business_name??'N/A'}}</td>
                                            <td><img width="30px" class="rounded" height="30px" src="{{asset($banner->image)}}" alt=""></td>
                                            <td>{{$banner->created_at}}</td>
                                            <td>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" @if ($banner->status == 1) checked @endif class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{url('editbanner/'.$banner->id)}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{url('deletebanner/'.$banner->id)}}" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" ><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                               
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection
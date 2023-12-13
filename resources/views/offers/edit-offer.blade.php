@extends('layouts.header')
@section('pagetitle','Edit Offer')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Offer</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit Category</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card pt-5">   
                            <center>
                                                    
                            <div class="container mb-4 table-responsive-md">
                                <h1>Offer Details</h1>
                                <table class="">
                                    <tbody>
                                        <tr>
                                            <td><b>Seller: </b></td>
                                            <td>{{$offer->seller->business_name}}</td>
                                        </tr>
                                        <tr>
                                        <td><b>Contact: </b></td>
                                            <td>{{$offer->seller->business_phone}}, <a href="mailto:{{$offer->seller->business_email}}">{{$offer->seller->business_email}}</a></td>
                                        </tr>
                                        <tr>
                                        <td><b>Offer Type</b></td>
                                        <td>{{$offer->offer_type}}</td>
                                    </tr>
                                        <tr>
                                            <td><b>Offer Title</b></td>
                                            <td>{{$offer->offer_title}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Offer Detail</b></td>
                                            <td>{{$offer->offer_description}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Offer Duration</b></td>
                                            <td>{{$offer->offer_start_date}} - {{$offer->offer_end_date}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            </center>   
                            <form action="{{url('/edit-offer')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="FK_admin_id" value="1" id="">
                                <input type="hidden" name="id" value="{{$offer->id}}" id="">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Offer Title</label>
                                                <input type="text" name="offer_title" value="{{$offer->offer_title}}" class="form-control">
                                                <span class="text-danger">@error('offer_title') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Offer Type</label>
                                                <input type="text"  name="offer_type" value="{{$offer->offer_type}}" class="form-control">
                                                <span class="text-danger">@error('offer_type') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Offer Priority</label>
                                                <select name="offer_priority" class="form-control">
                                                    <option @if($offer->offer_priority == 1) selected @endif value="1">High</option>
                                                    <option @if($offer->offer_priority == 0) selected @endif value="0">Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Offer Description</label>
                                            <textarea name="offer_description"   class="form-control mb-3"  >{{$offer->offer_description}}</textarea> 
                                            <span class="text-danger">@error('offer_description') {{$message}} @enderror</span>

                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                            Update 
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
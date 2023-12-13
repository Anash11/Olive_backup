@extends('layouts.header')
@section('pagetitle','Dashboard')
@section('maincontent')
{{-- {{dd(Session::get('loginId'))}} --}}
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Dashboard</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total User</h4>
                    </div>
                    <div class="card-body">
                        {{$userall->count()}}
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total Shop</h4>
                    </div>
                    <div class="card-body">
                        {{$seller->count()}}
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total offer given</h4>
                    </div>
                    <div class="card-body">
                    {{$offers->count()}}
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-light">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total category</h4>
                    </div>
                    <div class="card-body">
                    {{$category->count()}}
                    </div>
                </div>
                </div>
            </div> 
            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total city</h4>
                    </div>
                    <div class="card-body">
                    47
                    </div>
                </div>
                </div>
            </div>  

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total state</h4>
                    </div>
                    <div class="card-body">
                    47
                    </div>
                </div>
                </div>
            </div>     
              
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-secondary">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total listing</h4>
                    </div>
                    <div class="card-body">
                    47
                    </div>
                </div>
                </div>
            </div>  
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                    <h4>Total Admin</h4>
                    </div>
                    <div class="card-body">
                    47
                    </div>
                </div>
                </div>
            </div>       --}}
        </div>


        <div class="row">
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                <div class="card">
                <div class="card-header">
                    <h4>Recent Activities</h4>
                </div>
                <div class="card-body">             
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach ($notifications as $notification)
                        <li class="media">
                            <div class="media-body">
                            {{-- <div class="media-title">Farhan A Mujib</div> --}}
                            <span class=" text-muted">{!!$notification->message!!}</span>
                            <div class="float-right text-primary text-small">{{$notification->created_at}}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="text-center pt-1 pb-1">
                    <a href="{{url('notifications')}}" class="btn btn-primary btn-lg btn-round">
                        View All
                    </a>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                <div class="card">
                <div class="card-header">
                    <h4>Latest Users</h4>
                    <div class="card-header-action">
                    <a href="{{url('users')}}" class="btn btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>State</th>
                        </tr>
                        </thead>
                        <tbody> 
                            {{-- {{$allcategory}} --}}
                            @if ($users->count() > 0)
                                
                            @foreach ($users as $item)
                            <tr>
                                <td>
                                {{$item->name}}
                                
                                </td>
                                <td>
                                    {{$item->phone_no}}
                                
                                </td>
                                <td>
                                    {{$item->state}}
                                </td>
                            </tr>
                            @endforeach 
                                
                            @else
                                <tr >
                                    <td colspan='3' align="center">No data</td>
                                </tr>
                            @endif
                                                   
                        
                        
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </section>
      </div>
@endsection
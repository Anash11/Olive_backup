@extends('layouts.header')
@section('pagetitle','Users')
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Users</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Users</h4>
                            {{-- <button class="btn btn-primary rounded" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add User</button> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($users as $user)
                                    <tr>
                    
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a> </td>
                                        <td>{{$user->address_info}}, {{$user->city}}, {{$user->state}}</td>
                                        <td>
                                            <div class="form-group">
                                                <label class="custom-switch">
                                                  <input type="checkbox" {{$user->status? 'checked':''}} disabled name="custom-switch-checkbox" class="custom-switch-input">
                                                  <span class="custom-switch-indicator"></span>
                                                </label>
                                              </div>
                                        </td>
                                        <td>
                                            <a href="{{url('edituser/'.$user->id)}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            {{-- <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a> --}}
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
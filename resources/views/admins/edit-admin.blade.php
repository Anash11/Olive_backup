@extends('layouts.header')
@section('pagetitle','Add Admins')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Admin</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit Admin</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        
                            <div class="card-body">
                                <form action="{{url('/editadmin/'.$data->id)}}" method="post">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="username" value="{{$data->name}}" class="form-control">
                                                    <span class="text-danger">@error('username') {{$message}} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                        <i>+91</i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="phone_no" value="{{$data->phone_no}}"  class="form-control phone-number">
                                                    </div>
                                                    <span class="text-danger">@error('phone_no') {{$message}} @enderror</span>
    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-phone"></i>
                                                        </div>
                                                        </div>
                                                        <input type="email" name="email" value="{{$data->email}}"  class="form-control phone-number">
                                                    </div>
                                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Admin Type</label>
                                                    <select name="admin_type" class="form-control">
                                                      <option value="admin">Admin</option>
                                                      <option value="super-admin">Super Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Admin Status</label>
                                                    <select name="status" class="form-control">
                                                      <option 
                                                       value="1">Active</option>
                                                      <option {{ ($data->status) == '0' ? 'selected' : '' }} value="0">Deactive</option>
                                                    </select>
                                                    
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input type="text" name="state" value="{{$data->state}}"  class="form-control purchase-code">
                                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="city" value="{{$data->city}}"  class="form-control purchase-code">
                                                    <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="text" placeholder="YYYY-MM-DD" name="dob" value="{{$data->dob}}"  class="form-control datepicker">
    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Adhar No</label>
                                                    <input type="text" minlength="12" maxlength="12" value="{{$data->adhar_no}}"  name="adhar" class="form-control">
                                                    <span class="text-danger">@error('adhar') {{$message}} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Area of Operation</label>
                                                    <input type="text" value="{{$data->area_of_operation}}"  name="area_oper" class="form-control">
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
            </div>

        </section>
    </div>
    {{-- End main section --}}
@endsection
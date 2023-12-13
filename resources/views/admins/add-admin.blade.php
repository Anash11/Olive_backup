@extends('layouts.header')
@section('pagetitle','Add Admins')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Admin</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Add Admin</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <form action="{{url('/addadmin')}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">

                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="username" value="{{old('username')}}" class="form-control">
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
                                                <input type="text" name="phone_no" value="{{old('phone_no')}}" class="form-control phone-number">
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
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    </div>
                                                    <input type="email" name="email" value="{{old('email')}}" class="form-control phone-number">
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
                                                <label>State</label>
                                                <input type="text" name="state" value="{{old('state')}}" class="form-control purchase-code">
                                                <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" value="{{old('city')}}" class="form-control purchase-code">
                                                <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="text" placeholder="YYYY-MM-DD" name="dob" class="form-control datepicker">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Adhar No</label>
                                                <input type="number" maxlength="16" name="adhar_no" class="form-control">
                                                <span class="text-danger">@error('adhar_no') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Area of Operation</label>
                                                <input type="text" value="{{old('area_oper')}}" name="area_oper" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    </div>
                                                    <input type="password" name="password" class="form-control pwstrength" data-indicator="pwindicator">
                                                </div>
                                                <span class="text-danger">@error('password') {{$message}} @enderror</span>

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
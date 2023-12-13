@extends('layouts.header')
@section('pagetitle','Edit User')
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">User</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>User Status</h4>
                            </div>
                            <div class="card-body border-top border-bottom">
                                <form action="{{url('updateuser')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Change Status</label>
                                                <select name="status" class="form-control">
                                                    <option @if ($user->status == 1) selected @endif value="1" selected="">Active</option>
                                                    <option @if ($user->status == 0) selected @endif value="0">Deactive </option>
                                                </select>
                                            </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Account Status</label>
                                                    <select name="deleted_at" class="form-control">
                                                        <option @if ($user->deleted_at  == null) selected @endif value="" selected="">Active</option>
                                                        <option @if ($user->deleted_at) selected @endif value="{{now()}}">Deactive </option>
                                                    </select>
                                                </div>
                                            </div>
                                        {{-- <div class="col-md-6"></div> --}}
                                        
                                        
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class=" col-6 col-md-4 ">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Update status
                                            </button>
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
@endsection
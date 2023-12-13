@extends('layouts.header')
@section('pagetitle',"FAQ's")
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>FAQ's</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">FAQ's</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>FAQ's</h4>
                            <a href="{{url('faq/add')}}" class="btn btn-primary rounded"><i class="fas fa-plus"></i> Add faq</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($faqs as $faq)
                                    <tr>
                    
                                        <td>{{$faq->question}}</td>
                                        <td>{{$faq->answer}}</td>
                                    
                                        <td>
                                            <div class="form-group">
                                                <label class="custom-switch">
                                                  <input type="checkbox" {{$faq->status? 'checked':''}} disabled name="custom-switch-checkbox" class="custom-switch-input">
                                                  <span class="custom-switch-indicator"></span>
                                                </label>
                                              </div>
                                        </td>
                                        <td style="width:100px;">
                                            <a href="{{url('faq/edit/'.$faq->id)}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="{{url('faq/delete/'.$faq->id)}}" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>
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
@extends('layouts.header')
@section('pagetitle', 'Edit FAQ')
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit FAQ</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit FAQ</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        {{-- Faq's --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Edit FAQ</h4>
                                {{-- <button class="btn btn-primary rounded" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add User</button> --}}
                            </div>
                            <div class="card-body">
                                <form action="{{url('faq/update')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$faq->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input type="text" name="question" value="{{$faq->question}}" class="form-control">
                                                <span class="text-danger">
                                                    @error('question')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Answer</label>
                                                <textarea type="text" name="answer" rows="3" class="form-control">{{$faq->answer}}</textarea>
                                                <span class="text-danger">
                                                    @error('answer')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select type="text" name="status" class="form-control">
                                                    <option @if ($faq->status == 1) selected @endif value="1">Active</option>
                                                    <option @if ($faq->status == 0) selected @endif value="0">Deactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Update
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

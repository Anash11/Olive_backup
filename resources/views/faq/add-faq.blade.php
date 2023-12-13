@extends('layouts.header')
@section('pagetitle', 'FAQ')
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
                        {{-- Faq's --}}
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>FAQ's</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{url('faq/store')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input type="text" name="question" class="form-control">
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
                                                <textarea type="text" name="answer" rows="5" class="form-control"></textarea>
                                                <span class="text-danger">
                                                    @error('answer')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

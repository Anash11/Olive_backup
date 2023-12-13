@extends('layouts.header')
@section('pagetitle','Categories')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Categories</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Categories</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Categories</h4>
                           <div>
                            <a href="{{url('category/default/add')}}" class="btn btn-outline-primary rounded"><i class="fas fa-plus"></i> Add Default image</a>
                                <a href="{{url('addcategory')}}" class="btn btn-primary rounded"><i class="fas fa-plus"></i> Add Category</a>
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Summery</th>
                                    <th>Status</th>
                                    {{-- @if ($admin_type == 'super-admin') --}}
                                    <th>Action</th>
                                    {{-- @endif --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $item)
                                    <tr>
                                        <td>{{$item->title}}</td>

                                        <td>
                                            <img style="width: 50px; height:50px; border-radius:25px;" src="{{  $item->image_url }}" />
                                        </td>

                                        <td>{!! $item->summary !!}</td>
                                        <td>
                                            <div class="form-group">
                                                <label class="custom-switch">
                                                  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" disabled {{$item->active == '1' ? 'checked' : ''}}>
                                                  <span class="custom-switch-indicator"></span>
                                                </label>
                                              </div>
                                        </td>
                                        <td>
                                            {{-- @if ($item->admin_type == 'super-admin') --}}
                                                <a href="{{url('editcategory/'. $item->id)}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                {{-- <a href="{{url('deletecategory/'. $item->id)}}" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a> --}}
                                                <button class="btn btn-danger btn-action editStatus" value="{{$item->id}}" data-toggle="tooltip" title="Update status"><i class="fas fa-unlock"></i></button>

                                                
                                            {{-- @endif --}}
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

    {{-- End main section --}}
    {{-- Modal status --}}
    <div class="modal fade" id="edit_status" data-bs-backdrop="static" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            {{-- <form action="{{ url('customer/updateStatus') }}" method="post"> --}}
                {{-- @csrf --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update status</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <input type="hidden" id="hiddenstatus">
                    <div class="modal-body mb-0 pb-0">

                        <input type="hidden" name="cat_id" id="cat_id">
                        <div class="form-group">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="statusUpdate" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            {{-- </form> --}}

        </div>
        <!-- /.modal-dialog -->
    </div>


    <script>
           $(document).ready(function() {
        $(document).on('click', '.editStatus', function(e) {
            e.preventDefault();
            var cat_id = $(this).val();
            // console.log(cat_id);
            $('#edit_status').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{url('category/status')}}"+"/"+ cat_id ,
                success: function(data) {
                    $('#status').val(data.category.active);
                    $('#hiddenstatus').val(data.category.active);
                    $('#cat_id').val(data.category.id);
                    // console.log(data);
                }
            });
        });
    });


    var hiddenstatus = $('#hiddenstatus').val();
    var status = $('#status').val();
    if (hiddenstatus == 1) {
        $("#status").prop("selected", true)
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#statusUpdate").click(function(e){
        // console.log('text');
        e.preventDefault();

        // var status = $("#status").val();
        // var id = $("#id").val();

        let status = $("select[name=status]").val();
        let id = $("input[name=cat_id]").val();

        $.ajax({
           type:'POST',
           url:"{{ route('update.category.status') }}",
           data:{
            "_token": "{{ csrf_token() }}",
            active:status,
            id:id
            },
           success:function(data){
                $('#edit_status').modal('hide');
                window.location.reload();
                toastr.success(data.success);
           }
        });

    });
   

    </script>
@endsection
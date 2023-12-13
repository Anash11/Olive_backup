@extends('layouts.header')
@section('pagetitle','Admins')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admins</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Admins</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header d-md-flex justify-content-end">
                            <a href="{{url('addadmin')}}" class="btn btn-primary rounded"><i class="fas fa-plus"></i> Add Admin</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    {{-- @if ($admin_type == 'super-admin') --}}
                                        <th>Action</th>
                                    {{-- @endif --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->phone_no}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>
                                            <div class="form-group">
                                                <label class="custom-switch">
                                                  <input type="checkbox" 
                                                   onchange="updateStatus(this,{{$item->id}},this.checked)"
                                                   name="custom-switch-checkbox" class="custom-switch-input"  {{$item->status == '1' ? 'checked' : ''}}>
                                                  <span class="custom-switch-indicator"></span>
                                                </label>
                                              </div>
                                        </td>
                                        <td>
                                            @if ($admin_data->admin_type == 'super-admin')
                                                {{-- <a class="btn btn-info btn-action mr-1" id="show_admin" data-url="{{ route('admindata', $item->id) }}"  data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a> --}}
                                                <a href="{{url('editadmin/'. $item->id)}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{url('deleteadmin/'. $item->id)}}" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>
                                            @endif
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
    <script>
        function updateStatus(op, id, status) {
        let newStatus = status ? "Active" : "Inactive";
        let isConfirmed = confirm("Do you want to change status to " + newStatus);
        op.checked = isConfirmed? op.checked:!op.checked ;
        if(isConfirmed){
          $.ajax({
            url: "/update-admin-status",
            type: "POST",
            data:  JSON.stringify({
                status: status ? 1 : 0,
                id: id,
            }),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            contentType: "application/json; charset=utf-8",
            success: function(data) {
               (!data.status)?alert('Somthing Went Wrong'):'';
            },
        });
      }
    }
    </script>
    {{-- End main section --}}
    <div class="modal fade" id="adminShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Show User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p><strong>ID:</strong> <span id="user-id"></span></p>
              <p><strong>Name:</strong> <span id="user-name"></span></p>
              <p><strong>Email:</strong> <span id="user-email"></span></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    <script type=text/javascript>
      $(document).ready(function () {
       
       /* When click show user */
        $('show_admin').on('click', function () {
          var userURL = $(this).data('url');
        //   console.log(userURL);
          $.get(userURL, function (data) {
              $('#adminShowModal').modal('show');
              $('#user-id').text(admin.);
              $('#user-name').text(data.name);
              $('#user-email').text(admin.email);
          })
       });
       
    });
      
      </script>

@endsection
@extends('layouts.header')
@section('pagetitle','Offers')
@section('maincontent')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Offers</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="#">Dashboard</a>
                </div>
                <div class="breadcrumb-item">Offers</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Offers</h4>
                            <a href="#" onclick="dropIfExpire()" class="btn btn-danger rounded"><i class="fas fa-trash"></i> Delete Expired Offer</a>
                        </div>
                        <script>
                            function dropIfExpire(){
                                let isConfirmed = confirm('Are you want to delete expired offers');
                                if(isConfirmed){
                                    navigation.navigate('/drop-expire-offer')
                                }
                            }
                        </script>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>Business Name</th>
                                            <th>Offer Type</th>
                                            <th>Offer Title</th>
                                            <th>Create</th>
                                            <th>Start - End</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($offers as $offer)
                                        <tr>
                                            <td>
                                                {{$offer->seller->business_name}}
                                            </td>
                                            <td>{{$offer->offer_type}}</td>
                                            <td>{{$offer->offer_title}}</td>
                                            <td>{{$offer->created_at}}</td>

                                            <td>
                                                {{date('d-m-Y' ,strtoTime($offer->offer_start_date))}} - {{date('d-m-Y' ,strtoTime($offer->offer_end_date))}}
                                            </td>

                                            @csrf
                                            <td>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input
                                                        type="checkbox"
                                                        onchange="updateStatus(this,{{$offer->id}},this.checked)"
                                                        {{($offer->offer_status=='Active')?'checked':''}}
                                                        name="custom-switch-checkbox"
                                                        class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-action mr-1" onclick="showDetails({{$offer->id}})" data-bs-toggle="modal" data-bs-target="#exampleModal" title="View"><i class="fas fa-eye"></i></a>
                                                <a class="btn btn-primary btn-action mr-1" href="/edit-offer/{{$offer->id}}"  title="Edit" ><i
                                                        class="fas fa-pencil-alt"
                                                    ></i
                                                ></a>
                                                
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

{{-- User modal --}}
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" role="dialog" id="exampleModal"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Offer Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="container" id="offerData"></div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>

    function updateStatus(op, id, status) {
        status = status ? "Active" : "Inactive";
        let isConfirmed = confirm("Do you want to change status to " + status);
        op.checked = isConfirmed? op.checked:!op.checked ;
        if(isConfirmed){
          $.ajax({
            url: "/update-offer-status",
            type: "POST",
            data:  JSON.stringify({
                status: status,
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
    function showDetails(id){
        $.get('/offer/'+id,(data)=>{
            let offer = data.data;
            let contant = `
            <div class="table-responsive-md">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><b>Seller: </b></td>
                            <td>${offer.seller.business_name}</td>
                        </tr>
                        <tr>
                           <td><b>Contact: </b></td>
                            <td>${offer.seller.business_phone}, <a href="mailto:${offer.seller.business_email}">${offer.seller.business_email}</a></td>
                        </tr>
                        <tr>
                           <td><b>Offer Type</b></td>
                           <td>${offer.offer_type}</td>
                       </tr>
                        <tr>
                            <td><b>Offer Title</b></td>
                            <td>${offer.offer_title}</td>
                        </tr>
                        <tr>
                            <td><b>Offer Detail</b></td>
                            <td>${offer.offer_description}</td>
                        </tr>
                         <tr>
                            <td><b>Offer Duration</b></td>
                            <td>${offer.offer_start_date} - ${offer.offer_end_date}</td>
                        </tr>

                    </tbody>
                </table>
            </div>`;
            $('#offerData').html(contant);
        })
    }
</script>
@endsection
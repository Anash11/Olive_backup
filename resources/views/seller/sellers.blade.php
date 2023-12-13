@extends('layouts.header') 
@section('pagetitle','Sellers')
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sellers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Sellers</div>
                </div>
            </div>
            <div class="section-body">
                
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Sellers</h4>
                            <a href="{{url('addseller')}}" class="btn btn-primary rounded"><i class="fas fa-plus"></i> Add seller</a>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                            <th>Business Contact</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sellers as $seller)
                                        <tr>
                                            
                                            <td>
                                               <img src="{{$seller->shop_logo_url}}" alt="{{$seller->business_name}} logo" width="30px" height="30px" class="rounded">
                                              
                                            </td>
                                            <td>
                                                {{$seller->business_name}}
                                            </td>
                                            <td>{{$seller->category->title}}</td>
                                            <td> {{$seller->business_phone}}, <a href="mailto:{{$seller->business_email}}">{{$seller->business_email}}</a></td>
                                            @csrf
                                            <td>
                                                @php
                                                    $color = '';
                                                    if($seller->status == 'Active')
                                                        $color = 'badge-primary';
                                                    else if($seller->status == 'Inactive')
                                                        $color = 'badge-danger';
                                                    else
                                                        $color = 'badge-warning';
                                                @endphp
                                               <span class="badge {{$color}}">
                                                {{$seller->status}}
                                               </span>
                                            </td>
                                            <td>
                                                <a  href="#" class="btn btn-info btn-action mr-1" onclick="showDetails({{$seller->id}})" data-bs-toggle="modal" data-bs-target="#exampleModal" title="View"><i class="fas fa-eye"></i
                                                ></a>
                                                <a class="btn btn-primary btn-action mr-1" href="/edit-seller/{{$seller->id}}"  title="Edit" ><i
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


{{-- Seller Info --}}
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" role="dialog" id="exampleModal"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seller Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="container" id="sellerData"></div>
            <div class="modal-footer bg-whitesmoke br">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function(){
    //     $('.mclose').on('click', function(){
    //         $('.modal').hide();
    //     })
    // })
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
        $.get('/seller/'+id,(data)=>{
            let seller = data.message;
            console.log(seller);
            let contant = `
            <div class="container">
                <div class="data mt-3">
                    <div class="row mb-4">
                        <div class="col-6"><b>Business Name :</b></div>
                        <div class="col-6">${seller.business_name}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6"><b>Category :</b></div>
                        <div class="col-6">${seller.category.title}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6"><b>Contact :</b></div>
                        <div class="col-6">${seller.business_phone}, ${seller.shop_contact},<a href="mailto:${seller.business_email}">${seller.business_email}</a></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6"><b>Address :</b></div>
                        <div class="col-6"> ${seller.area?seller.area+',':''} ${seller.address?seller.address+',':''} ${seller.zip}, ${seller.state}</div>
                    </div>
                </div>
            </div> 
            

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="${seller.shop_cover_image}" alt="" class="img-fluid img-thumbnail" width="200px">                
                        <a href="${seller.shop_cover_image}" download="${seller.business_name}_cover">Shop Cover</a> 
                    </div>
                    <div class="col-md-4">
                        <img src="${seller.shop_logo_url}" alt="" class="img-fluid img-thumbnail" width="200px"> <br>                          
                        <a href="${seller.shop_logo_url}" download="${seller.business_name}_logo">Shop Logo</a>  
                    </div>
                    <div class="col-md-4">
                        <img src="${seller.document_img_url}" alt="" class="img-fluid img-thumbnail" width="200px">                            
                        <a href="${seller.document_img_url}" download="${seller.business_name}_doc">Download from here</a>    
                    </div>
                </div>
            </div>
                `;
            $('#sellerData').html(contant);
        })
    }
</script>
@endsection
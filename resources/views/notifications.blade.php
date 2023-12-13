@extends('layouts.header')
@section('pagetitle','Notifications')
@section('maincontent')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Notifications of <span id="noteFor"></span></h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Notifications</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Notifications</h4>
                                <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg nav-link-user">
                                  Change to <i class="dropdown-toggle"></i>
                                  {{-- {{$loginId ?? ''->name}} --}}
                                  <div class="dropdown-menu dropdown-menu-right">
                    
                                    {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                                    <a href="{{url('notifications/')}}" class="dropdown-item has-icon">
                                      <i class="far fa-user"></i> Sellers
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>
                                    <a href="{{url('notifications/offer')}}" class="dropdown-item has-icon">
                                      <i class="fas fa-sign-out-alt"></i> Offers
                                    </a>
                                  </div>
                                
                            </div>
                            <div class="card-body border-top border-bottom" id="notific">
                               

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                          <script>
                    
                function timeSince(date) {

                      var seconds = Math.floor((new Date() - date) / 1000);

                      var interval = seconds / 31536000;

                      if (interval > 1) {
                        return Math.floor(interval) + " years";
                      }
                      interval = seconds / 2592000;
                      if (interval > 1) {
                        return Math.floor(interval) + " months";
                      }
                      interval = seconds / 86400;
                      if (interval > 1) {
                        return Math.floor(interval) + " days";
                      }
                      interval = seconds / 3600;
                      if (interval > 1) {
                        return Math.floor(interval) + " hours";
                      }
                      interval = seconds / 60;
                      if (interval > 1) {
                        return Math.floor(interval) + " minutes";
                      }
                        return Math.floor(seconds) + " seconds";
                      }
                function showNotificationFuntion(forThe ='Seller',count=10){
                    $.get(`/notifications/get/${forThe}/${count}`,(data)=>{
                      let contant = ``;
                      data.forEach(element => {
                        element.created_at = new Date(element.created_at);
                        element.created_at = timeSince(element.created_at)+' ago.';
                        contant += `
                         <div class="activity-detail border-bottom pt-2 ${element.status == 1?'': 'bg-success'}">
                                    <div class="mb-2">
                                      <span class="text-job text-primary">${(element.created_at)}</span>
                                      <span class="bullet"></span>
                                      <a class="text-job" href="#"> ${element.status == 1?'Seen':'Unseen'}</a>
                                      <div class="float-right dropdown">
                                        <a href="#" class="dropdown-item has-icon" onclick="changeStatus(${element.id})"><i class="fas fa-eye"></i> Mark as seen</a>
                                      </div>
                                    </div>
                                    <p>${element.message}</p>
                          </div>`;
                      });
                        if(data.length == 0)
                        contant = '<center>Not notification found for '+forThe +' </center>';
                        $('#notific').html(contant);
                        $('#noteFor').html(forThe);
                    })
                }
                function changeStatus(id){
                    $.ajax({
                      url: "/update-notification-status",
                      type: "POST",
                      data:  JSON.stringify({
                          id: id,
                      }),
                      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                      contentType: "application/json; charset=utf-8",
                      success: function(data) {
                        console.log(data);
                      showNotificationFuntion('{{$note}}','{{$count}}') ;                        
                      },
                  }); 
                  
                }
                showNotificationFuntion('{{$note}}','{{$count}}') ;
       
              </script>
        </section>
    </div>

@endsection
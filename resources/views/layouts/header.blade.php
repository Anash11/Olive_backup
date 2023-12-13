<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('pagetitle')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/img/logo2.png')}}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/jqvmap/dist/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/weather-icon/css/weather-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/jquery-selectric/selectric.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Template CSS -->

    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/components.css')}}">
    <!-- Start GA -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
     {{-- toastr --}}
     <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

    <style>
        .headerlogo img{
            max-width: 80px;
            width: 100%;
        }
        .headerlogo2 img{
            max-width: 40px;
            width: 100%;
        }

        /* toast r */
        #toast-container > .toast::before {
            content: " " !important;
        }
    </style>
</head>

<body>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            {{-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> --}}
          </ul>
          {{-- <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
              <div class="search-header">
                Histories
              </div>
              <div class="search-item">
                <a href="#">Search name</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
            </div>
          </div> --}}
        </form>
        <ul class="navbar-nav navbar-right">
          {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('admin/assets/img/avatar/avatar-1.png')}}" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b>
                    <p>Hello, Bro!</p>
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('admin/assets/img/avatar/avatar-2.png')}}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Dedik Sugiharto</b>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="admin/assets/img/avatar/avatar-3.png" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Agung Ardiansyah</b>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="admin/assets/img/avatar/avatar-4.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Ardian Rahardiansyah</b>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                    <div class="time">16 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="admin/assets/img/avatar/avatar-5.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Alfa Zulkarnain</b>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                    <div class="time">Yesterday</div>
                  </div>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li> --}}
          <li class="dropdown dropdown-list-toggle"><a href="#" onclick="showNotificationFun()" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
          <div class="dropdown-menu dropdown-list dropdown-menu-right">
            {{-- <a href="" onclick="changeStatus()">Mark As Seen</a> --}}
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
                  function showNotificationFun(){
                      $.get('/show-notification',(data)=>{
                        let contant = ``;
                        data.forEach(element => {
                          element.created_at = new Date(element.created_at);
                          element.created_at = timeSince(element.created_at)+' ago.';
                          let route = element.message.match(/offer/i)? '/offers':'/sellers' ;
                          contant += `<a href="${route}" title="Click to Mark as Seen." onclick="changeStatus(${element.id})" class="dropdown-item  ${element.status == 1 ? '':'bg-success'}">
                                <div class="dropdown-item-icon bg-info text-white">
                                  <i class="far fa-user"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                  ${element.message}
                                  <div class="time">${(element.created_at)} </div>

                                </div>
                              </a>`;
                        });
                          
                          $('#note').html(contant);
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
                          
                        },
                    }); 6
                    showNotificationFun();
                  }
        
                </script>
                <div class="dropdown-header">Notifications
                  <div class="float-right">
                    <a href="" onclick="changeStatus()">Mark As Read</a>
                  </div>
                </div>
                @csrf
                <div class="dropdown-list-content dropdown-list-icons">
                  <div id="note">

                  </div>
                  
                </div>
                <div class="dropdown-footer text-center">
                  <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </li>
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{asset('admin/assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Hi,
                @if(Session::has('loginId'))
                    {{ Session::get('loginId')}}
                @endif
              </div></a>
              {{-- {{$loginId ?? ''->name}} --}}
              <div class="dropdown-menu dropdown-menu-right">

                {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                <a href="{{url('profile')}}" class="dropdown-item has-icon">
                  <i class="far fa-user"></i> Profile
                </a>
                

                <div class="dropdown-divider"></div>
                <a href="{{url('logout')}}" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <div class="main-sidebar sidebar-style-2">
          <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
              <a class="headerlogo" href="#">
                  <img alt="image" src="{{asset('admin/assets/img/logo.png')}}" class="img-fluid">
              </a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
              <a class="headerlogo2" href="#">
                  <img alt="image" src="{{asset('admin/assets/img/logo2.png')}}" class="img-fluid">
              </a>
            </div>
            <ul class="sidebar-menu">
              <li class="menu-header">Main</li>
              <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{url('/dashboard')}}"><i class="fas fa-th"></i> <span>Dashboard</span></a></li>
              
              {{-- @if(Session::get('admin_type')->admin_type == 'super-admin' && Session::get('status')->status == 1) --}}
              @if(Session::has('loginId'))
                  @php
                    $superAdmin = App\Models\Admin::where('email',Session::get('loginId'))->get()[0];
                    $isSuperAdmin = $superAdmin->admin_type == 'super-admin';
                    $isSuperAdminstatus = $superAdmin->status == 1;

                  @endphp
              @endif
            {{-- @endif --}}
            {{-- {{ dd(Session('status'))}} --}}
            @if($isSuperAdmin && $isSuperAdminstatus)
              <li class="{{ request()->is('admins','addadmin') ? 'active' : '' }}"><a class="nav-link" href="{{url('/admins')}}"><i class="fas fa-user"></i> <span>Admins</span></a></li>   
            @endif
            <li class="{{ request()->is('sellers') ? 'active' : '' }}"><a class="nav-link" href="{{url('/sellers')}}"><i class="fas fa-home"></i> <span>Sellers</span></a></li>
            <li class="{{ request()->is('categories') ? 'active' : '' }}"><a class="nav-link" href="{{url('/categories')}}"><i class="fas fa-box"></i> <span>Categories</span></a></li>
            <li class="{{ request()->is('users') ? 'active' : '' }}"><a class="nav-link" href="{{url('/users')}}"><i class="fas fa-users"></i> <span>Users</span></a></li>
            <li class="{{ request()->is('offers') ? 'active' : '' }}"><a class="nav-link" href="{{url('/offers')}}"><i class="fas fa-fire"></i> <span>Offers</span></a></li>
            <li class="{{ request()->is('banners') ? 'active' : '' }}"><a class="nav-link" href="{{url('/banners')}}"><i class="fas fa-th-large"></i> <span>Pramotional Banners</span></a></li>
            <li class="{{ request()->is('appsettings') ? 'active' : '' }}"><a class="nav-link" href="{{url('/appsettings')}}"><i class="fas fa-columns"></i> <span>General Settings</span></a></li>
            <li class="{{ request()->is('faq') ? 'active' : '' }}"><a class="nav-link" href="{{url('/faq')}}"><i class="fas fa-info"></i> <span>FAQ's</span></a></li>
            <li class="{{ request()->is('notifications') ? 'active' : '' }}"><a class="nav-link" href="{{url('/notifications')}}"><i class="fas fa-bell"></i> <span>Notifications</span></a></li>



            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="{{url('logout')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                  Logout
              </a>
            </div>        
          </aside>
        </div>

        {{-- Main content --}}
        @yield('maincontent')

        {{-- Footer --}}
        @include('layouts.footer')
      </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('admin/assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/popper.js')}}"></script>
  <script src="{{asset('admin/assets/modules/tooltip.js')}}"></script>
  <script src="{{asset('admin/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/moment.min.js')}}"></script>
  <script src="{{asset('admin/assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  <script src="{{asset('admin/assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/chart.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{asset('admin/assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('admin/assets/js/page/index-0.js')}}"></script>
  <script src="{{asset('admin/assets/js/page/modules-datatables.js')}}"></script>
  <script src="{{asset('admin/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{asset('admin/assets/modules/jquery-selectric/jquery.selectric.min.js')}}"></script>
  
  <!-- Template JS File -->
  <script src="{{asset('admin/assets/js/scripts.js')}}"></script>
  <script src="{{asset('admin/assets/js/custom.js')}}"></script>

  <!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script>
  $(document).ready(function() {
    toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "60000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
      // toastr.options.timeOut = 10000;
      @if (Session::has('failed'))
          toastr.error('{{ Session::get('failed') }}');
      @elseif(Session::has('success'))
          toastr.success('{{ Session::get('success') }}');
      @endif
  });

</script>
</body>
</html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Forget — olive</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/img/logo2.png')}}">
  
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/fontawesome/css/all.min.css')}}">
  
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/bootstrap-social/bootstrap-social.css')}}">
  
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/components.css')}}">
  <!-- Start GA -->
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
  
    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA --></head>
  
  <body>
    <div id="app">
      <section class="section">
        <div class="container mt-5">
          <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
              <div class="login-brand">
                <img src="admin/assets/img/logo.png" alt="logo" width="100" height="100" class="shadow-light rounded-circle bg-white">
              </div>
  
              <div class="card card-primary">
                <div class="card-header"><h4>Forget Password</h4></div>
  
                <div class="card-body">
                  <form action="{{ route('forget.password.post') }}" method="post">
                    @csrf

                    @if(Session::get('failed'))
                        <div class="alert alert-danger">
                            {{Session::get('failed')}}
                        </div>
                    @endif
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" value="{{old('email')}}" tabindex="1" required="" autofocus="">
                      <span class="text-danger">@error('email') {{$message}} @enderror</span>

                    </div>
  
                    <div class="form-group">
                        <a href="{{url('/login')}}">Go to login.</a>
                    </div>
  
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Send Link
                      </button>
                    </div>
                  </form>
                  
  
                </div>
              </div>
              
              <div class="simple-footer">
                Copyright © Olive 2022
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  
    <!-- General JS Scripts -->
    <script src="assets/modules/jquery.min.js"></script>
    <script src="assets/modules/popper.js"></script>
    <script src="assets/modules/tooltip.js"></script>
    <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="assets/modules/moment.min.js"></script>
    <script src="assets/js/stisla.js"></script>
    
    <!-- JS Libraies -->
  
    <!-- Page Specific JS File -->
    
    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
  <!-- Code injected by live-server -->
  <script type="text/javascript">
      // <![CDATA[  <-- For SVG support
      if ('WebSocket' in window) {
          (function () {
              function refreshCSS() {
                  var sheets = [].slice.call(document.getElementsByTagName("link"));
                  var head = document.getElementsByTagName("head")[0];
                  for (var i = 0; i < sheets.length; ++i) {
                      var elem = sheets[i];
                      var parent = elem.parentElement || head;
                      parent.removeChild(elem);
                      var rel = elem.rel;
                      if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
                          var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                          elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
                      }
                      parent.appendChild(elem);
                  }
              }
              var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
              var address = protocol + window.location.host + window.location.pathname + '/ws';
              var socket = new WebSocket(address);
              socket.onmessage = function (msg) {
                  if (msg.data == 'reload') window.location.reload();
                  else if (msg.data == 'refreshcss') refreshCSS();
              };
              if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                  console.log('Live reload enabled.');
                  sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
              }
          })();
      }
      else {
          console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
      }
     
  </script>
  </body></html> 

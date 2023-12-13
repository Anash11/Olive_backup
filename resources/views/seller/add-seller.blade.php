@extends('layouts.header')
@section('pagetitle','Add Seller')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Seller</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item">Add Seller</div>
                </div>
            </div>
            
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                             
                          <form action="{{url('/create-seller-user-profile')}}" enctype="multipart/form-data" method="post" id="form2" aria-disabled="true">
                                @csrf
                                
                                <div class="card-body">
                                    <div class="row">
                                
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Name</label>
                                                <input type="text" value="{{old('business_name')}}" name="business_name"  required class="form-control">
                                                <span class="text-danger">@error('business_name') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label>Business Type</label>
                                                <select name="category" class="form-control" required>
                                                    <option value="{{old('category')}}">Select Business Type</option>                                                        
                                                    @foreach (App\Models\Category::all() as $item)
                                                      <option value="{{$item->id}}">{{$item->title}}</option>                                                        
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">@error('business_name') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Owner name</label>
                                                <input type="text" value="{{old('owner_name')}}" name="owner_name" required class="form-control">
                                                <span class="text-danger">@error('owner_name') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Seller personal contact</label>
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <i>+91</i>
                                                    </div>
                                                </div>
                                                <input type="tel" value="{{old('personal_phone')}}"  name="personal_phone" required class="form-control phone-number">
                                                </div>
                                                <span class="text-muted">This number will use to sign-in</span>
                                                <span class="text-danger">@error('personal_phone')<br> {{$message}} @enderror</span>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Contact Number[1] </label>
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <i>+91</i>
                                                    </div>
                                                </div>
                                                <input type="tel" value="{{old('phone1')}}"  name="phone1" class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">@error('phone1')<br> {{$message}} @enderror</span>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Contact Number[2] </label>
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <i>+91</i>
                                                    </div>
                                                </div>
                                                <input type="text" value="{{old('phone2')}}" name="phone2" class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">@error('phone2') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Personal email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    </div>
                                                    <input type="email" value="{{old('personal_email')}}" name="personal_email" class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">@error('personal_email') {{$message}} @enderror</span>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    </div>
                                                    <input type="email" value="{{old('business_email')}}" name="business_email" required class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">@error('business_email') {{$message}} @enderror</span>
                                            </div>
                                        </div>

                                        {{-- Search location--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" id="txtPlace" required class="form-control purchase-code">
                                                <span class="text-muted">Try to get exact address from google map</span>
                                                <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                            </div>
                                        </div>  

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text" name="state" id="txtState" required class="form-control purchase-code">
                                                <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" id="txtCity" class="form-control">
                                                <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                            </div>
                                        </div>    
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Zip</label>
                                                <input type="text" name="zip" id="txtZip" required class="form-control">
                                                <span class="text-danger">@error('zip') {{$message}} @enderror</span>
                                                <div class="text-danger" id="zipmsg"></div>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input id="txtlat" type="text" name="latitude" required class="form-control">
                                                <span class="text-danger">@error('latitude') {{$message}} @enderror</span>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input id="txtlong" type="text" name="longitude" required class="form-control">
                                                <span class="text-danger">@error('longitude') {{$message}} @enderror</span>
                                            </div>
                                        </div>      

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Document</label>
                                                <input type="file" name="document" value="" required class="form-control" accept="image/*">
                                                <span class="text-danger">@error('document') {{$message}} @enderror</span>
                                            </div>
                                        </div>                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shop cover image</label>
                                                <input type="file" name="shop_cover_image" value="" required class="form-control" accept="image/*">
                                                <span class="text-danger">@error('shop_cover_image') {{$message}} @enderror</span>
                                            </div>
                                        </div>                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shop logo</label>
                                                <input type="file" name="shop_logo" value="" required class="form-control purchase-code" accept="image/*">
                                                <span class="text-danger">@error('shop_logo') {{$message}} @enderror</span>
                                            </div>
                                        </div>      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                 <select id="" name="status" required class="form-control">
                                                    <option value="Active" >Active</option>
                                                    <option value="Inactive"  >Inactive </option>
                                                </select>
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
                                </div>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{env('MAP_TOKEN')}}"></script>

    <script>
    // Fetch google location
    google.maps.event.addDomListener(window, 'load', function() {

        var options = {
            
            componentRestrictions: {
                country: ["in"]
            }
        }
        var places = new google.maps.places.Autocomplete(document.getElementById('txtPlace'), options);
        google.maps.event.addListener(places, 'place_changed', function() {
            var place = places.getPlace();
            var address = place.formatted_address;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var latlng = new google.maps.LatLng(latitude, longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'latLng': latlng
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var place = results[0];
                        var pin = "";
                        var state = "";
                        var city = "";
                        // console.log(place.address_components);
                        // console.log(place.address_components.length);

                        for (var i = 0; i < place.address_components.length; i++) {
                            for (var j = 0; j < place.address_components[i].types.length; j++) {

                                // if (place.address_components[i].types[j] == "country") {
                                //     country = place.address_components[i].long_name;
                                // }
                                if (place.address_components[i].types[j] == "postal_code") {
                                    pin = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "locality") {
                                    city = place.address_components[i].long_name;
                                } else if (place.address_components[i].types[j] == "administrative_area_level_2") {
                                    city = place.address_components[i].long_name;
                                } else if (place.address_components[i].types[j] == "administrative_area_level_3") {
                                    city = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "administrative_area_level_1") {
                                    state = place.address_components[i].long_name;
                                }
                            }
                        }

                        // document.getElementById('txtCountry').value = country;
                        document.getElementById('txtState').value = state;
                        document.getElementById('txtCity').value = city;
                        document.getElementById('txtZip').value = pin;
                        document.getElementById('txtlat').value = latitude;
                        document.getElementById('txtlong').value = longitude;
                        checkZip(pin);
                    }
                }
            });
        });


    });
    $("#txtPlace").keyup(function() {
        //get the selected value
        var location = $('#txtPlace').val();
        if(location == ""){
            document.getElementById('txtState').value = "";
            document.getElementById('txtCity').value = "";
            document.getElementById('txtZip').value = "";
            document.getElementById('txtlat').value = "";
            document.getElementById('txtlong').value = "";
        }
    });
    </script>
    {{-- End main section --}}
@endsection
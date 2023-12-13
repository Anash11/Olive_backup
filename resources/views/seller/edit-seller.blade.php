@extends('layouts.header')
@section('pagetitle', 'Edit Seller Details')
@section('maincontent')
    {{-- Main section --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Seller</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Edit Seller</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Seller Details</h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ url('/edit-seller') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $seller->id }}">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Name</label>
                                                <input type="text" value="{{ $seller->business_name }}"
                                                    name="business_name" required class="form-control">
                                                <span class="text-danger">
                                                    @error('business_name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Owner name</label>
                                                <input type="text" value="{{ $seller->owner_name }}" name="owner_name"
                                                    required class="form-control">
                                                <span class="text-danger">
                                                    @error('owner_name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business contact number</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i>+91</i>
                                                        </div>
                                                    </div>
                                                    <input type="text" value="{{ $seller->business_phone }}"
                                                        name="business_phone" required class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">
                                                    @error('business_phone')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number[2]</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i>+91</i>
                                                        </div>
                                                    </div>
                                                    <input type="text" value="{{ $seller->shop_contact }}"
                                                        name="shop_contact"  class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">
                                                    @error('shop_contact')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
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
                                                    <input type="email" value="{{ $seller->business_email }}"
                                                        name="business_email" required class="form-control phone-number">
                                                </div>
                                                <span class="text-danger">
                                                    @error('business_email')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>


                                        {{-- Search --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Search Address</label>
                                                <input type="text" id="txtPlace"  class="form-control purchase-code">
                                                <span class="text-muted">Try to get exact address from google map</span>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" id="txtAddress" value="{{ $seller->address }}" required class="form-control purchase-code">
                                                <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                            </div>
                                        </div>  

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text" name="state" id="txtState" required  value="{{ $seller->state }}" class="form-control purchase-code">
                                                <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Area</label>
                                                <input type="text" name="area" id="getArea" required  value="{{ $seller->area }}" class="form-control">
                                                <span class="text-danger">@error('area') {{$message}} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" id="txtCity" value="{{ $seller->city }}" class="form-control">
                                                <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                            </div>
                                        </div>    
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Zip</label>
                                                <input type="text" name="zip" id="txtZip" value="{{ $seller->zip }}" required class="form-control">
                                                <span class="text-danger">@error('zip') {{$message}} @enderror</span>
                                                <div class="text-danger" id="zipmsg"></div>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input id="txtlat" type="text" name="latitude" required value="{{$seller->latitude}}" class="form-control">
                                                <span class="text-danger">@error('latitude') {{$message}} @enderror</span>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input id="txtlong" type="text" name="longitude" value="{{$seller->longitude}}" required class="form-control">
                                                <span class="text-danger">@error('longitude') {{$message}} @enderror</span>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" name="submit"
                                                class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Seller Status</h4>
                            </div>
                            <div class="card-body border-top border-bottom">
                                <form action="{{ url('/edit-seller-status') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $seller->id }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Change Status</label>
                                                <select id="" name="status" required class="form-control">
                                                    <option value="Reject"
                                                        @if ($seller->status == 'Reject') selected @endif>Reject </option>
                                                    <option value="Active"
                                                        @if ($seller->status == 'Active') selected @endif>Active</option>
                                                    <option value="Inactive"
                                                        @if ($seller->status == 'Inactive') selected @endif>Inactive </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>

                                        <div class="col-md-4">
                                            <button type="submit" name="submit"
                                                class="btn btn-primary btn-lg btn-block btn-icon-split">
                                                Update status
                                            </button>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header d-md-flex justify-content-between">
                                <h4>Seller Opening Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>Seller: </b></td>
                                            <td>{{ $seller->business_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Owner Name: </b></td>
                                            <td>{{ $seller->owner_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Contact: </b></td>
                                            <td>{{ $seller->business_phone }}, <a
                                                    href="mailto:{{ $seller->business_email }}">{{ $seller->business_email }}</a>
                                            </td>
                                        </tr>
                                        @php
                                            $timing = json_decode($seller->weekly_timing);
                                        @endphp
                                        @if ($timing != null)
                                            @foreach ($timing as $item => $itr)
                                                <tr>
                                                    <td><b>{{ $item }}</b></td>

                                                    <td><b>{{ $itr->is_open ? 'OPENED' : 'CLOSED' }}</b></td>
                                                    <td><b>Opening:</b> {{ $itr->open }}</td>
                                                    <td><b>Closeing:</b> {{ $itr->close }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    {{-- End main section --}}

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
                        var area = "";
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
                                if (place.address_components[i].types[j] == "sublocality_level_1") {
                                    area = place.address_components[i].long_name;
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
                        document.getElementById('getArea').value = area;
                        document.getElementById('txtCity').value = city;
                        document.getElementById('txtZip').value = pin;
                        document.getElementById('txtlat').value = latitude;
                        document.getElementById('txtlong').value = longitude;
                        document.getElementById('txtAddress').value = document.getElementById('txtPlace').value;
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
@endsection

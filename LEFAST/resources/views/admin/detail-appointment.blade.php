@extends('layouts.base-admin')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ url('leaflet-machine/leaflet-routing-machine.css') }}" />
       <style>
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .dropify-wrapper .dropify-message p {
            font-size: 14px;
        }

        .tabss {
            padding: 15px;
        }
    </style>
@endsection

@section('menu')
    <li class="menu-item ">
        <a href="/admin" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.product.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Analytics">Product</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.banner.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bxs-image"></i>
            <div data-i18n="Analytics">Banner</div>
        </a>
    </li>

    <li class="menu-item ">
        <a href="{{ route('admin.event.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-event"></i>
            <div data-i18n="Analytics">Events</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.category.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-event"></i>
            <div data-i18n="Analytics">Category</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.auction.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-flag"></i>
            <div data-i18n="Analytics">Auction</div>
        </a>
    </li>


    <li class="menu-item ">
        <a href="{{ route('admin.help-center.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-help-circle"></i>
            <div data-i18n="Analytics">Help Center</div>
        </a>
    </li>

    <li class="menu-item ">
        <a href="{{ route('admin.notifications.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bell"></i>
            <div data-i18n="Analytics">Notification</div>
        </a>
    </li>
@if(Auth::user()->role == 3)
    <li class="menu-item ">
        <a href="{{ route('admin.user.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Analytics">User</div>
        </a>
    </li>
     <li class="menu-item active">
        <a href="{{ route('admin.appointment.index') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics">Appointment</div>
        </a>
    </li>
    @endif
@endsection

@section('content')
    <style>
        .access:hover {
            border: 1px solid #696cff;
            color: #696cff;
            cursor: pointer;
        }

        .access {
            border: 1px solid gray;
        }

        a {
            color: #697a8d;
        }

        .leaflet-right {
            display: none;
        }
    </style>

    <div class="container d-flex mt-5 gap-5">
        <div class="card" style="flex:5">

            <div class="card-body">

                <table class="table table-borderless">
                    <tr>

                        <td colspan="2">
                            <center>
                                <img src="{{ url('thumbAppointment/' . $data->thumb) }}"
                                    style="width:50%;border-radius:10px" alt="">
                            </center>
                        </td>
                    </tr>


 <tr>
                        <td>Name</td>
                        <td>{{ DB::table('users')->where('id', $data->user_id)->first()->name }}</td>
                    </tr>
                     <tr>
                        <td>Email</td>
                        <td>{{ DB::table('users')->where('id', $data->user_id)->first()->email }}</td>
                    </tr>
                    <tr>
                            <td>Phone</td>
                            <td>{{ $data->phone }}</td>
                        </tr>
                           <tr>
                            <td>Schedule</td>
                            <td>{{ date_format(date_create($data->schedule), 'F m, H:i (e)') }}</td>
                        </tr>
                    <tr>
                        <td>Description</td>
                        <td>{!! $data->description !!}</td>
                    </tr>
                    <tr>
                        <td>Latitude</td>
                        <td>{{ $data->latitude }}</td>
                    </tr>
                    <tr>
                        <td>Longitude</td>
                        <td>{{ $data->longitude }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            @if ($data->status == 'pending')
                                <span class="badge bg-label-primary me-1">Pending</span>
                            @elseif($data->status == 'approved')
                                <span class="badge bg-label-success me-1">Approved</span>
                            @else
                                <span class="badge bg-label-danger me-1">Declined</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="width: 100%;height:500px;position:relative">
                                <div id="map" class="map"></div>
                            </div>
                        </td>
                    </tr>

                </table>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script src="{{ url('leaflet-machine/leaflet-routing-machine.js') }}"></script>
    <script src="{{ url('leaflet-machine/Control.Geocoder.js') }}"></script>
    <script src="{{ url('leaflet-machine/config.js') }}"></script>


    <script>
        getLocation();

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {

            $('#lat').val(position.coords.latitude);
            $('#long').val(position.coords.longitude);


            var map = L.map('map');

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var control = L.Routing.control(L.extend(window.lrmConfig, {
                waypoints: [
                    L.latLng(position.coords.latitude, position.coords.longitude),
                    L.latLng({{ $data->latitude }}, {{ $data->longitude }})
                ],
                geocoder: L.Control.Geocoder.nominatim(),
                routeWhileDragging: true,
                reverseWaypoints: true,
                showAlternatives: true,
                altLineOptions: {
                    styles: [{
                            color: 'black',
                            opacity: 0.15,
                            weight: 9
                        },
                        {
                            color: 'white',
                            opacity: 0.8,
                            weight: 6
                        },
                        {
                            color: 'blue',
                            opacity: 0.5,
                            weight: 2
                        }
                    ]
                }
            })).addTo(map);

            L.Routing.errorControl(control).addTo(map);

        }
    </script>
@endsection

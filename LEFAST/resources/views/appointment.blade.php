@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ url('leaflet-machine/leaflet-routing-machine.css') }}" />
    {{-- <link rel="stylesheet" href="{{ url('leaflet-machine/index.css') }}" /> --}}
    <script>
        tinymce.init({
            selector: ".editor",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor",
                "save code fullscreen autoresize codesample autosave responsivefilemanager"
            ],
            menubar: false,
            toolbar1: "undo redo restoredraft | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent table searchreplace",
            toolbar2: "| fontsizeselect | styleselect | link unlink anchor | image media emoticons | forecolor backcolor | code codesample fullscreen ",
            image_advtab: true,
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            relative_urls: false,
            remove_script_host: false,
            filemanager_access_key: '@filemanager_get_key()',
            filemanager_sort_by: '',
            filemanager_descending: '',
            filemanager_subfolder: '',
            filemanager_crossdomain: '',
            external_filemanager_path: '@filemanager_get_resource(dialog . php)',
            filemanager_title: "File Manager",
            external_plugins: {
                "filemanager": "http://127.0.0.1:8000/js/filemanager.min.js"
            },
            filemanager_access_key: 'key',
        });
    </script>
@endsection

@section('menu')
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
<hr>
    <li class="menu-item ">
        <a href="/" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Dashboard', app()->getLocale()) }}</div>
        </a>
    </li>

    {{-- <li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{GoogleTranslate::trans('Account', app()->getLocale()) }}</span>
</li> --}}
    <li class="menu-item ">
        <a href="{{ route('profile.edit') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Account Setting', app()->getLocale()) }}</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('auction-list') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-list-ul"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Auction List', app()->getLocale()) }}</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('bookmarks') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bookmark"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Bookmarks', app()->getLocale()) }}</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('history') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-history"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('History', app()->getLocale()) }}</div>
        </a>
    </li>


    <li class="menu-item ">
        <a href="{{ route('help-center') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-support"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Help Center', app()->getLocale()) }}</div>
        </a>
    </li>
    <li class="menu-item active">
        <a href="{{ route('appointment') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Appointment', app()->getLocale()) }}</div>
        </a>
    </li>
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
    </style>

    <div class="container d-flex mt-5 gap-5">
        <div class="card" style="flex:5">

            <div class="card-body">
                @if (!is_null($ap = DB::table('appointment')->where('user_id',Auth::id())->first()))
                    <table class="table table-borderless">
                        <tr>

                            <td colspan="2">
                                <center>
                                    <img src="{{ url('thumbAppointment/'.$ap->thumb) }}" style="width:50%;border-radius:10px" alt="">
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>

   <tr>
                            <td>Phone</td>
                            <td>{{ $ap->phone }}</td>
                        </tr>
                           <tr>
                            <td>Schedule</td>
                            <td>{{ date_format(date_create($ap->schedule), 'F m, H:i (e)') }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! $ap->description !!}</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ $ap->latitude }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ $ap->longitude }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>@if ($ap->status == 'pending')
                                <span class="badge bg-label-primary me-1">{{GoogleTranslate::trans('Pending', app()->getLocale()) }}</span>
                            @elseif($ap->status == 'approved')
                                <span class="badge bg-label-success me-1">{{GoogleTranslate::trans('Approved', app()->getLocale()) }}</span>
                            @else
                                <span class="badge bg-label-danger me-1">{{GoogleTranslate::trans('Declined', app()->getLocale()) }}</span>
                            @endif</td>
                        </tr>

                    </table>
                @else
                <form action="{{ route('set-appointment') }}" id="myForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <center>
                        <h3>{{GoogleTranslate::trans('Set Appointment', app()->getLocale()) }}</h3>
                    </center>
                    <br>
                    <br>
                    
                    <p>
                        
                        {{GoogleTranslate::trans('the meeting that is made must be filled in truthfully with goods and letters complete with taxes that we take from the sale of auction items of 10% of the auction profit and that will be arranged on an invoice that we will send if it has been sold, if there is anything you want to ask regarding goods can contact our help center, we maintain the privacy and security of users for this website', app()->getLocale()) }}
                    </p>
                    <br>
<br>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com" value="{{ Auth::user()->name }}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com" value="{{ Auth::user()->email }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="phone"
                                placeholder="0895331493506">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">When ?</label>
                            <input type="datetime-local" class="form-control" name="schedule" id="exampleFormControlInput1">
                        </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label ">Description Product Auction</label>
                        <textarea class="form-control editor" name="description" id="exampleFormControlTextarea1" rows="3" required ></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="thumb" class="form-label">thumb Banner</label>
                        <input type="file" class="form-control dropify" id="thumb" name="thumb"
                            placeholder="isi thumb" >
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Lattitude</label>
                            <input type="text" id="lat" name="latitude" class="form-control" id="exampleFormControlInput1"
                                placeholder="lat" value="" readonly required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Longitude</label>
                            <input type="text" id="long" name="longitude" class="form-control" id="exampleFormControlInput1"
                                placeholder="lang" value="" readonly required>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100" type="button" onclick="getLocation()">{{GoogleTranslate::trans('Get Current Location', app()->getLocale()) }}</button>
                    <span id="demo"></span>
                    <br>
                    <br>
                    <div style="width: 100%;height:500px;position:relative">
                        <div id="map" class="map"></div>
                    </div>
<br>
<br>
                    <button class="btn btn-primary w-100" type="submit" onclick="submit()">{{GoogleTranslate::trans('Make an appointment !', app()->getLocale()) }}</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>

    <script src="https://cdn.tiny.cloud/1/{{ env('TINY_API_TOKEN') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin">
    </script>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script src="{{ url('leaflet-machine/leaflet-routing-machine.js') }}"></script>
    <script src="{{ url('leaflet-machine/Control.Geocoder.js') }}"></script>
    <script src="{{ url('leaflet-machine/config.js') }}"></script>
    {{-- <script src="{{ url('leaflet-machine/index.js') }}"></script> --}}
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: '.editor',
              setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    },
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        
        function submit() {
            console.log('tersubmit');
           document.getElementById("myForm").submit(); 
        }

        function showPosition(position) {

            $('#lat').val(position.coords.latitude);
            $('#long').val(position.coords.longitude);

            // Initialize the map
            var map = L.map('map')

            // Get the tile layer from OpenStreetMaps
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

                // Specify the maximum zoom of the map
                maxZoom: 19,

                // Set the attribution for OpenStreetMaps
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Set the view of the map
            // with the latitude, longitude and the zoom value
            map.setView([position.coords.latitude, position.coords.longitude], 16);

            // Set the map view to the user's location
            // Uncomment below to set map according to user location
            // map.locate({setView: true, maxZoom: 16});

            // Show a market at the position of the Eiffel Tower
            let eiffelMarker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            // Bind popup to the marker with a popup
            eiffelMarker.bindPopup("You").openPopup();
            //             var map = L.map('map');

            // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            // 	attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            // }).addTo(map);

            // var control = L.Routing.control(L.extend(window.lrmConfig, {
            // 	waypoints: [
            // 		L.latLng(position.coords.latitude, position.coords.longitude),
            // 		L.latLng(position.coords.latitude, position.coords.longitude)
            // 	],
            // 	geocoder: L.Control.Geocoder.nominatim(),
            // 	routeWhileDragging: true,
            // 	reverseWaypoints: true,
            // 	showAlternatives: true,
            // 	altLineOptions: {
            // 		styles: [
            // 			{color: 'black', opacity: 0.15, weight: 9},
            // 			{color: 'white', opacity: 0.8, weight: 6},
            // 			{color: 'blue', opacity: 0.5, weight: 2}
            // 		]
            // 	}
            // })).addTo(map);

            // L.Routing.errorControl(control).addTo(map);

        }
    </script>
@endsection

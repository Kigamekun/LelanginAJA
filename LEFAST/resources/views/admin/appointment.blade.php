@extends('layouts.base-admin')

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


@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ url('leaflet-machine/leaflet-routing-machine.css') }}" />
@endsection


@section('content')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 14px;
        }

        .tabss {
            padding: 15px;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card">
                <div class="d-flex" style="justify-content: space-between;align-items:center">
                    <div>
                        <h4 class="card-header">Appointment</h4>
                    </div>
                    
                </div>
                <div class="tabss table-responsive ">
                    <br>

                    <table id="productTable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>

                                <th>Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Status</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ DB::table('users')->where('id', $item->user_id)->first()->name }}</td>
                                    <td>{{ $item->latitude }}</td>
                                    <td>{{ $item->longitude }}</td>
                                    <td>
                                        <select name="" id="" data-id="{{ $item->id }}" class="form-select stts">
                                            <option value="pending" @if ($item->status == 'pending') selected @endif>
                                                Pending</option>
                                            <option value="approved" @if ($item->status == 'approved') selected @endif>
                                                Approved</option>
                                            <option value="declined" @if ($item->status == 'declined') selected @endif>
                                                Declined</option>

                                        </select>

                                    </td>

                                    <td style="width: 20%">
                                        <a href="{{ route('admin.appointment.detail', ['id'=>$item->id]) }}" class="btn btn-primary">
                                            Detail
                                    </a>
                                        <a href="{{ route('admin.appointment.delete', ['id'=>$item->id]) }}" class="btn btn-danger">
                                            Delete
                                    </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script src="{{ url('leaflet-machine/leaflet-routing-machine.js') }}"></script>
    <script src="{{ url('leaflet-machine/Control.Geocoder.js') }}"></script>
    <script src="{{ url('leaflet-machine/config.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({});
        });
    </script>

    <script>
        $('#detailData').on('shown.bs.modal', function(e) {
            var html = `
            <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <div>
                            ${$(e.relatedTarget).data('description')}
                            </div>
                            <br>
                            <div style="width: 100%;height:500px;position:relative">
                        <div id="map" class="map"></div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

            `;

            $('#modal-content').html(html);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Initialize the map
                    var map = L.map('map')

                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    var control = L.Routing.control(L.extend(window.lrmConfig, {
                        waypoints: [
                            L.latLng(position.coords.latitude, position.coords.longitude),
                            L.latLng($(e.relatedTarget).data('latitude'), $(e.relatedTarget)
                                .data('longitude'))
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

                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }


        });
    </script>
    <script>
        $('.stts').change(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.appointment.change') }}",
                method: "POST",
                data: {
                    status: $(this).val(),
                    id: $(this).data('id'),
                },
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endsection

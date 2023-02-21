@extends('layouts.base')

@section('menu')
    <li class="menu-item ">
        <a href="/" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    {{-- <li class="menu-header small text-uppercase">
    <span class="menu-header-text">Account</span>
</li> --}}
    <li class="menu-item ">
        <a href="{{ route('profile.edit') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Analytics">Account Setting</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('auction-list') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-list-ul"></i>
            <div data-i18n="Analytics">Auction List</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('bookmarks') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bookmark"></i>
            <div data-i18n="Analytics">Bookmarks</div>
        </a>
    </li>
    <li class="menu-item active">
        <a href="{{ route('history') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-history"></i>
            <div data-i18n="Analytics">History</div>
        </a>
    </li>


    <li class="menu-item">
        <a href="{{ route('help-center') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-support"></i>
            <div data-i18n="Analytics">Help Center</div>
        </a>
    </li>
@endsection


@section('content')
    <style>
        .text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            /* number of lines to show */
            line-clamp: 5;
            -webkit-box-orient: vertical;
        }
    </style>

    <div class="container mt-5 gap-5">
        <h2>History Bidding</h2>
        <br>
        <input type="hidden" id="selected-item" name="selected-item">

        @foreach ($data as $item)
            <div class="card mb-3" style="width:100%;">
                <div class="row g-0" style="height: 100%">
                    <div class="col-md-4" style="height: 100%">
                        <img class="card-img card-img-left" style="width: 100%;height: 300px;object-fit:contain"
                            src="{{ url('thumb/' . $item->product->thumb) }}" alt="Card image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->product->name }}</h5>
                            <p class="card-text text">
                                {!! strip_tags($item->product->description) !!}
                            </p>
                            <br>
                            <br>
                            <br>
                            <br>


                            @if (!is_null($item->last_payment))
                                <div class="d-flex gap-3" style="justify-content: space-between">
                                    <div>
                                        <p>Finish payment before</p>
                                        <p class="badge bg-label-primary me-1">{{ $item->last_payment }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex gap-3" style="justify-content: flex-end">
                                <a href="{{ route('detail', ['id' => $item->product->id]) }}" class="btn btn-info">Auction
                                    Info</a>
                                @if (Carbon\Carbon::now() < $item->product->end_auction)
                                    <form action="{{ route('cancel-bid', ['id' => $item->id]) }}" method="post">
                                        @csrf
                                        <button id="btn-cancel" type="submit" class="btn btn-danger">Cancel Bid</button>
                                    </form>
                                @endif
                                @if (Carbon\Carbon::now() >= $item->product->end_auction)
                                    @if (
                                        $item->id ==
                                            DB::table('auctions')->where('product_id', $item->product->id)->orderBy('auction_price', 'DESC')->first()->id)
                                        @if (!is_null($item->snap_token) && $item->payment_status == 2)
                                            <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                class="btn btn-info" data-no_resi="{{ $item->no_resi }}"
                                                data-airplane="{{ $item->airplane }}"
                                                data-courier="{{ $item->courier }}">Detail
                                                Shipping</button>
                                            <button class="btn btn-success pay-button">Sold Out You're the highest Bid
                                                !</button>
                                        @else
                                            <button data-id="{{ $item->id }}"
                                                class="btn btn-success pay-button">Pay</button>
                                        @endif
                                    @else
                                        <button class="btn btn-success pay-button">Sold Out </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shipping Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-shipping">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"
        integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mojs/core"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <script>
        $('.pay-button').click(function(e) {
            e.preventDefault();

            $('#selected-item').val($(this).attr('data-id'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/get-snap-token/" + $(this).attr('data-id'),
                method: "GET",

                success: function(data) {


                    snap.pay(data['snapToken'], {
                        // Optional
                        onSuccess: function(result) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                }
                            });
                            $.ajax({
                                url: "/cst",
                                method: "POST",
                                data: {
                                    auction: $('#selected-item').val(),
                                    status: 'success',
                                    result: result
                                },
                                success: function(data) {
                                    location.reload();

                                }
                            });
                        },
                        // Optional
                        onPending: function(result) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                }
                            });
                            $.ajax({
                                url: "/cst",
                                method: "POST",
                                data: {
                                    auction: data['auction'],
                                    status: 'warning',
                                    result: result
                                },
                                success: function(data) {
                                    location.reload();

                                }
                            });
                        },
                        // Optional
                        onError: function(result) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                }
                            });
                            $.ajax({
                                url: "/cst",
                                method: "POST",
                                data: {
                                    auction: data['auction'],
                                    status: 'error',
                                    result: result
                                },
                                success: function(data) {
                                    location.reload();

                                }
                            });
                        }
                    });
                }
            });



        });
    </script>


    <script>
        $('#exampleModal').on('shown.bs.modal', function(e) {

            var track = '';

            if ($(e.relatedTarget).data('courier') == 'DHL') {
                track = `<a href = "https://www.dhl.com/id-en/home/tracking.html?tracking-id=${$(e.relatedTarget).data('no_resi')}"
            target = "_blank"
            class = "btn btn-primary me-2" > Track
            ${$(e.relatedTarget).data('courier')} </a>`
            } else if ($(e.relatedTarget).data('courier') == 'UPS') {
                track = `<a href =
                "https://www.ups.com/WebTracking/processInputRequest?tracknum=${$(e.relatedTarget).data('no_resi')}&loc=en_ID&requester=ST/trackdetails"
            target = "_blank"
            class = "btn btn-primary me-2" > Track
            ${$(e.relatedTarget).data('courier')} < /a>`;
            } else if ($(e.relatedTarget).data('courier') == 'KARGO') {
                track =
                    ` <a class = "btn btn-primary me-2" > ${$(e.relatedTarget).data('airplane')} - ${$(e.relatedTarget).data('no_resi')} < /a>`
            }

            var html = `
        <div class="d-flex">
    <div style="flex:1">
        <img src="{{ url('assets/img/layouts/shipping.webp') }}" alt="" class="w-100">
    </div>
    <div style="flex:1">
        <table class="table table-borderless">

                <tr>
                    <th scope="row">No Resi</th>
                    <th>${$(e.relatedTarget).data('no_resi') != '' ? $(e.relatedTarget).data('no_resi') : 'On Progress'}</th>
                </tr>

                <tr>
                    <th scope="row">Airplane</th>
                    <th>${$(e.relatedTarget).data('airplane') != '' ? $(e.relatedTarget).data('airplane') : 'On Progress'}</th>
                </tr>

                <tr>
                    <th scope="row">Courier</th>
                    <th>${$(e.relatedTarget).data('courier') != '' ? $(e.relatedTarget).data('courier') : 'On Progress'}</th>
                </tr>


                <tr>
                    <th scope="row">File Resi</th>
                    <th>${track}</th>
                </tr>

        </table>
    </div>
</div>
        `;

            $('#modal-shipping').html(html);



        });
    </script>

    <script>
        $('#btn-cancel').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            Swal.fire({
                title: 'Do you want to cancel this bid?',
                showDenyButton: true,
                showCancelButton: false,

                denyButtonText: `Don't cancel`,
                confirmButtonText: 'Cancel',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Canceled !', '', 'success');
                    form.submit();
                } else if (result.isDenied) {
                    Swal.fire("You're Bid has been saved", '', 'info');

                }
            })
        });
    </script>
@endsection

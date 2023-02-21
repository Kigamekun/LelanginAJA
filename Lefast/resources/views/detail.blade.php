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
<li class="menu-item">
    <a href="{{ route('profile.edit') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Analytics">Account Setting</div>
    </a>
</li>

<li class="menu-item active">
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
<li class="menu-item">
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

    .top-image-auction {
        width: 500px;
    }

    @media (max-width: 767px) {
            .detail-auction {
                flex-direction: column;
            }
            
            .top-auction-detail {
                flex-direction:column;
                
            }
            .top-image-auction {
                width: 100%;
                margin-bottom:10px;
            }

        }
</style>
    <div class="detail-auction container d-flex mt-5 gap-5">
        <div class="card" style="flex:5">

            <div class="card-body">
                <div class="d-flex top-auction-detail">
                    <img class="top-image-auction" style="border-radius: 15px;height:400px;" src="{{ url('thumb/' . $data->thumb) }}"
                        alt="Card image cap">
                    <div class="ms-5">
                        <h3 style="font-weight: bold">{{ $data->name }}</h3>
                        <hr>
                        <br>
                        <table style="width:100%">
                            <tr>
                                <td>Current Bid</td>
                                <td align="right">{{ App\Models\Auction::where('product_id', $data->id)->count() }}</td>
                            </tr>
                            <tr>
                                <td>Highest Bid</td>
                                <td align="right">Rp.
                                    {{ number_format(!is_null($ac = App\Models\Auction::where('product_id', $data->id)->orderBy('auction_price','DESC')->first()) ? $ac->auction_price: 0,0,',','.') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Auction Closed</td>
                                <td align="right">{{ date_format(date_create($data->end_auction), 'F m, H:i (e)') }}</td>
                            </tr>
                            <tr>
                                <td>Start From</td>
                                <td align="right">Rp. {{ number_format($data->start_from, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </div>
                <br>
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                Description
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                {!! $data->description !!}</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseTwo">
                                Condition Report
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-headingTwo">
                            <div class="accordion-body">
                                {!! $data->condition !!}</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseThree">
                                Saleroom Notice
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                {!! $data->saleroom_notice !!}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseFour">
                                Catalogue Note
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-headingFour">
                            <div class="accordion-body">
                                {!! $data->catalogue_note !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="flex:2;height:610px">
            <center>
                <h2 class="card-header">Bidding</h2>
            </center>
            <div class="card-body">

                    <form action="{{ route('set-bid', ['product_id' => $data->id]) }}" method="post">
                        @csrf
                        @if (date('Y-m-d H:i:s') < $data->end_auction)
                        <label for="defaultFormControlInput" class="form-label">Bid Price</label>
                        <input type="number" name="auction_price" id="" class="form-control">
                        <br>
                        @endif

                        <div class="list-group" style="height: 200px;overflow: scroll">
                            @foreach (App\Models\Auction::where('product_id', $data->id)->orderBy('auction_price','DESC')->get() as $key => $item)
                                @if ($key == 0)
                                    <a href="javascript:void(0);"
                                        class="list-group-item list-group-item-action d-flex active"
                                        style="justify-content: space-between;align-items:center">
                                        <div>
                                            {{ $item->user->name }} {{ Auth::id() == $item->user_id ? '(You)' : '' }}
                                            <p class="small-text">Rp.{{ number_format($item->auction_price, 0, ',', '.') }}</p>
                                        </div>
                                        <img style="width:30px" src="{{ url('assets/img/icons/medal.png') }}"
                                            alt="">
                                    </a>
                                @else
                                    <a href="javascript:void(0);"
                                        class="list-group-item list-group-item-action ">
                                        <div>
                                            {{ $item->user->name }} {{ Auth::id() == $item->user_id ? '(You)' : '' }}
                                            <p class="small-text">Rp.{{ number_format($item->auction_price, 0, ',', '.') }}</p>
                                        </div>
                                        </a>
                                @endif
                            @endforeach
                        </div>
                        {{-- <br>
                        <label for="defaultFormControlInput" class="form-label">Reason</label>
                        <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea> --}}
                        <div class="d-flex mt-5 mb-3" style="justify-content: space-between">
                            <p>Time Remaining</p>
                            <p id="demo"></p>
                        </div>
                        <div id="button-bid" class="d-flex w-100 gap-2">
                            @if (date('Y-m-d H:i:s') >= $data->end_auction)
                                <button type="button" class="btn btn-danger" style="flex:1">
                                    Auction ended
                                </button>
                            @elseif(DB::table('auctions')->where(['user_id' => Auth::id(), 'product_id' => $data->id])->count() > 0)
                                <button type="button" class="btn btn-warning" style="flex:1">
                                    You're Already Bid
                                </button>
                                <button type="submit" class="btn btn-primary" style="flex:1">
                                    Bid
                                </button>
                            @else
                                <button class="btn btn-outline-primary " style="flex:1">
                                    Save
                                </button>
                                <button type="submit" class="btn btn-primary " style="flex:1">
                                    Place Bid
                                </button>
                            @endif
                        </div>
                    </form>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        var dates = @json($data->end_auction)
        // Set the date we're counting down to
        var countDownDate = new Date(dates).getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";
            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
                document.getElementById("button-bid").innerHTML =
                    `<button type="button" class="btn btn-danger w-100 " style="flex:1">Auction ended</button>`;
            }
        }, 1000);
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection



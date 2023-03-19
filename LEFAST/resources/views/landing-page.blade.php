@extends('layouts.base')


@section('menu')
    <li class="menu-item active">
        <a href="/" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Dashboard', app()->getLocale()) }}</div>
        </a>
    </li>

    {{-- <li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{GoogleTranslate::trans('Account', app()->getLocale()) }}</span>
</li> --}}
    <li class="menu-item">
        <a href="{{ route('profile.edit') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Account Setting', app()->getLocale()) }} </div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('auction-list') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-list-ul"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Auction List', app()->getLocale()) }} </div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('bookmarks') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bookmark"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Bookmarks', app()->getLocale()) }} </div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('history') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-history"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('History', app()->getLocale()) }} </div>
        </a>
    </li>


    <li class="menu-item">
        <a href="{{ route('help-center') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-support"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Help Center', app()->getLocale()) }} </div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('appointment') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics"> {{GoogleTranslate::trans('Appointment', app()->getLocale()) }} </div>
        </a>
    </li>
@endsection

@section('content')
    <style>
        .text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .new-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }


        .events-list {
            width: 100%;
            font-size: 0.9em;
        }

        .events-list tr td {
            padding: 5px 20px 5px 0;
        }

        .events-list tr td:last-child {
            padding: 5px 0;
            text-align: right;
        }

        .events-list tr:hover .event-date {
            border-left: 5px solid #4f8db3;
        }

        .events-list .event-date {
            margin: 3px 0;
            padding: 2px 10px;
            border-left: 5px solid #CFCFCF;
            -webkit-transition: all .25s linear;
            -moz-transition: all .25s linear;
            -o-transition: all .25s linear;
            -ms-transition: all .25s linear;
            transition: all .25s linear;
        }

        .events-list .event-date .event-day {
            color: #004A5B;
            font-size: 1.2em;
            font-weight: 600;
            text-align: left;
        }

        .events-list .event-date .event-month {
            color: #777;
            font-size: 1em;
            font-weight: 600;
            text-align: left;
        }

        .events-list .event-date .event-venue,
        .events-list .event-date .event-price {
            white-space: nowrap;
        }



        .item-auction {
            justify-content: space-between;
        }
        @media (max-width: 767px) {
            .top-auction {
            display: none;

        }
        .item-auction {
            justify-content: center;
        }
        }
    </style>


    <div class="container-xxl flex-grow-1 container-p-y">
        <br>

        <div id="carouselExample" style="width: 100%;height:400px" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banner as $key => $item)
                    <li data-bs-target="#carouselExample" data-bs-slide-to="{{ $key }}"
                        <?= $key == 0 ? 'class="active" aria-current="true"' : '' ?>></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($banner as $key => $item)
                    <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                        <img class="d-block w-100 " style="object-fit: cover;height: 400px"
                            src="{{ url('thumbBanner/' . $item->thumb) }}" alt="{{ $item->title }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div class="d-flex gap-5">
            <div style="flex:6">
                <div class="d-flex justify-content-between">
                    <h3>{{GoogleTranslate::trans('Featured Items', app()->getLocale()) }}</h3>
                    <div class="mb-3">

                        <select id="defaultSelect" class="form-select" onchange="getOrder(this)">
                            <option>{{GoogleTranslate::trans('Urutkan dari', app()->getLocale()) }}</option>
                            <option value="2">{{GoogleTranslate::trans('Newest', app()->getLocale()) }}</option>
                            <option value="1">{{GoogleTranslate::trans('Oldest', app()->getLocale()) }}</option>

                        </select>
                    </div>
                </div>
                <br>
                <br>
                <div class="item-auction d-flex flex-wrap gap-3" >
                    @foreach ($data as $item)
                        <div class="card" style="width: 20rem">
                            <img class="card-img-top"  style="width: 320px;height:320px;object-fit:contain;"
                                src="{{ url('thumb/' . $item->thumb) }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title text">{{ $item->name }}</h5>
                                <p class="card-text text">
                                    {!! strip_tags($item->description) !!}
                                </p>


                                <div class="d-flex justify-content-between">
                                    <div data-date="{{ $item->end_auction }}" class="clockdiv btn">
                                        <span class="days"></span>
                                        <span class="tag1"></span>
                                        <span class="hours"></span>
                                        <span class="tag2"></span>
                                        <span class="minutes"></span>
                                        <span class="tag3"></span>
                                        <span class="seconds"></span>
                                        <span class="tag4"></span>
                                    </div>
                                    <a href="{{ route('detail', ['id' => $item->id]) }}" class="btn btn-outline-primary">Go
                                        Bid</a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

                <br>
                <div class="d-flex" style="justify-content: flex-end">
                    <a href="{{ route('auction-list') }}">{{GoogleTranslate::trans('View All', app()->getLocale()) }}</a>
                </div>
            </div>

            <div class="top-auction" style="flex:2;">

                <div class="d-flex justify-content-between" >
                    <h3>{{GoogleTranslate::trans('Top Auction', app()->getLocale()) }}</h3>
                </div>
                <br>
                <br>
                @foreach (DB::table('products')->orderBy('created_at', 'DESC')->limit(8)->get() as $item)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="card-img card-img-left"  style="width: 120px;height:100%;object-fit:cover;"
                                    src="{{ url('thumb/' . $item->thumb) }}" alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <a href="{{ route('detail', ['id'=>$item->id]) }}" style="color:black" class="card-title new-text">{{ $item->name }}</a>
                                    <p class="card-text"><small class="text-muted">{{ $item->created_at }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>


        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="card p-5">
            <h3>{{GoogleTranslate::trans('Events', app()->getLocale()) }}</h3>

            <div class="single-post-content">
                <table class="events-list">
                    @foreach ($event as $item)
                        <tr>
                            <td>
                                <div class="event-date">
                                    <div class="event-day">{{ date_format(date_create($item->start_at), 'd') }}</div>
                                    <div class="event-month">{{ date_format(date_create($item->start_at), 'F') }}</div>
                                </div>
                            </td>
                            <td>
                                {{ $item->description }}
                            </td>
                            <td class="event-venue hidden-xs"><i class="icon-map-marker"></i>{{ $item->location }}</td>
                            <td class="event-price hidden-xs">
                                {{ $item->price == 0 ? 'FREE' : 'Rp.' . number_format($item->price, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </table>

            </div>

        </div>

        <br>
        <br>
        <div class="card p-5">
            <center>
                <h3>{{GoogleTranslate::trans('Stay informed with Lelangin AJA top stories, videos, events & news.', app()->getLocale()) }}</h3>
                <p>{{GoogleTranslate::trans('LelanginAJA is a web-based application, responsive web as well
android which can make it easier for users to carry out bidding activities
for products that are auctioned in the application and can make it easier for the admin
as well as officers in managing the product and also the profit earned due to
already connected with midtrans as payment and also DHL UPS
as shipping method.
This auction is guaranteed to be safe because it monitors the app 24/7 and
the system that has been created can accommodate all errors and bugs in
application, accompanied by logging as well which can make it easier for the admin or
officers in analyzing running applications.', app()->getLocale()) }}</p>
            </center>
            <div class="mb-3">
                <label for="defaultFormControlInput" class="form-label">Name</label>
                <input type="text" name="auction_price" id="" class="form-control">
            </div>
            <br>
            <br>
            <div class="mb-3">
                <label for="defaultFormControlInput" class="form-label">Email</label>
                <input type="email" name="auction_price" id="" class="form-control">
            </div>
            <br>
            <br>
            <div class="mb-3">
                <label for="defaultFormControlInput" class="form-label">Description</label>
                <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea>

            </div>
            <button class="btn btn-primary w-100">
                Submit
            </button>
        </div>


    </div>
@endsection


@section('scripts')
    <script>
        function getOrder(selectObject) {
            var value = selectObject.value;
            window.location = '?order='+ value;
        }
    </script>
    <script>
        document.addEventListener('readystatechange', event => {
            if (event.target.readyState === "complete") {
                var clockdiv = document.getElementsByClassName("clockdiv");
                var countDownDate = new Array();
                for (var i = 0; i < clockdiv.length; i++) {
                    countDownDate[i] = new Array();
                    countDownDate[i]['el'] = clockdiv[i];
                    countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
                    countDownDate[i]['days'] = 0;
                    countDownDate[i]['hours'] = 0;
                    countDownDate[i]['seconds'] = 0;
                    countDownDate[i]['minutes'] = 0;
                }

                var countdownfunction = setInterval(function() {
                    for (var i = 0; i < countDownDate.length; i++) {
                        var now = new Date().getTime();
                        var distance = countDownDate[i]['time'] - now;
                        countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                        countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 *
                            60 * 60));
                        countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 *
                            60));
                        countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);

                        if (distance < 0) {
                            countDownDate[i]['el'].classList.add("btn-danger");
                            countDownDate[i]['el'].innerHTML = 'EXPIRED';


                        } else {
                            countDownDate[i]['el'].classList.add("btn-info");

                            countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i][
                                'days'
                            ];
                            countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i][
                                'hours'
                            ];
                            countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i][
                                'minutes'
                            ];
                            countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i][
                                'seconds'
                            ];
                            countDownDate[i]['el'].querySelector('.tag1').innerHTML = 'd';
                            countDownDate[i]['el'].querySelector('.tag2').innerHTML = 'h';
                            countDownDate[i]['el'].querySelector('.tag3').innerHTML = 'm';
                            countDownDate[i]['el'].querySelector('.tag4').innerHTML = 's';
                        }

                    }
                }, 1000);
            }
        });
    </script>
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/64126cfe31ebfa0fe7f2dbb7/1grjvjhdk';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PH5E80PZT2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PH5E80PZT2');
</script>

@endsection

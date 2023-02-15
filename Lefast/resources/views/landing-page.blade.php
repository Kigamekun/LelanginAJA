@extends('layouts.base')


@section('menu')
    <li class="menu-item active">
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
    </style>


    <div class="container-xxl flex-grow-1 container-p-y">
        <br>

        <div id="carouselExample" style="width: 100%;height:400px" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banner as $key => $item)
                    <li data-bs-target="#carouselExample" data-bs-slide-to="0"
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
                    <h3>Featured Items</h3>
                    <div class="mb-3">

                        <select id="defaultSelect" class="form-select" onchange="getOrder(this)">
                            <option>Order By</option>
                            <option value="2">Newest</option>
                            <option value="1">Latest</option>

                        </select>
                    </div>
                </div>
                <br>
                <br>
                <div class="d-flex flex-wrap gap-3" style="justify-content: space-between;">
                    @foreach ($data as $item)
                        <div class="card" style="width: 20rem">
                            <img class="card-img-top" style="width: 320px;height:320px;object-fit:contain;"
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
                    <a href="{{ route('auction-list') }}">View All</a>
                </div>
            </div>

            <div style="flex:2">

                <div class="d-flex justify-content-between">
                    <h3>Top Auction</h3>
                </div>
                <br>
                <br>
                @foreach (DB::table('products')->orderBy('created_at', 'DESC')->limit(8)->get() as $item)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="card-img card-img-left" style="width: 120px;height:120px;"
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
            <h3>Events</h3>

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
                            <td><a href="#" class="btn btn-grey btn-sm event-more">Read More</a></td>
                        </tr>
                    @endforeach
                </table>

            </div>

        </div>

        <br>
        <br>
        <div class="card p-5">
            <center>
                <h3>Stay informed with Lelangin AJA top stories, videos, events & news.</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit fugiat ad aspernatur provident,
                    possimus id earum ducimus nesciunt. Deleniti nobis, ea voluptatibus inventore sint provident culpa,
                    corporis sed voluptatem molestiae alias ipsum non error porro, quas doloribus eaque! Unde debitis rem
                    perferendis cum molestias illo tempora, repellat possimus nobis officia.</p>
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
@endsection

@extends('layouts.base')


@section('menu')
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

    <li class="menu-item active">
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
    <li class="menu-item ">
        <a href="{{ route('appointment') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Appointment', app()->getLocale()) }}</div>
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

        <div class="d-flex gap-5">
            <div style="flex:6">
                <div class="d-flex justify-content-between">
                    <h3>{{GoogleTranslate::trans('Bookmarks', app()->getLocale()) }}</h3>

                </div>
                <br>
                <br>

                <div class="d-flex flex-wrap gap-3" style="justify-content: center;">
                    @if ($data->count() == 0)

                            <center>
                                <div class="misc-wrapper w-100">
                                    <h4 class="mb-2 mx-2">{{GoogleTranslate::trans("You don't saved any product :(", app()->getLocale()) }}</h4>
                                    <p class="mb-4 mx-2">Oops!</p>
                                    <a href="/" class="btn btn-primary">Back to home</a>
                                    <div class="mt-3">
                                        <img src="../assets/img/illustrations/page-misc-error-light.png"
                                            alt="page-misc-error-light" width="500" class="img-fluid"
                                            data-app-dark-img="illustrations/page-misc-error-dark.png"
                                            data-app-light-img="illustrations/page-misc-error-light.png" />
                                    </div>
                                </div>
                            </center>

                    @else
                        @foreach ($data as $item)
                            <div class="card" style="width: 20rem">
                                <img class="card-img-top" style="width: 320px;height:320px;object-fit:contain;"
                                    src="{{ url('thumb/' . $item->product->thumb) }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title text">{{ $item->product->name }}</h5>
                                    <p class="card-text text">
                                        {!! strip_tags($item->product->description) !!}
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('detail', ['id' => $item->product->id]) }}"
                                            class="btn btn-outline-primary">Go
                                            Bid</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        @endsection


        @section('scripts')
            <script>
                function getOrder(selectObject) {
                    var value = selectObject.value;
                    window.location = '?order=' + value;
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

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

    <li class="menu-item active">
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

        .wrapper {

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .filter-price {
            background: #696cff;
            width: 100%;
            border: 0;
            padding: 0;
            margin: 0;
            border-radius: 5px;


        }

        .price-title {
            position: relative;
            color: #fff;
            font-size: 14px;
            line-height: 1.2em;
            font-weight: 400;
        }

        .price-field {
            position: relative;
            width: 80%;
            height: 36px;
            box-sizing: border-box;

            /* background: rgba(248, 247, 244, 0.2); */
            padding-top: 15px;
            padding-left: 30px;
            border-radius: 3px;
        }

        .price-field input[type=range] {
            position: absolute;
        }

        /* Reset style for input range */

        .price-field input[type=range] {
            width: 100%;
            height: 2px;
            border: 0;
            outline: 0;
            box-sizing: border-box;
            border-radius: 5px;
            pointer-events: none;
            -webkit-appearance: none;
        }

        .price-field input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
        }

        .price-field input[type=range]:active,
        .price-field input[type=range]:focus {
            outline: 0;
        }

        .price-field input[type=range]::-ms-track {
            width: 188px;
            height: 2px;
            border: 0;
            outline: 0;
            box-sizing: border-box;
            border-radius: 5px;
            pointer-events: none;
            background: transparent;
            border-color: transparent;
            color: transparent;
            border-radius: 5px;
        }

        /* Style toddler input range */

        .price-field input[type=range]::-webkit-slider-thumb {
            /* WebKit/Blink */
            position: relative;
            -webkit-appearance: none;
            margin: 0;
            border: 0;
            outline: 0;
            border-radius: 50%;
            height: 10px;
            width: 10px;
            margin-top: -4px;
            background-color: black;
            cursor: pointer;
            cursor: pointer;
            pointer-events: all;
            z-index: 100;
        }

        .price-field input[type=range]::-moz-range-thumb {
            /* Firefox */
            position: relative;
            appearance: none;
            margin: 0;
            border: 0;
            outline: 0;
            border-radius: 50%;
            height: 10px;
            width: 10px;
            margin-top: -5px;
            background-color: #fff;
            cursor: pointer;
            cursor: pointer;
            pointer-events: all;
            z-index: 100;
        }

        .price-field input[type=range]::-ms-thumb {
            /* IE */
            position: relative;
            appearance: none;
            margin: 0;
            border: 0;
            outline: 0;
            border-radius: 50%;
            height: 10px;
            width: 10px;
            margin-top: -5px;
            background-color: #fff;
            cursor: pointer;
            cursor: pointer;
            pointer-events: all;
            z-index: 100;
        }

        /* Style track input range */

        .price-field input[type=range]::-webkit-slider-runnable-track {
            /* WebKit/Blink */
            width: 188px;
            height: 2px;
            cursor: pointer;
            background: #fff;
            border-radius: 5px;
        }

        .price-field input[type=range]::-moz-range-track {
            /* Firefox */
            width: 188px;
            height: 2px;
            cursor: pointer;
            background: #fff;
            border-radius: 5px;
        }

        .price-field input[type=range]::-ms-track {
            /* IE */
            width: 188px;
            height: 2px;
            cursor: pointer;
            background: #fff;
            border-radius: 5px;
        }

        /* Style for input value block */

        .price-wrap {
            display: flex;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            line-height: 1.2em;
            font-weight: 400;
            margin-bottom: 7px;
        }

        .price-wrap-1,
        .price-wrap-2 {
            display: flex;
        }

        .price-title {
            margin-right: 5px;
            backgrund: #d58e32;
        }

        .price-wrap_line {
            margin: 0 10px;
        }

        .price-wrap #one,
        .price-wrap #two {
            width: 80px;
            text-align: right;
            margin: 0;
            padding: 0;
            margin-right: 2px;
            background: 0;
            border: 0;
            outline: 0;
            color: #fff;
            font-family: 'Karla', 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.2em;
            font-weight: 400;
        }

        .price-wrap label {
            text-align: right;
        }

        /* Style for active state input */

        .price-field input[type=range]:hover::-webkit-slider-thumb {
            box-shadow: 0 0 0 0.5px #fff;
            transition-duration: 0.3s;
        }

        .price-field input[type=range]:active::-webkit-slider-thumb {
            box-shadow: 0 0 0 0.5px #fff;
            transition-duration: 0.3s;
        }

        .filter-auction {
            position:sticky;top:20px;min-height:450px;
            max-height:80vh;
        }

        @media (max-width: 767px) {
            .wrap-auction {
                flex-direction: column;
            }
            .filter-auction {
                min-height:450px;
                
                position:unset;
            }
        }
    </style>
    <div class="container d-flex mt-5 gap-5 wrap-auction">
        <div class="card filter-auction" style="flex:2;">
            <div class="card-body">
                <form action="" method="get">
                    <h3>{{GoogleTranslate::trans('Filter Auction', app()->getLocale()) }}</h3>
                    <br>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">{{GoogleTranslate::trans('Status Auction', app()->getLocale()) }}</label>
                        <select name="status" class="form-select" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option selected="">Status</option>
                            <option value="0">{{GoogleTranslate::trans('Closed', app()->getLocale()) }}</option>
                            <option value="1">{{GoogleTranslate::trans('Opened', app()->getLocale()) }}</option>
                        </select>
                    </div>

                    <div class="col-md">
                        <small class="text-light fw-semibold d-block">{{GoogleTranslate::trans('Category', app()->getLocale()) }}</small>
                        @foreach (DB::table('categories')->get() as $item)
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="categories[]"
                                    value="{{ $item->id }}">
                                <label class="form-check-label" for="inlineCheckbox1">{{ $item->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <div class="mb-3">
                        <div class="wrapper">
                            <fieldset class="filter-price">

                                <div class="price-field">
                                    <input type="range" min="{{ $min }}" max="{{ $max }}"
                                        value="{{ $min }}" id="lower">
                                    <input type="range" min="{{ $min }}" max="{{ $max }}"
                                        value="{{ $max }}" id="upper">
                                </div>

                                <div class="price-wrap">

                                    <div class="price-wrap-1">
                                        <label for="one">Rp.</label>
                                        <input name="lower" id="one">
                                    </div>
                                    <div class="price-wrap_line">-</div>
                                    <div class="price-wrap-2">
                                        <label for="two">Rp.</label>
                                        <input name="upper" id="two">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary w-100">{{GoogleTranslate::trans('Filter', app()->getLocale()) }}</button>
                </form>
            </div>
        </div>
        <div style="width:100%;flex:6">
            @if ($data->count() == 0)
                <center>
                    <br>
                    <div class="misc-wrapper w-100">
                        <h4 class="mb-2 mx-2">{{GoogleTranslate::trans('Product not found :(', app()->getLocale()) }}</h4>

                        <div class="mt-3">
                            <img src="../assets/img/illustrations/page-misc-error-light.png" alt="page-misc-error-light"
                                width="500" class="img-fluid" data-app-dark-img="illustrations/page-misc-error-dark.png"
                                data-app-light-img="illustrations/page-misc-error-light.png" />
                        </div>
                    </div>
                </center>
            @else
                @foreach ($data as $item)
                    <div class="card mb-3" >
                        <div class="row g-0" style="height: 100%">
                            <div class="col-md-4" style="height: 100%">
                                <img class="card-img card-img-left" style="width: 100%;height: 300px;object-fit:contain;image-position:center;border-radius:5px;"
                                    src="{{ url('thumb/' . $item->thumb) }}" alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text">{{ $item->name }}</h5>
                                    <p class="badge bg-label-primary me-1">Start From :
                                        Rp.{{ number_format($item->start_from, 0, ',', '.') }}</p>
                                    <p class="card-text text">
                                        {!! strip_tags($item->description) !!}
                                    </p>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="d-flex gap-3" style="justify-content: space-between">
                                        <div>
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
                                        </div>
                                        <div class="d-flex gap-3">
                                            @if (Auth::check())
                                                <div id="button-save-{{ $item->id }}">

                                                    @if (is_null($item->bookmarked))
                                                        <button class="btn btn-outline-primary save-button"
                                                            data-item-id="{{ $item->id }}">Save</button>
                                                    @else
                                                        <button class="btn btn-primary unsave-button"
                                                            data-item-id="{{ $item->id }}">Saved</button>
                                                    @endif
                                                </div>
                                            @endif
                                            <a href="{{ route('detail', ['id' => $item->id]) }}"
                                                class="btn btn-primary">Bid</a>

                                        </div>
                                    </div>
                                </div>
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
    		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
		}
		
        //Filter Price
        var lowerSlider = document.querySelector('#lower');
        var upperSlider = document.querySelector('#upper');


        document.querySelector('#two').value = formatRupiah(upperSlider.value, '');
        document.querySelector('#one').value = formatRupiah(lowerSlider.value, '');

        var lowerVal = parseInt(lowerSlider.value);
        var upperVal = parseInt(upperSlider.value);

        upperSlider.oninput = function() {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);

            if (upperVal < lowerVal + 4) {
                lowerSlider.value = upperVal - 4;
                if (lowerVal == lowerSlider.min) {
                    upperSlider.value = 4;
                }
            }
            document.querySelector('#two').value = formatRupiah(this.value, '');
        };

        lowerSlider.oninput = function() {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);
            if (lowerVal > upperVal - 4) {
                upperSlider.value = lowerVal + 4;
                if (upperVal == upperSlider.max) {
                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                }
            }
             document.querySelector('#one').value = formatRupiah(this.value, '');
        };
    </script>

    <script>
        $(document).on("click", ".save-button", function(e) {
            console.log($(this).data('item-id'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('add-bookmark') }}",
                method: "POST",
                data: {
                    item_id: $(this).data('item-id'),
                },
                success: function(data) {
                    console.log(`#button-save-${data['id']}`);
                    $(`#button-save-${data['id']}`).html(`<button class="btn btn-primary unsave-button" data-item-id="${data['id']}">Saved</button>
`);
                }
            });

        });

        $(document).on("click", ".unsave-button", function(e) {
            console.log($(this).data('item-id'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('delete-bookmark') }}",
                method: "POST",
                data: {
                    item_id: $(this).data('item-id'),
                },
                success: function(data) {
                    console.log(`#button-save-${data['id']}`);
                    $(`#button-save-${data['id']}`).html(`<button class="btn btn-outline-primary save-button" data-item-id="${data['id']}">Save</button>
`);
                }
            });

        });
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

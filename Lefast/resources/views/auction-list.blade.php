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
        .text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            /* number of lines to show */
            line-clamp: 5;
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
            width: 30px;
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
    </style>
    <div class="container d-flex mt-5 gap-5">
        <div class="card" style="flex:2;position:sticky;top:20px;height:450px;">
            <div class="card-body">
                <form action="" method="get">
                    <h3>Filter Auction</h3>
                    <br>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Status Auction</label>
                        <select name="status" class="form-select" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option selected="">Status</option>
                            <option value="0">Closed</option>
                            <option value="1">Opened</option>
                        </select>
                    </div>

                    <div class="col-md">
                        <small class="text-light fw-semibold d-block">Category</small>
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
                                        <input name="lower" id="one">
                                        <label for="one">$</label>
                                    </div>
                                    <div class="price-wrap_line">-</div>
                                    <div class="price-wrap-2">
                                        <input name="upper" id="two">
                                        <label for="two">$</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </form>
            </div>
        </div>
        <div style="width:100%;flex:6">
            @if ($data->count() == 0)
                <center>
                    <br>
                    <div class="misc-wrapper w-100">
                        <h4 class="mb-2 mx-2">Product not found :(</h4>

                        <div class="mt-3">
                            <img src="../assets/img/illustrations/page-misc-error-light.png" alt="page-misc-error-light"
                                width="500" class="img-fluid" data-app-dark-img="illustrations/page-misc-error-dark.png"
                                data-app-light-img="illustrations/page-misc-error-light.png" />
                        </div>
                    </div>
                </center>
            @else
                @foreach ($data as $item)
                    <div class="card mb-3">
                        <div class="row g-0" style="height: 100%">
                            <div class="col-md-4" style="height: 100%">
                                <img class="card-img card-img-left" style="width: 100%;height: 300px;object-fit:contain"
                                    src="{{ url('thumb/' . $item->thumb) }}" alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text text">
                                        {!! strip_tags($item->description) !!}
                                    </p>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="d-flex gap-3" style="justify-content: flex-end">
                                        <div id="button-save-{{ $item->id }}">

                                            @if (is_null($item->bookmarked))
                                                <button class="btn btn-outline-primary save-button"
                                                    data-item-id="{{ $item->id }}">Save</button>
                                            @else
                                                <button class="btn btn-primary unsave-button"
                                                    data-item-id="{{ $item->id }}">Saved</button>
                                            @endif
                                        </div>
                                        <a href="{{ route('detail', ['id' => $item->id]) }}"
                                            class="btn btn-primary">Bid</a>

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
        //Filter Price
        var lowerSlider = document.querySelector('#lower');
        var upperSlider = document.querySelector('#upper');

        document.querySelector('#two').value = upperSlider.value;
        document.querySelector('#one').value = lowerSlider.value;

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
            document.querySelector('#two').value = this.value
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
            document.querySelector('#one').value = this.value
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
@endsection

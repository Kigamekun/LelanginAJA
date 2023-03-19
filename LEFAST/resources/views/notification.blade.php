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
    <li class="menu-item active">
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
    <li class="menu-item ">
        <a href="{{ route('appointment') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Appointment', app()->getLocale()) }}</div>
        </a>
    </li>
@endsection


@section('content')
    @php

        function time_elapsed_string($datetime, $full = false)
        {
            $now = new DateTime();
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = [
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            ];
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) {
                $string = array_slice($string, 0, 1);
            }
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{GoogleTranslate::trans('Account Settings', app()->getLocale()) }} /</span> {{GoogleTranslate::trans('Notifications', app()->getLocale()) }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}"><i class="bx bx-user me-1"></i>
                            {{GoogleTranslate::trans('Account', app()->getLocale()) }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-bell me-1"></i>
                            {{GoogleTranslate::trans('Notifications', app()->getLocale()) }}</a>
                    </li>

                </ul>
                <div class="card">
                    <!-- Notifications -->
                    <h5 class="card-header">{{GoogleTranslate::trans('Recent Notifications', app()->getLocale()) }}</h5>
                    <div class="card-body">
                        <span>{{GoogleTranslate::trans('We need permission from your browser to show notifications.', app()->getLocale()) }}
                            <span class="notificationRequest"><strong>{{GoogleTranslate::trans('Request Permission', app()->getLocale()) }}</strong></span></span>
                        <div class="error"></div>
                    </div>

                    <div class="card-body">

                        <div class="list-group">
                            @foreach ($data as $item)
                                <a
                                    class="list-group-item list-group-item-action flex-column align-items-start notif" data-id="{{ $item->id }}">
                                    <div class="d-flex justify-content-between w-100">
                                        <h6>{{ $item->title }}</h6>
                                        <small class="text-muted">{{ time_elapsed_string($item->created_at) }}</small>
                                    </div>
                                    <p class="mb-1">
                                        {{ $item->message }}
                                    </p>

                                </a>
                            @endforeach
                        </div>

                    </div>
                    <!-- /Notifications -->
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).on("click", ".notif", function(e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('profile.mark-as-read') }}",
                method: "POST",
                data: {
                    id: $(this).data('id'),
                },
                success: function(data) {
                    console.log('readed');
                }
            });

        });
    </script>
@endsection

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


    <li class="menu-item active">
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

    <li class="menu-item ">
        <a href="{{ route('admin.user.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Analytics">User</div>
        </a>
    </li>
@endsection


@section('content')
    <div class="container">
        <br>
        <br>
        <br>

        <center>
            <h1>List Chat Help Center</h1>
        </center>
        <br>
        <br>
        <br>
        <ul class="list-group" id="list-chat">

        </ul>

    </div>
@endsection

@section('scripts')
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
                                                    https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-database.js"></script>


    <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script>
        // Initialize Firebase

        var configMessage = {
            apiKey: "AIzaSyC6qrKtZ16ml-cyjHpmbvoE89SXWUYtnDo",

            authDomain: "lelanginaja-44f6a.firebaseapp.com",

            databaseURL: "https://lelanginaja-44f6a-default-rtdb.asia-southeast1.firebasedatabase.app",

            projectId: "lelanginaja-44f6a",

            storageBucket: "lelanginaja-44f6a.appspot.com",

            messagingSenderId: "571285970917",

            appId: "1:571285970917:web:d21f3b984c9a55c7c5190c",

            measurementId: "G-PH5E80PZT2"

        };
        firebase.initializeApp(configMessage);
        firebase.analytics();
        var database = firebase.database();
        var lastIndex = 0;

        var displayed = [];

        firebase.database().ref('chat/').on('value', function(snapshot) {
            var value = snapshot.val();
            console.log(value);
            $.each(value, function(index, value) {
                try {
                    if (!displayed.includes(value.from) && value.from !== 0) {
                        $('#list-chat').append(
                            `<a href="/admin/chat/${value.from}" class="list-group-item d-flex justify-content-between align-items-center">
                                ${value.name}
                                <span class="badge bg-primary">New</span>
                            </a>`
                        );
                        displayed.push(value.from);
                    }
                    lastIndex = index;
                } catch (error) {
                }
            });
        });

    </script>

@endsection

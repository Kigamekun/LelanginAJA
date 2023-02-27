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
<style>

#list-chat {
    height: 500px;
}
  @media (max-width: 767px) {
            #list-chat {
                height: 300px;
            }

        }
        
</style>
    <div class="container">
        <br>
        <br>
        <br>

        <center>
            <h1>{{ DB::table('users')->where('id', $id)->first()->name }}</h1>
        </center>
        <br>
        <br>
        <br>
        <div id="list-chat" style="overflow-y:scroll;overflow-x:hidden;">

        </div>

        <br>
        <br>
        <br>
        <div class="d-flex gap-5">

            <input type="text" id="chat" class="form-control">
            <button id="submit" class="btn btn-primary">Send</button>
        </div>
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
                    if (!displayed.includes(index)) {
                        console.log(index);


                        if (value.for == 0) {
                            if (value.from == @json($id)) {

                                $('#list-chat').append(
                                    `<div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        ${value.chat}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                                );
                            }
                            displayed.push(index);
                        }
                        if (value.from == 0) {
                            if (value.for == @json($id)) {


                            $('#list-chat').append(
                                `
                            <div class="d-flex justify-end w-100" style="justify-content: end;">
                                <div class="col-md-6">
                                    <div class="card mb-3" style="background:#696cff;color:white;">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        ${value.chat}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `
                            );
                            }
                            displayed.push(index);
                        }
                    }

                    lastIndex = index;

                } catch (error) {

                }
            });

            var objDiv = document.getElementById("list-chat");
            objDiv.scrollTop = objDiv.scrollHeight;
        });

        function deleteUser(params) {
            var id = params.dataset.id;
            firebase.database().ref('chat/' + id).remove();
        }
        $('#submit').on('click', function() {
            
             if( $('#chat').val() !== '') {
                 var userID = lastIndex + 1;
            console.log('ada');
            var x = firebase.database().ref('chat/' + userID).set({
                for: @json($id),
                from: 0,
                name: 'Admin',
                chat: $('#chat').val()
            });

            console.log(x);
            // Reassign lastID value
            var objDiv = document.getElementById("list-chat");
            objDiv.scrollTop = objDiv.scrollHeight;
            lastIndex = userID;
            $('#chat').val('');
             }
            
            
            
            
        });
    </script>
    <script>
        $(document).keyup(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $('#submit').click();
                return false;
            }
        });
    </script>
@endsection

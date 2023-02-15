<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}" />
</head>

<body>
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 14px;
        }
    </style>
    <div class="contentMain">
        <h2 class="pageNameContent">Manage Chat</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Chat</li>
        </ol>

        <div class="card">
            <ul class="list-group list-group-flush" id="list-chat">

            </ul>
        </div>
    </div>

    <!--Ion Icon-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
                    https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-database.js"></script>


    <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script>
        // Initialize Firebase

        var config = {
            apiKey: "AIzaSyC6qrKtZ16ml-cyjHpmbvoE89SXWUYtnDo",

            authDomain: "lelanginaja-44f6a.firebaseapp.com",

            databaseURL: "https://lelanginaja-44f6a-default-rtdb.asia-southeast1.firebasedatabase.app",

            projectId: "lelanginaja-44f6a",

            storageBucket: "lelanginaja-44f6a.appspot.com",

            messagingSenderId: "571285970917",

            appId: "1:571285970917:web:d21f3b984c9a55c7c5190c",

            measurementId: "G-PH5E80PZT2"

        };
        firebase.initializeApp(config);
        firebase.analytics();
        var database = firebase.database();
        var lastIndex = 0;


        firebase.database().ref('chat/').on('value', function(snapshot) {
            var value = snapshot.val();

            var htmls = [];
            var senders = [];
            console.log('ini value di serialize' + value);
            console.log(htmls);
            $.each(value, function(index, value) {
                try {
                    if (!senders.includes(value.from)) {
                        senders.push(value.from);
                        $('#list-chat').append(
                            `<li class="list-group-item"><a href="/admin/chat/${value.from}">${value.from}</a></li>`
                            );
                    }
                } catch (error) {

                }
            });

            // var element = document.getElementById("chatContainer");
            // element.before(htmls, element.firstChild);


        });

        function deleteUser(params) {
            var id = params.dataset.id;
            firebase.database().ref('chat/' + id).remove();
        }

        // Add Data
        $('#submitUser').on('click', function() {
            var values = $("#addUser").serializeArray();
            var for_who = values[0].value;
            var from_who = values[1].value;
            var chat = values[2].value;
            var userID = lastIndex + 1;

            firebase.database().ref('chat/' + userID).set({
                for: for_who,
                from: from_who,
                chat: chat
            });
            // Reassign lastID value
            lastIndex = userID;
            $('#chat').val('');
        });
    </script>

    <script>
        $(document).keyup(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $('#submitUser').click();
                return false;
            }
        });
    </script>
</body>

</html>

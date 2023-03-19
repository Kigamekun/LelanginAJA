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


    <li class="menu-item active">
        <a href="{{ route('help-center') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-support"></i>
            <div data-i18n="Analytics">Help Center</div>
        </a>
    </li>
@endsection

@section('content')
    <style>
        .access:hover {
            border: 1px solid #696cff;
            color: #696cff;
            cursor: pointer;
        }

        .access {
            border: 1px solid gray;
        }

        a {
            color:#697a8d;
        }
    </style>

    <div class="container d-flex mt-5 gap-5">
        <div class="card" style="flex:5">

            <div class="card-body">
                <center>
                    <img style="width: 200px" src="https://cdn-icons-png.flaticon.com/512/190/190119.png" alt="">
                </center>
                <br>
                <center>
                    <h3>Help Center</h3>
                    <p>Ada yang bisa kami bantu ?</p>
                </center>
                <div class="d-flex justify-content-center gap-3">
                    <a target="_blank" href="https://api.whatsapp.com/send/?phone=62895331493506&text=Hello+LelanginAJA+saya+butuh+bantuan+!!!&type=phone_number&app_absent=0" class="card access"
                        style="width:100px;padding:10px;display:flex;justify-content:center;align-items:center;gap:10px;">
                        <i class='bx bx-phone-call bx-lg'></i>
                        <h5>Telphone</h5>
                    </a>
                    <a target="_blank" href="mailto:{{ env('MAIL_USERNAME') }}" class="card access"
                        style="width:100px;padding:10px;display:flex;justify-content:center;align-items:center;gap:10px;">
                        <i class='bx bx-mail-send bx-lg'></i>
                        <h5>E- Mail</h5>
                    </a>
                    <a href="{{ route('chat') }}" class="card access"
                        style="width:100px;padding:10px;display:flex;justify-content:center;align-items:center;gap:10px;">
                        <i class='bx bx-conversation bx-lg'></i>
                        <h5>Chat</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

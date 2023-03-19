<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PH5E80PZT2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PH5E80PZT2');
</script>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>LelanginAJA | The best partner for your "Lelang"</title>
<meta name="description" content="LelanginAJA is a super app that will help you find auction items in Indonesia which can give you a realtime experience in participating in auctions comfortably.">
    <meta name="keywords" content="LelanginAJA, lelang indonesia, lelang">
    <meta name="author" content="LelanginAJA Indonesia">
    
    
    
    
<!-- Site Name, Title, and Description to be displayed -->
<meta property="og:site_name" content="Lelangin AJA">
<meta property="og:title" content="Lelangin AJA Indonesia">


<!-- Image to display -->
<!-- Replace   «example.com/image01.jpg» with your own -->
<meta property="og:image" content="https://i.ibb.co/crtzQzW/Lelangin-AJAWithout-Text.png">

<!-- No need to change anything here -->
<meta property="og:type" content="website" />
<meta property="og:image:type" content="image/png">

<!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="300">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  
  {{-- <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" /> --}}
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ url('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ url('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('assets/js/config.js') }}"></script>
    @yield('styles')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/" class="app-brand-link">
                        <span class="app-brand-logo demo">
                         <img width="25" style="border-radius:5px" src="{{ url('assets/img/icons/sneat.png') }}" alt="">

                        </span>
                        <span class="app-brand-text demo menu-text fw-bolder ms-2">LelanginAJA</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    @yield('menu')
                    
                <li class="menu-item mt-5">
                    <div class="container"><hr></div>
                  {{-- <a href="/" class="menu-link">
           <i class='menu-icon tf-icons  bx bx-plus-medical' ></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Download AddOns', app()->getLocale()) }}</div>
        </a> --}}
       <div class="d-flex justify-content-center">
            <a target="_blank" href="https://lelanginajacoba.masuk.web.id/app-release.apk" class="menu-link btn btn-outline-success">
          <i  class='bx bxl-android bx-sm'></i>
        </a>
         <a target="_blank" href="https://lelanginajacoba.masuk.web.id/GuideBook-LelanginAJA.pdf" class="menu-link btn btn-outline-info">
         <i class='bx bxs-book bx-sm' ></i>
        </a>
       </div>
    </li>

                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">

                                <i class="bx bx-search fs-4 lh-0"></i>
                                <form action="{{ route('auction-list') }}" method="get">
                                    <input type="text" class="form-control border-0 shadow-none"
                                        placeholder="Search..." name="query" aria-label="Search..." />
                                </form>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                      <li class="nav-item me-2">
                          
                            <select class="form-select changeLang">

                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                             <option value="id" {{ session()->get('locale') == 'id' ? 'selected' : '' }}>Indonesia</option>
 <option value="ja" {{ session()->get('locale') == 'ja' ? 'selected' : '' }}>Japan</option>
                            <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>France</option>

                            <option value="es" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Spanish</option>
<option value="ru" {{ session()->get('locale') == 'ru' ? 'selected' : '' }}>Russian</option>
                        </select>
                      </li>

                            <!-- User -->
                            @if (Auth::check())
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            <img src="
                                            @if (strpos(Auth::user()->thumb, "https://")!==false)
                                            {{ Auth::user()->thumb }}
                                            @else

                                            {{ url('avatar/'.Auth::user()->thumb) }}
                                            @endif
                                            " style="width:40px !important;height:40px !important" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="
                                                            @if (strpos(Auth::user()->thumb, "https://")!==false)
                                                            {{ Auth::user()->thumb }}
                                                            @else

                                                            {{ url('avatar/'.Auth::user()->thumb) }}
                                                            @endif" style="width:40px !important;height:40px !important" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                        <small class="text-muted">Admin</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">My Profile</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="{{ route('notifications') }}">
                                                <span class="d-flex align-items-center align-middle">
                                                    <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                    <span class="flex-grow-1 align-middle">Notification</span>
                                                    @if ($nt = DB::table('notifications')->where(['for'=>Auth::id(),'is_read'=>0])->count() > 0)
                                                    <span
                                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">{{$nt}}</span>

                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item ">
                                    <a href="{{ route('login') }}" class="nav-link">{{GoogleTranslate::trans('Login', app()->getLocale()) }}</a>

                                </li>
                                {{-- <li class="nav-item ">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>

                                </li> --}}
                            @endif
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->

                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->

    <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script async defer src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>

    <script src="{{ url('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
   

    <!-- Main JS -->
    <script async defer src="{{ url('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (!is_null(Session::get('message')))
      
        <script>
            Swal.fire({
                position: 'center',
                icon: @json(Session::get('status')),
                title: @json(Session::get('status')),
                html: @json(Session::get('message')),
                showConfirmButton: false,
                timer: 4000
            })
        </script>
    @endif





    @if (!empty($errors->all()))
        
        <script>
            var err = @json($errors->all());
            var txt = '';
            Object.keys(err).forEach(element => {
                txt += err[element] + '<br>';
            });
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                html: txt,
                showConfirmButton: false,
                timer: 4000
            })
        </script>
    @endif
    
    <script type="text/javascript">
        var url = "{{ route('changeLang') }}";
        $(".changeLang").change(function(){
            window.location.href = url + "?lang="+ $(this).val();
        });
    </script>

    @yield('scripts')
</body>

</html>

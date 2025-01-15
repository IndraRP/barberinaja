<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Rawr Apps')</title>

    <!-- Swiper CSS -->
    {{-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"> --}}

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Splide -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    <!-- Slick Carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <!-- Custom Styles -->
    @yield('styles')
    @livewireStyles

</head>

<body class="bg-dark text-gray-900">
    @if (
        !in_array(Route::currentRouteName(), [
            'tren.detail',
            'service.detail',
            'barberdetail',
            'bookingdetail',
            'history_detail',
            'form',
            'metodepembayaran',
            'konfirmasi',
            'login',
            'signup',
            'trendetail',
            'forgot-password',
        ]))
        @include('layouts.navbar')
    @endif

    <!-- Page Content -->
    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    {{-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>    
    <script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-intersection@0.2.0/dist/js/splide-extension-intersection.min.js
    "></script>
    <script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js
    "></script>

    @stack('scripts')
    @livewireScripts

    
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <x-livewire-alert::scripts />

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;

            const links = [{
                    path: '/customer/dashboard',
                    id: 'dashboardLink',
                    icon: 'bi-house-door',
                    activeIcon: 'bi-house-door-fill'
                },
                {
                    path: '/customer/booking',
                    id: 'bookingLink',
                    icon: 'bi-bag-plus',
                    activeIcon: 'bi-bag-plus-fill'
                },
                {
                    path: '/customer/history',
                    id: 'orderLink',
                    icon: 'bi-bag-check',
                    activeIcon: 'bi-bag-check-fill'
                },
                {
                    path: '/customer/profile',
                    id: 'profileLink',
                    icon: 'bi-person',
                    activeIcon: 'bi-person-fill'
                },
            ];

            links.forEach(link => {
                const element = document.getElementById(link.id);

                // Cek apakah elemen ditemukan
                if (element) {
                    const icon = element.querySelector('i');

                    if (currentPath === link.path) {
                        element.classList.add('active');

                        // Cek apakah ikon ada sebelum manipulasi
                        if (icon) {
                            icon.classList.remove(link.icon);
                            icon.classList.add(link.activeIcon);
                        }
                    }
                } else {
                    console.warn(`Element with id '${link.id}' not found.`);
                }
            });

        }); --}}
    </script>
</body>

</html>

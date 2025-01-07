@section('title', 'Booking Detail')

<div class="pb-5 mb-3">
    <section class="">
        <div class="pb-1">
            <div style="position: relative;">
                <!-- Gambar utama -->
                <img src="{{ isset($service->image) ? asset('storage/' . $service->image) : 'https://via.placeholder.com/300x200' }}"
                    alt="{{ $service->name ?? 'Layanan' }}" class="d-block"
                    style="height: 300px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
            </div>

            <div class="p-3">
                <div class="d-block align-items-center" id="main-container">
                    <div class="d-flex flex-column m-0" id="text-container">
                        <h1 class="text-white fs-5 m-0">{{ $service->name ?? 'Potong Rambut' }}</h1>
                    </div>
                    <div class="d-flex align-items-center mt-2" id="action-container">
                        <h1 class="emas fs-5 m-0">Rp {{ number_format($currentPrice ?? 0, 0, ',', '.') }}</h1>
                    </div>
                </div>
            </div>

            <div class="px-3">
                <p class="fs-7 text-white m-0">{{ $service->description ?? 'Deskripsi layanan belum tersedia.' }}</p>
            </div>

            <!-- Service Section -->
            <div class="d-flex align-items-center mt-3 mx-3">
                <h2 class="text-white fs-6 mb-0">Layanan Lainnya</h2>
                <a href="/booking" class="text-info ms-auto m-0 fs-7 text-decoration-none">Lihat Semua</a>
            </div>
        </div>

        <!-- Layanan lainnya -->
        <section class="px-3 pt-2 mb-2">
            <div class="pb-0" style="white-space: nowrap; position: relative; overflow-x: auto">
                <div style="display: inline-flex; min-width: 100%; width: fit-content;">
                    @foreach ($services as $service)
                        {{-- Memeriksa apakah ID layanan tidak sama dengan ID yang ada di route URL saat ini --}}
                        @if ($service->id != request()->segment(2))
                            {{-- Gunakan segment(2) jika ID ada di posisi kedua URL --}}
                            <div
                                style="flex-shrink: 0; width: 170px; {{ $loop->last ? '' : 'margin-right: 10px;' }} position: relative;">
                                <!-- Link ke halaman detail -->
                                <a href="/bookingdetail/{{ $service->id }}" style="display: block;">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                        class="rounded d-block"
                                        style="height: 150px; width: 100%; border: none; box-shadow: none; object-fit: cover;">

                                    <div
                                        class="position-absolute bottom-0 start-0 text-white bg-dark bg-opacity-50 fs-9 w-100 text-center p-1">
                                        <p class="mb-0">{{ $service->name }}</p>
                                        <p class="mb-0 emas">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <div class="p-2 bawah fixed-bottom">
            <div class="d-flex justify-content-between align-items-center px-1" id="main-container">
                <div class="d-flex flex-column m-0" id="text-container">
                    <h1 class="fs-5 emas m-0">Rp {{ number_format($currentPrice ?? 0, 0, ',', '.') }}</h1>
                </div>
                <div class="d-flex align-items-center" id="action-container">
                    <button type="button" class="btn kuning text-white fs-6 fw-bold py-2 px-3"
                        wire:click="saveServiceToSession({{ $service->id }})">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>

    </section>


    <!-- Header dengan Tombol Kembali -->
    <div id="header" class="position-fixed w-100 top-0 start-0 bg-transparent transition-all">
        <div class="d-flex justify-content-between align-items-center p-2">
            <!-- Tombol Kembali -->
            <div class="d-flex align-items-center">
                <a href="/booking" id="backButton" class="text-white abu rounded-circle p-2 ms-2 my-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </a>
                <!-- Text Detail Layanan -->
                <p id="detailText" class="text-white fs-5 mt-3 fw-bolder ms-2 d-none">Detail Layanan</p>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            const detailText = document.getElementById('detailText');

            if (window.scrollY > 50) { // Jika scroll lebih dari 50px
                header.classList.add('scrolled'); // Tambahkan class pada header
                detailText.classList.remove('d-none'); // Tampilkan teks
            } else {
                header.classList.remove('scrolled'); // Hapus class dari header
                detailText.classList.add('d-none'); // Sembunyikan teks
            }
        });
    </script>


    <style>
        .kuning1 {
            background-color: #7c6727b9;
        }

        #header {
            background-color: transparent;
            /* Default background */
            z-index: 1000;
            transition: background-color 0.3s ease;
            /* Transisi untuk latar belakang */
        }

        #header.scrolled a {
            background-color: #00000000;
        }

        #header.scrolled {
            background-color: #212529 !important;
            /* Tambahkan !important untuk memastikan aturan CSS diterapkan */
        }

        .abu1 {
            background-color: #2d30338b;
        }
    </style>
</div>

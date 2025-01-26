@section("title", "Booking Detail")

@section("styles")

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
@endsection

<div class="mb-4 pb-5">
    <section class="">
        <div class="pb-1">
            <div style="position: relative;">
                <!-- Gambar utama -->
                <img src="{{ isset($service->image) ? asset("storage/" . $service->image) : "https://via.placeholder.com/300x200" }}" alt="{{ $service->name ?? "Layanan" }}" class="d-block" style="height: 300px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
            </div>

            <div class="p-3">
                <div class="d-block align-items-center" id="main-container">
                    <div class="d-flex flex-column m-0" id="text-container">
                        <h1 class="fs-5 m-0 text-white">{{ $service->name ?? "Potong Rambut" }}</h1>
                    </div>
                    <div class="d-flex align-items-center mt-2" id="action-container">
                        <h1 class="emas fs-5 m-0">Rp {{ number_format($currentPrice ?? 0, 0, ",", ".") }}</h1>
                    </div>
                </div>
            </div>

            <div class="px-3">
                <p class="fs-7 m-0 text-white">{{ $service->description ?? "Deskripsi layanan belum tersedia." }}</p>
            </div>

            <!-- Service Section -->
            <div class="d-flex align-items-center mx-3 mt-3">
                <h2 class="fs-6 mb-0 text-white">Layanan Lainnya</h2>
                <a href="/booking" class="text-info fs-7 text-decoration-none m-0 ms-auto">Lihat Semua</a>
            </div>
        </div>

        <!-- Layanan lainnya -->
        <section class="mb-2 px-3 pt-2">
            <div class="pb-0" style="white-space: nowrap; position: relative; overflow-x: auto">
                <div style="display: inline-flex; min-width: 100%; width: fit-content;">
                    @foreach ($services as $service)
                        {{-- Memeriksa apakah ID layanan tidak sama dengan ID yang ada di route URL saat ini --}}
                        @if ($service->id != request()->segment(2))
                            {{-- Gunakan segment(2) jika ID ada di posisi kedua URL --}}
                            <div style="flex-shrink: 0; width: 170px; {{ $loop->last ? "" : "margin-right: 10px;" }} position: relative;">
                                <!-- Link ke halaman detail -->
                                <a href="/bookingdetail/{{ $service->id }}" style="display: block;">
                                    <img src="{{ asset("storage/" . $service->image) }}" alt="{{ $service->name }}" class="d-block rounded" style="height: 150px; width: 100%; border: none; box-shadow: none; object-fit: cover;">

                                    <div class="position-absolute bg-dark fs-9 w-100 bottom-0 start-0 bg-opacity-50 p-1 text-center text-white">
                                        <p class="mb-0">{{ $service->name }}</p>
                                        <p class="emas mb-0">Rp {{ number_format($service->price, 0, ",", ".") }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <div class="bawah fixed-bottom p-2">
            <div class="d-flex justify-content-between align-items-center px-1" id="main-container">
                <div class="d-flex flex-column m-0" id="text-container">
                    <h1 class="fs-5 emas m-0">Rp {{ number_format($currentPrice ?? 0, 0, ",", ".") }}</h1>
                </div>
                <div class="d-flex align-items-center" id="action-container">
                    <button type="button" class="btn kuning fs-6 fw-bold px-3 py-2 text-white" wire:click="saveServiceToSession({{ $service->id }})">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>

    </section>


    <!-- Header dengan Tombol Kembali -->
    <div id="header" class="position-fixed w-100 start-0 top-0 bg-transparent transition-all">
        <div class="d-flex justify-content-between align-items-center p-1">
            <!-- Tombol Kembali -->
            <div class="d-flex align-items-center">
                <a href="javascript:void(0)" onclick="handleBack()" class="abu rounded-circle my-1 p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </a>
                <!-- Text Detail Layanan -->
                <p id="detailText" class="fs-6 fw-bolder d-none ms-2 mt-3 text-white">Detail Layanan</p>
            </div>
        </div>
    </div>
    <script>
        function handleBack() {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }
    </script>
</div>

@push("scripts")
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
@endpush

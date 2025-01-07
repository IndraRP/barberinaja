<div class="">
    <!-- Kontainer Gambar dan Nama Tren -->
    <section class="mb-3">
        <div class="pb-1">
            <div style="position: relative;">
                <!-- Gambar utama -->
                <img src="{{ isset($trend->image) ? asset('storage/' . $trend->image) : 'https://via.placeholder.com/300x200' }}"
                    alt="{{ $trend->name ?? 'Tren' }}" class="d-block"
                    style="height: 300px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
            </div>

            <!-- Detail Tren -->
            <div class="p-3 ">
                <h1 class="text-white fs-5 m-0 mt-2">{{ $trend->name ?? 'Potong Rambut' }}</h1>
                <p class="fs-7 text-white m-0 mt-2">{{ $trend->description ?? 'Deskripsi Tren belum tersedia.' }}</p>
            </div>
        </div>

        <!-- Tombol Pesan Tren -->
        <section class="my-2 pt-1">
            <div class="mx-3 kuning1 rounded-3">
                <div class="d-flex p-2 pt-3 pb-4 align-items-center">
                    <div class="text-white fs-9 mb-0 ms-1 mt-2 text-start">
                        <p class="mb-0">Kamu Ingin mempunyai gaya rambut seperti ini?</p>
                        <p class="mb-0">Kita Bisa lhoo!!!</p>
                        <p class="fs-8 fw-bolder mb-0">Ayoo Pesan, Hanya di Barberinaja </p>
                        <div class="d-flex justify-content-center">
                            <a href="/bookingdetail/2">
                                <button class="btn kuning text-white fs-9 btn-sm booking-btn mt-2 px-5">Pesan
                                    Sekarang</button>
                            </a>
                        </div>
                    </div>
                    <div class="text-white ms-auto me-1">
                        <img src="{{ isset($trend->image) ? asset('storage/' . $trend->image) : 'https://via.placeholder.com/300x200' }} "
                            alt="{{ $trend->name ?? 'Tren' }}" class="d-block rounded"
                            style="height: 70px; width: 70px; border: none; box-shadow: none; object-fit: cover;" />
                    </div>
                </div>
            </div>
        </section>

        <section class="pb-2 pt-1 px-3">
            <h1 class="text-white fs-6 mt-3 mb-0">Tren Lainnya</h1>
            <div style="overflow-x: auto; white-space: nowrap; padding-top: 16px;">
                @foreach ($trends as $index => $trend)
                    @if ($trend->id != request()->route('id'))
                        <a href="/trendetail/{{ $trend->id }}">
                            <div class="tren rounded {{ $loop->last ? '' : 'mx-1' }}"
                                style="display: inline-block; width: 250px;">
                                <div class="p-2">
                                    <div
                                        style="display: flex; justify-content: center; align-items: center; 
                                                width: 230px; height: 150px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $trend->image) }}" alt="{{ $trend->name }}"
                                            class="rounded d-block"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="px-2" style="overflow: hidden;">
                                        <h5 class="text-white mb-0 fs-7 pt-2">{{ $trend->name }}</h5>
                                        <p class="text-white mb-0 fs-8"
                                            style="overflow: hidden; text-overflow: ellipsis; max-width: 230px;">
                                            {{ $trend->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </section>
    </section>

   
    <!-- Header dengan Tombol Kembali -->
    <div id="header" class="position-fixed w-100 top-0 start-0 bg-transparent transition-all">
        <div class="d-flex justify-content-between align-items-center p-2">
            <!-- Tombol Kembali -->
            <div class="d-flex align-items-center">
                <a href="/" id="backButton" class="text-white abu rounded-circle p-2 ms-2 my-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </a>
                <!-- Text Detail Layanan -->
                <p id="detailText" class="text-white fs-5 mt-3 fw-bolder ms-2 d-none">Detail Tren</p>
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
    </style>
</div>

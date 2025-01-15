@section('title', 'Berber Detail')

@section('styles')
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

<div>
    <section class="mb-3">
        <div class="pb-1">
            <div style="position: relative;">
                <!-- Gambar utama -->
                <img src="{{ isset($barber->image) ? asset('storage/' . $barber->image) : 'https://via.placeholder.com/300x200' }}"
                    alt="{{ $barber->name ?? 'Barber' }}" class="d-block"
                    style="height: 300px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
            </div>

            <!-- Detail Tren -->
            <div class="p-3">
                <div class="d-block align-items-center" id="main-container">
                    <div class="d-flex flex-column m-0" id="text-container">
                        <h1 class="text-white fs-5 m-0">{{ $barber->name ?? 'Potong Rambut' }}</h1>
                    </div>
                </div>
            </div>

            <div class="px-3">
                <p class="fs-7 text-white m-0">{{ $barber->description ?? 'Deskripsi Tren belum tersedia.' }}</p>
            </div>
        </div>


        <!-- Daftar Barber -->
        <section class="py-2 px-2">
            <h1 class="text-white fs-6 px-1 mt-4 mb-0">Barber lainnya</h1>
            <div style="overflow-x: auto; white-space: nowrap; padding-top: 16px;">
                @foreach ($barbers as $index => $barber)
                    @if ($barber->id != request()->segment(2))
                        <a href="/barberdetail/{{ $barber->id }}">
                            <div class="tren rounded {{ $loop->last ? '' : 'mx-1' }}"
                                style="display: inline-block; width: 250px;">
                                <div class="p-2">
                                    <div
                                        style="display: flex; justify-content: center; align-items: center; 
                                                width: 230px; height: 150px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $barber->image) }}" alt="{{ $barber->name }}"
                                            class="rounded d-block"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="px-2" style="overflow: hidden;">
                                        <h5 class="text-white mb-0 fs-7 pt-2">{{ $barber->name }}</h5>
                                        <p class="text-white mb-0 fs-8"
                                            style="overflow: hidden; text-overflow: ellipsis; max-width: 230px;">
                                            {{ $barber->description }}
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
        <div class="d-flex justify-content-between align-items-center p-1">
            <!-- Tombol Kembali -->
            <div class="d-flex align-items-center">
                <a href="/" id="backButton" class="text-white abu rounded-circle p-2 my-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </a>
                <!-- Text Detail Layanan -->
                <p id="detailText" class="text-white fs-6 mt-3 fw-bolder ms-2 d-none">Detail Barber</p>
            </div>
        </div>
    </div>
</div>


@push('scripts')
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

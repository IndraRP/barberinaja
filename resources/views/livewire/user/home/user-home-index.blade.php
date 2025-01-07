@section('styles')
    <style>
        .splide {
            padding-top: 10px;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .splide__slide {
            border-radius: 15px;
            overflow: hidden;
        }

        .splide__image {
            border-radius: 15px;
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
        }

        .splide__pagination {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 2;
            margin: 0;
            padding: 0;
        }

        .splide_pagination_page {
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.504);
            transition: background 0.3s ease, transform 0.3s ease;
            width: 6px;
            height: 6px;
        }

        .splide_pagination_page.is-active {
            background: #c7980b8c;
            width: 8px;
            height: 8px;
        }

        .splide__track--draggable {
            border-radius: 15px;
        }

        .Splide @media (max-width: 600px) {
            .splide_pagination_page {
                width: 6px;
                height: 6px;
            }
        }

        #search-icon:hover {
            background-color: #6c757d;
            /* bg-secondary */
        }
    </style>
@endsection


<div class="home pb-5 mb-5" id="content">

    <!-- Header -->
    <div x-data="{ isVisible: true }">
        <div class="navbar navbar-dark bg-dark fixed-top d-flex justify-content-between align-items-center p-3">
            <div class="d-flex flex-column">
                <span class="text-white fs-8">Selamat pagi</span>
                <h1 class="h6 text-white m-0 fs-7">{{ $name }}</h1>
            </div>
            <div class="d-flex align-items-center">
                <!-- Search Icon -->
                <button class="btn btn-dark border border-light rounded-pill" type="button"
                    style="height: 40px; width: 40px; transition: background-color 0.3s;"
                    @click="isVisible = isVisible ? false : true">
                    <i class="bi bi-search text-white"></i>
                </button>
                <!-- Foto Profil -->
                <img src="{{ asset('storage/' . ($image ?? 'images/profiles/barber1.png')) }}"
                    class="rounded-circle border border-white ms-3 object-fit-cover" style="height: 40px; width: 40px;"
                    alt="Profile">
            </div>
            <div x-show="!isVisible" class="mt-3 w-100">
                @include('livewire.user.home.search-input')
            </div>
        </div>
        <div x-show="isVisible" class="mt-2 px-2 w-100">
            @include('livewire.user.home.search-input')
        </div>
    </div>

    <!-- Banner Section -->
    <section class="splide mt-1 pb-1" style="border-radius: 15px">
        <div class="splide__track" style="border-radius: 15px">
            <ul class="splide__list" style="border-radius: 15px">
                <li class="splide__slide px-2" style="border-radius: 15px">
                    <img src="https://static.republika.co.id/uploads/images/inpicture_slide/captain_221104100511-473.jpeg"
                        alt="Slide 01" class="splide__image" />
                </li>
                <li class="splide__slide px-2">
                    <img src="https://img.okezone.com/content/2023/03/02/612/2773878/support-pejuang-kanker-captain-barbershop-gratiskan-customer-yang-mau-botak-di-campaign-captaincancercare-ahApvULolF.JPG"
                        alt="Slide 02" class="splide__image" />
                </li>
                <li class="splide__slide px-2">
                    <img src="https://surabayaasik.com/wp-content/uploads/2023/03/Rekomendasi-Kursus-Barbershop-di-Surabaya.jpg"
                        alt="Slide 03" class="splide__image" />
                </li>
                <li class="splide__slide px-2">
                    <img src="https://cdn.camberwellshopping.com.au/wp-content/uploads/2021/07/13111806/The-best-barbers-in-Camberwell.jpg"
                        alt="Slide 03" class="splide__image" />
                </li>
                <li class="splide__slide px-2">
                    <img src="https://images.squarespace-cdn.com/content/v1/62f1307024cba25fc6025b32/31700a79-c001-45ff-9809-3081c8dcbf5b/AdobeStock_374326500.jpeg"
                        alt="Slide 03" class="splide__image" />
                </li>
            </ul>
        </div>
    </section>

    <!-- Attention Section -->
    <div class="px-2 pb-2">
        <!-- Menampilkan transaksi approved -->
        @if (count($approvedTransactions) === 0)
        @else
            <div class="transactions mt-4 tren px-2 pb-2 pt-3 rounded">
                <div class="d-flex align-items-center">
                    <h3 class="emas fs-6 fs-bolder m-0">Transaksi Disetujui :</h3>
                    <button type="button" class="btn btn-outline-success ms-auto fs-11">Pembayaran Disetujui</button>
                </div>
                <ul class="list-group fs-8 pt-1">
                    @foreach ($approvedTransactions as $transaction)
                        <a href="{{ url('/detail_riwayat/' . $transaction->id) }}">
                            <li class="list-group-item abu border border-warning rounded my-1 px-2 text-white">
                                <div class="d-flex">
                                    <div class="d-block m-0">
                                        <p class="fs-7 fw-bolder mb-0 mt-1">Jadwal Anda :</p>
                                        <p class="m-0 fs-7">
                                            @foreach ($transaction->details as $detail)
                                                {{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}
                                            @endforeach
                                        </p>
                                    </div>

                                    <div class="text-end ms-auto">
                                        <p class="m-0">
                                            <span>{{ $transaction->formatted_date }}</span> : <strong
                                                class="bi bi-calendar fs-6"></strong>
                                        </p>
                                        <p class="m-0">
                                            <span>{{ $transaction->formatted_time }}</span> : <strong
                                                class="bi bi-stopwatch fs-6"></strong>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Menampilkan transaksi pending -->
        @if (count($pendingTransactions) === 0)
        @else
            <div class="transactions mt-4 tren px-2 pb-2 pt-3 rounded">
                <div class="d-flex align-items-center">
                    <h3 class="emas fs-6 fs-bolder m-0">Transaksi Pending :</h3>
                    <button type="button" class="btn btn-outline-danger ms-auto fs-11">Menunggu Pembayaran</button>
                </div>
                <ul class="list-group fs-8 pt-1">
                    @foreach ($pendingTransactions as $transaction)
                        <a href="{{ url('/konfirmasi/' . $transaction->id) }}">
                            <li class="list-group-item abu border border-warning rounded my-1 px-2 text-white">
                                <div class="d-flex">
                                    <div class="d-block m-0">
                                        <p class="fs-7 fw-bolder mb-0 mt-1">Jadwal Anda :</p>
                                        <p class="m-0 fs-7">
                                            @foreach ($transaction->details as $detail)
                                                {{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}
                                            @endforeach
                                        </p>
                                        <p class="m-0 fs-7 emas fw-bolder">
                                            <span>Total Harga</span>
                                            @foreach ($transaction->details as $detail)
                                                Rp {{ number_format($detail->total_harga) }}
                                            @endforeach
                                        </p>
                                    </div>

                                    <div class="text-end ms-auto">
                                        <p class="m-0">
                                            <span>{{ $transaction->formatted_date }}</span> : <strong
                                                class="bi bi-calendar fs-6"></strong>
                                        </p>
                                        <p class="m-0">
                                            <span>{{ $transaction->formatted_time }}</span> : <strong
                                                class="bi bi-stopwatch fs-6"></strong>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Menampilkan transaksi menunggu konfirmasi -->
        @if (count($waitingConfirmationTransactions) === 0)
        @else
            <div class="transactions mt-4 tren px-2 pb-2 pt-3 rounded">
                <div class="d-flex align-items-center">
                    <h3 class="emas fs-6 fs-bolder m-0">Menunggu Konfirmasi:</h3>
                    <button type="button" class="btn btn-outline-warning ms-auto fs-11">Menunggu Konfirmasi</button>
                </div>
                <ul class="list-group fs-8 pt-1">
                    @foreach ($waitingConfirmationTransactions as $transaction)
                        <a href="{{ url('/detail_riwayat/' . $transaction->id) }}">
                            <li class="list-group-item abu border border-warning rounded my-1 px-2 text-white">
                                <div class="d-flex">
                                    <div class="d-block m-0">
                                        <p class="fs-7 fw-bolder mb-0 mt-1">Jadwal Anda :</p>
                                        <p class="m-0 fs-7">
                                            @foreach ($transaction->details as $detail)
                                                {{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}
                                            @endforeach
                                        </p>
                                    </div>

                                    <div class="text-end ms-auto">
                                        <p class="m-0">
                                            <span>{{ $transaction->formatted_date }}</span> : <strong
                                                class="bi bi-calendar fs-6"></strong>
                                        </p>
                                        <p class="m-0">
                                            <span>{{ $transaction->formatted_time }}</span> : <strong
                                                class="bi bi-stopwatch fs-6"></strong>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif


    </div>


    <!-- Layanan Section -->
    <section class="pt-3 px-2">
        <div class="d-flex align-items-center">
            <h2 class="text-white fs-6 mb-0">Layanan</h2>
            <a href="/booking" class="text-info ms-auto m-0 fs-7 text-decoration-none">Lihat Semua</a>
        </div>

        <div class="pb-0 pt-3" style="white-space: nowrap; position: relative; overflow-x: auto">
            <div style="display: inline-flex; min-width: 100%; width: fit-content;">
                @foreach ($services as $service)
                    <div
                        style="flex-shrink: 0; width: 120px;  {{ $loop->last ? '' : 'margin-right: 10px;' }} position: relative;">
                        <a href="/bookingdetail/{{ $service->id }}" style="display: block;">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                class="rounded d-block"
                                style="height: 140px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                            <div
                                class="position-absolute bottom-0 start-0 text-white bg-dark bg-opacity-50 fs-9 w-100 text-center p-1">
                                <p class="mb-0">{{ $service->name }}</p>
                                <p class="mb-0 emas">Rp {{ number_format($service->price) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Barber Section -->
    <section class="pt-3">
        <div class="d-flex align-items-center mx-2">
            <h2 class="text-white fs-6 mb-0">Barber Kami</h2>
        </div>
        <div class="d-flex justify-content-center gap-2 mt-3">
            @foreach ($barbers as $barber)
                <a href="/barberdetail/{{ $barber->id }}">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $barber->image) }}" class="rounded-circle"
                            style="height: 61px; width: 61px; cursor: pointer; object-fit: cover;"
                            alt="{{ $barber->name }}">
                        <p class="text-white fs-8 mt-1">{{ $barber->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- diskon Section -->
    <section class="mt-3 px-2">
        <div class="d-flex overflow-auto">
            <!-- Slide Pertama -->
            <div class="flex-shrink-0 rounded kuning p-3 me-2 klaim-btn" style="width: 265px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-1 fs-8">Segera Potong!!!</p>
                        <h1 class="fw-bold fs-7 mb-2 text-white">Dapatkan Discount 70%</h1>
                        <button class="btn btn-dark btn-sm fs-9 rounded-pill">
                            <span class="p-2">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/diskon.png') }}" alt="Discount Icon"
                        class="ms-auto img-fluid rounded" style="height: 55px; width: 55px;">
                </div>
            </div>

            <!-- Slide Kedua -->
            <div class="flex-shrink-0 rounded merah p-3 klaim-btn me-2" style="width: 265px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-1 fs-8">Potongan Harga Besar Menanti!</p>
                        <h1 class="fw-bold fs-7 mb-2 text-white">Hanya Untuk Anda</h1>
                        <button class="btn btn-dark btn-sm fs-9 rounded-pill">
                            <span class="p-2">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/diskon2.png') }}" alt="Discount Icon"
                        class="ms-auto img-fluid rounded" style="height: 55px; width: 55px;">
                </div>
            </div>

            <!-- Slide Kedua -->
            <div class="flex-shrink-0 rounded tren p-3 klaim-btn me-2" style="width: 265px;">
                <div class="d-flex align-items-center">
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/barber1.jpeg') }}" alt="Discount Icon"
                        class="me-auto img-fluid rounded" style="height: 55px; width: 55px; object-fit: cover;">

                    <div class="text-end">
                        <p class="text-black-50 mb-1 fs-8">Ingin tampil Tampan seperti ini???</p>
                        <h1 class="fw-bold fs-7 mb-2 text-white">Potong Sekarang</h1>
                        <button class="btn btn-dark btn-sm fs-9 rounded-pill">
                            <span class="p-2">Pesan Sekarang</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Slide Kedua -->
            <div class="flex-shrink-0 rounded abu p-3 klaim-btn me-2" style="width: 265px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-1 fs-8">Ada Diskon Akhir Tahun nih</p>
                        <h1 class="fw-bold fs-7 mb-2 text-white">Lumayan lahh!!!</h1>
                        </h1>
                        <button class="btn btn-dark btn-sm fs-9 rounded-pill">
                            <span class="p-2">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/diskon2.png') }}" alt="Discount Icon"
                        class="ms-auto img-fluid rounded" style="height: 55px; width: 55px;">
                </div>
            </div>

            <!-- Slide Kedua -->
            <div class="flex-shrink-0 rounded merah p-3 klaim-btn" style="width: 265px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-1 fs-8">Khusus Styling rambut</p>
                        <h1 class="fw-bold fs-7 mb-2 text-white">Diskon 70%</h1>
                        <button class="btn btn-dark btn-sm fs-9 rounded-pill">
                            <span class="p-2">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/tren5.jpg') }}" alt="Discount Icon" class="ms-auto img-fluid rounded"
                        style="height: 55px; width: 55px; object-fit: cover;">
                </div>
            </div>
        </div>
    </section>

    <!-- Tren Section -->
    <section class="pb-2 pt-4 px-1 pe-2">
        <h1 class="text-white fs-6 px-1 mb-0">Tren Saat Ini</h1>
        <div style="overflow-x: auto; white-space: nowrap; padding-top: 16px;">
            @foreach ($trends as $index => $trend)
                <a href="/trendetail/{{ $trend->id }}">
                    <div class="tren rounded {{ $loop->first || $loop->last ? 'mx-1' : 'mx-1' }}"
                        style="display: inline-block; width: 250px;">
                        <div class="p-2">
                            <div
                                style="display: flex; justify-content: center; align-items: center; width: 230px; height: 150px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $trend->image) }}" alt="{{ $trend->title }}"
                                    class="rounded d-block" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="px-2" style="overflow: hidden;">
                                <h5 class="text-white mb-0 fs-7 pt-2">{{ $trend->title }}</h5>
                                <p class="text-white mb-0 fs-8"
                                    style="overflow: hidden; text-overflow: ellipsis; max-width: 230px;">
                                    {{ $trend->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </section>


    <script>
        // SweetAlert untuk tombol klaim
        document.querySelectorAll('.klaim-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.closest('div').id;
                const message = id === 'claim-1' ? 'Klaim Diskon 70% berhasil!' : 'Klaim khusus berhasil!';
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    background: '#1e1e2d',
                    color: '#ffffff',
                    iconColor: '#00c851',
                    confirmButtonColor: '#ffb22d',
                });
            });
        });
    </script>
</div>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var splide = new Splide('.splide', {
                type: 'loop',
                autoplay: true,
                interval: 3000,
                perPage: 1,
                pagination: true,
                arrows: false,
                snap: true,
            });

            splide.mount();
        });
    </script>
@endpush

@section('title', 'Booking')

<div class="pt-3 pb-4 px-2 mb-5">

    <!-- Banner Section -->
    <section class="splide px-2" style="border-radius: 15px">
        <div class="splide__track" style="border-radius: 15px">
            <ul class="splide__list" style="border-radius: 15px">
                <li class="splide__slide" style="border-radius: 15px">
                    <img src="https://static.republika.co.id/uploads/images/inpicture_slide/captain_221104100511-473.jpeg"
                        alt="Slide 01" class="splide__image" />
                </li>
                <li class="splide__slide">
                    <img src="https://img.okezone.com/content/2023/03/02/612/2773878/support-pejuang-kanker-captain-barbershop-gratiskan-customer-yang-mau-botak-di-campaign-captaincancercare-ahApvULolF.JPG"
                        alt="Slide 02" class="splide__image" />
                </li>
                <li class="splide__slide">
                    <img src="https://surabayaasik.com/wp-content/uploads/2023/03/Rekomendasi-Kursus-Barbershop-di-Surabaya.jpg"
                        alt="Slide 03" class="splide__image" />
                </li>
                <li class="splide__slide">
                    <img src="https://cdn.camberwellshopping.com.au/wp-content/uploads/2021/07/13111806/The-best-barbers-in-Camberwell.jpg"
                        alt="Slide 03" class="splide__image" />
                </li>
                <li class="splide__slide">
                    <img src="https://images.squarespace-cdn.com/content/v1/62f1307024cba25fc6025b32/31700a79-c001-45ff-9809-3081c8dcbf5b/AdobeStock_374326500.jpeg"
                        alt="Slide 03" class="splide__image" />
                </li>
            </ul>
        </div>
    </section>

    <section class="mt-4 px-2">
        <div class="d-flex overflow-auto">
            <!-- Slide Pertama -->
            <div class="flex-shrink-0 rounded kuning p-3 me-2 klaim-btn" style="width: 220px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-0 fs-11">Segera Potong!!!</p>
                        <h1 class="fw-bold fs-9 mb-0 text-white mb-1">Dapatkan Discount 70%</h1>
                        <button class="btn btn-dark btn-sm fs-11 rounded-pill">
                            <span class="p-1">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/diskon.png') }}" alt="Discount Icon" class="ms-auto img-fluid rounded"
                         style="height: 45px; width: 45px;">
                </div>
            </div>
    
            <!-- Slide Kedua -->
            <div class="flex-shrink-0 rounded merah p-3 klaim-btn me-2" style="width: 220px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-0 fs-11">Potongan Harga Besar Menanti!</p>
                        <h1 class="fw-bold fs-9 mb-0 text-white mb-1">Hanya Untuk Anda</h1>
                        <button class="btn btn-dark btn-sm fs-11 rounded-pill">
                            <span class="p-1">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/diskon2.png') }}" alt="Discount Icon" class="ms-auto img-fluid rounded"
                         style="height: 45px; width: 45px;">
                </div>
            </div>
    
            <!-- Slide Ketiga -->
            <div class="flex-shrink-0 rounded tren p-3 klaim-btn me-2" style="width: 220px;">
                <div class="d-flex align-items-center">
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/barber1.jpeg') }}" alt="Discount Icon"
                         class="me-auto img-fluid rounded" style="height: 45px; width: 45px; object-fit: cover;">
    
                    <div class="text-end">
                        <p class="text-black-50 mb-0 fs-11">Ayoo tampil Tampan seperti ini!</p>
                        <h1 class="fw-bold fs-9 mb-0 text-white mb-1">Potong Duluu lahh</h1>
                        <button class="btn btn-dark btn-sm fs-11 rounded-pill">
                            <span class="p-1">Pesan Sekarang</span>
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Slide Keempat -->
            <div class="flex-shrink-0 rounded abu p-3 klaim-btn me-2" style="width: 220px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-0 fs-11">Ada Diskon Akhir Tahun nih</p>
                        <h1 class="fw-bold fs-9 mb-0 text-white mb-1">Lumayan lahh!!!</h1>
                        <button class="btn btn-dark btn-sm fs-11 rounded-pill">
                            <span class="p-1">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/diskon2.png') }}" alt="Discount Icon"
                         class="ms-auto img-fluid rounded" style="height: 45px; width: 45px;">
                </div>
            </div>
    
            <!-- Slide Kelima -->
            <div class="flex-shrink-0 rounded merah p-3 klaim-btn" style="width: 220px;">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="text-black-50 mb-0 fs-11">Khusus Styling rambut</p>
                        <h1 class="fw-bold fs-9 mb-0 text-white mb-1">Diskon 70%</h1>
                        <button class="btn btn-dark btn-sm fs-11 rounded-pill">
                            <span class="p-1">Klaim Sekarang</span>
                        </button>
                    </div>
                    <!-- Gambar diposisikan di kanan -->
                    <img src="{{ asset('images/tren5.jpg') }}" alt="Discount Icon"
                         class="ms-auto img-fluid rounded" style="height: 45px; width: 45px; object-fit: cover;">
                </div>
            </div>
        </div>
    </section>
    

    <!-- Service Section -->
    <div class="d-flex align-items-center mt-4 mx-2">
        <h2 class="text-white fs-6 mb-0">Layanan BarberinAja</h2>
    </div>

    <div class="row g-3 ps-3 mb-4">
        <!-- Slide 1 -->
        <div class="row g-3 p-0">
            @foreach ($services as $service)
                <div class="col-6">
                    <div style="position: relative;">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                            class="rounded d-block"
                            style="height: 150px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 text-white bg-dark bg-opacity-50 w-100 p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 fs-9 text-truncate"
                                        style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $service->name }}
                                    </p>
                                    <p class="mb-0 fw-bolder emas fs-9">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('bookingdetail', ['serviceId' => $service->id]) }}">
                                    <button class="btn kuning text-white fs-9 btn-sm booking-btn">Pesan</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
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
    </style>
@endsection
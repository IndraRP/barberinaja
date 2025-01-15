@section('title', 'Booking')


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

<div class="pt-3 pb-4 px-2 mb-5">

     <!-- Banner Section -->
     <section class="splide mt-1 pb-1 mx-1" style="border-radius: 15px">
        <div class="splide__track" style="border-radius: 15px">
            <ul class="splide__list" style="border-radius: 15px">
                @foreach ($banners as $banner)
                    <li class="splide__slide px-1" style="border-radius: 15px">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image" class="splide__image" />
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    
    <section class="mt-4 px-2">
        <div class="d-flex overflow-auto">
            @foreach ($discounts as $discount)
                @php
                    $usedDiscount = App\Models\UserDiscount::where('user_id', auth()->id())
                        ->where('discount_id', $discount->id)
                        ->exists();
                @endphp

                @if (!$usedDiscount)
                    <!-- Slide Pertama -->
                    <div class="flex-shrink-0 rounded kuning p-3 me-2" style="width: 230px;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="text-black-50 mb-1 fs-11 fw-bolder">{{ $discount->description }}</p>
                                <h1 class="fw-bold fs-9 mb-1 text-white">{{ $discount->name }}</h1>
                                <!-- Tombol Pilih Diskon -->
                                <a
                                    href="{{ $discount->service ? '/bookingdetail/' . $discount->service->id : '/booking' }}">
                                    <button wire:click="selectDiscount({{ $discount->id }})"
                                        class="btn btn-dark btn-sm fs-9 rounded-pill">
                                        <span class="p-2">Pakai Sekarang</span>
                                    </button>
                                </a>
                            </div>
                            <!-- Gambar diposisikan di kanan -->
                            <img src="{{ asset('storage/' . $discount->image) }}" alt="{{ $discount->name }}"
                                class="ms-auto img-fluid rounded" style="height: 45px; width: 45px;">
                        </div>
                    </div>
                @endif
            @endforeach
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

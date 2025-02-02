@section("title", "Booking")

@section("styles")
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

<div class="mb-5 px-2 pb-4 pt-3">

    <!-- Gender Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" wire:ignore.self aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="filterModalLabel">Filter Berdasarkan Gender</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="genderFilter" class="form-label">Pilih Gender</label>
                        <select id="genderFilter" class="form-select bg-dark text-white" wire:model="genderFilter">
                            @foreach ($genderOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" wire:click="applyGenderFilter" data-bs-dismiss="modal">Terapkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Section -->
    <div class="mx-1 mt-1 pb-1" wire:ignore>
        <section class="splide" style="border-radius: 15px">
            <div class="splide__track" style="border-radius: 15px">
                <ul class="splide__list" style="border-radius: 15px">
                    @forelse ($banners as $banner)
                        <li class="splide__slide px-1" style="border-radius: 15px">
                            <img src="{{ asset("storage/" . $banner->image) }}" alt="Banner Image" class="splide__image" />
                        </li>
                    @empty
                        <li class="splide__slide px-1" style="border-radius: 15px">
                            <p class="text-center text-white">No banners available</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </section>
    </div>

    <!-- Discount Section -->
    <section class="px-2">
        <div class="d-flex overflow-auto">
            @forelse ($discounts as $discount)
                @php
                    $usedDiscount = App\Models\UserDiscount::where("user_id", auth()->id())
                        ->where("discount_id", $discount->id)
                        ->exists();
                @endphp

                @if (!$usedDiscount)
                    <div class="kuning me-2 mt-4 flex-shrink-0 rounded p-3" style="width: 230px;" wire:key="discount-{{ $discount->id }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="text-black-50 fs-11 fw-bolder mb-1">{{ $discount->description }}</p>
                                <h1 class="fw-bold fs-9 mb-1 text-white">{{ $discount->name }}</h1>
                                <button id="openModalButton{{ $discount->id }}" class="btn btn-dark btn-sm fs-9 rounded-pill">
                                    <span class="p-2">Pakai Sekarang</span>
                                </button>
                            </div>
                            <img src="{{ asset("storage/" . $discount->image) }}" alt="{{ $discount->name }}" class="img-fluid ms-auto rounded" style="height: 45px; width: 45px;">
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        </div>
    </section>


    <!-- Service Section -->
    <div class="d-flex align-items-center mx-2 mt-4">
        <h2 class="fs-6 mb-0 text-white">Layanan BarberinAja</h2>
        <i class="bi bi-funnel-fill fs-6 me-3 ms-auto text-white" data-bs-toggle="modal" data-bs-target="#filterModal"></i>
    </div>

    <!-- Service List Section -->
    <div class="row g-3 mb-4 ps-3">
        <div class="row g-3 p-0">
            @foreach ($services as $service)
                <div class="col-6" wire:key="service-{{ $service->id }}">
                    <div style="position: relative;">
                        <img src="{{ asset("storage/" . $service->image) }}" alt="{{ $service->name }}" class="d-block rounded" style="height: 150px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                        <div class="position-absolute bg-dark w-100 bottom-0 start-0 bg-opacity-50 p-2 text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="fs-9 text-truncate mb-0" style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $service->name }}
                                    </p>
                                    <p class="fw-bolder emas fs-9 mb-0">Rp {{ number_format($service->price, 0, ",", ".") }}</p>
                                </div>
                                <a href="{{ route("bookingdetail", ["serviceId" => $service->id]) }}">
                                    <button class="btn kuning fs-9 btn-sm booking-btn text-white">Pesan</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- MODALS DISKON --}}
    @foreach ($discounts as $discount)
        <div class="modal fade" id="myModal{{ $discount->id }}" tabindex="-1" aria-labelledby="diskonModalLabel{{ $discount->id }}" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered mx-3">
                <div class="modal-content bg-dark text-white" wire:ignore>
                    <div class="modal-header mt-3 border-0 p-0">
                        <div class="d-flex justify-content-center w-100">
                            <img src="https://cdn-icons-png.freepik.com/256/17110/17110281.png?ga=GA1.1.894313801.1732955252&semt=ais_hybrid" alt="Discount Icon" style="height: 150px; width:150px">
                        </div>
                    </div>
                    <div class="modal-body px-3 py-0">
                        <p class="fs-7 mb-0 mt-2 text-center">Diskon ini berlaku khusus Layanan <span class="fw-bolder">{{ $discount->service->name }}</span></p>
                        <p class="text-center">Apakah Anda yakin ingin menggunakan diskon ini?</p>
                    </div>
                    <div class="modal-footer px-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a href="{{ $discount->service ? "/bookingdetail/" . $discount->service->id : "/booking" }}">
                            <button type="button" class="btn btn-warning" wire:click="selectDiscount({{ $discount->id }})">Ya, Gunakan</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push("scripts")
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($discounts as $discount)
                const openModalButton{{ $discount->id }} = document.getElementById('openModalButton{{ $discount->id }}');
                const modalElement{{ $discount->id }} = document.getElementById('myModal{{ $discount->id }}');

                const modalInstance{{ $discount->id }} = new bootstrap.Modal(modalElement{{ $discount->id }});

                openModalButton{{ $discount->id }}.addEventListener('click', function() {
                    modalInstance{{ $discount->id }}.show();
                });
            @endforeach
        });
    </script>
@endpush

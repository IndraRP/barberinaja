@section('title', 'Booking Barber')

<div class="pb-4 px-2 mb-5">

    <!-- Header dengan Tombol Kembali -->
    <div class="fixed-top w-100 top-0 start-0 atas transition-all">
        <div class="d-flex justify-content-between align-items-center p-1">
            <!-- Tombol Kembali -->
            <div class="d-flex align-items-center">
                <a href="/home_barber" class="text-white bg-transparent rounded-circle p-2 my-1" style="opacity: 1;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </a>
                
                <!-- Text Detail Layanan, hilangkan d-none jika ingin ditampilkan -->
                <p class="text-white fs-6 mt-3 fw-bolder ms-2">Layanan Barberinaja</p>
            </div>
        </div>
    </div>


    <div class="row g-3 pt-5 mt-1 ps-3 mb-4">
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
                                    <p class="mb-0 fw-bolder emas fs-9">Rp
                                        {{ number_format($service->price, 0, ',', '.') }}</p>
                                </div>
                    
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

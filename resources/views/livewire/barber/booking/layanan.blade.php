@section("title", "Booking Barber")

<div class="mb-5 px-2 pb-4">

    <!-- Header dengan Tombol Kembali -->
    <div class="fixed-top w-100 atas start-0 top-0 transition-all">
        <p class="fs-6 fw-bolder ms-2 mt-3 text-center text-white">Layanan <span class="emas">Barberinaja</span></p>
    </div>


    <div class="row g-3 mb-4 mt-1 ps-3 pt-5">
        <!-- Slide 1 -->
        <div class="row g-3 p-0">
            @foreach ($services as $service)
                <div class="col-6">
                    <div style="position: relative;">
                        <img src="{{ asset("storage/" . $service->image) }}" alt="{{ $service->name }}" class="d-block rounded" style="height: 150px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                        <div class="position-absolute bg-dark w-100 bottom-0 start-0 bg-opacity-50 p-2 text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="fs-9 text-truncate mb-0" style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $service->name }}
                                    </p>
                                    <p class="fw-bolder emas fs-9 mb-0">Rp
                                        {{ number_format($service->price, 0, ",", ".") }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

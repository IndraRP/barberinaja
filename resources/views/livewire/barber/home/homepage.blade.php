<div class="pb-4">
    <!-- Header -->
    <div id="header"
        class="navbar navbar-dark bg-dark fixed-top d-flex justify-content-between align-items-center p-3">
        <div class="d-flex flex-column">
            <span class="text-white fs-8">Selamat pagi</span>
            <h1 class="h6 text-white m-0 fs-7">Barberman {{ $name }}</h1>
        </div>
        <div class="d-flex align-items-center">
            <!-- Search Icon -->
            <button id="search-icon" class="btn btn-dark border border-light rounded-pill" type="button"
                style="height: 40px; width: 40px; transition: background-color 0.3s;">
                <i class="bi bi-search text-white"></i>
            </button>
            <!-- Foto Profil -->
            <img src="{{ asset('storage/' . ($image ?? 'images/profiles/barber1.png')) }}" class="rounded-circle border border-white ms-3 object-fit-cover"
                style="height: 40px; width: 40px;" alt="Profile">
        </div>
    </div>

    <!-- Search Bar -->
    <div id="search-container" class="mt-1 mx-1">
        <div class="position-relative w-100 pb-2">
            <input id="main-search" type="text" class="form-control bg-white border rounded-pill w-100 ps-3 pe-5"
                placeholder="Cari Disini">
            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y pb-1 pe-3 text-gray"></i>
        </div>
    </div>

    <div class="px-2">
        <!-- Layanan Section -->
        <section class="mt-4 px-2">
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
    </div>

    <div class="px-3 mt-3">
        @if ($pendingSchedules->isEmpty())

            <div class="pb-4">
                <p class="fs-6 emas m-0">Anda Belum memiliki jadwal</p>
                <div id="lottie"></div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
                <script>
                    var animation = lottie.loadAnimation({
                        container: document.getElementById('lottie'),
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '{{ asset('images/Animation2.json') }}'
                    });
                </script>
            </div>
        @else
            <div class="d-flex align-items-center">
                <h3 class="emas fs-6 fs-bolder m-0">Jadwal Anda :</h3>
                <button type="button" class="btn btn-outline-danger ms-auto fs-11">Belum Dikerjakan</button>
            </div>
            <ul class="list-group fs-8 pt-1">
                @foreach ($pendingSchedules as $schedule)
                    <div wire:click="selectSchedule({{ $schedule->id }})" data-bs-toggle="modal"
                        data-bs-target="#scheduleModal">
                        <li class="list-group-item abu border border-warning rounded my-1 px-2 text-white">
                            <div class="d-flex">
                                <div class="d-block m-0 pt-1">
                                    <p class="m-0 fs-7 fw-bolder">
                                        @foreach ($schedule->transaction->details as $detail)
                                            {{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}
                                        @endforeach
                                    </p>
                                    <p class="m-0 pt-1 fs-7 fw-bolder">Customer : {{ $schedule->customer_name }}</p>
                                </div>

                                <div class="text-end ms-auto">
                                    <p class="m-0">
                                        <span>{{ $schedule->formatted_date }}</span> : <strong
                                            class="bi bi-calendar fs-6"></strong>
                                    </p>
                                    <p class="m-0">
                                        <span>{{ $schedule->formatted_time }}</span> : <strong
                                            class="bi bi-stopwatch fs-6"></strong>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
        @endif
    </div>


    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #1e1e2d; color: #ffffff;">
                @if ($selectedSchedule)
                    <div class="modal-header">
                        <h5 class="modal-title" id="scheduleModalLabel">Detail Jadwal</h5>
                    </div>
                    <div class="modal-body">
                        <p><strong>Customer : </strong> {{ $selectedSchedule->customer_name }}</p>
                        <p><strong>Tangga : </strong> {{ $selectedSchedule->formatted_date }}</p>
                        <p><strong>Waktu : </strong> {{ $selectedSchedule->formatted_time }}</p>
                        <p><strong>Layanan : </strong></p>
                        <ul>
                            @foreach ($selectedSchedule->transaction->details as $detail)
                                <li>{{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn kuning text-white fs-6 fw-bold py-2 px-3" wire:click="markAsDone()">Selesai
                            Mengerjakan</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const header = document.getElementById("header");
            const searchIcon = document.getElementById("search-icon");
            const searchContainer = document.getElementById("search-container");
            const mainSearch = document.getElementById("main-search");

            // Restore initial state when scrolling to the top
            function restoreInitialState() {
                header.classList.remove("d-none");
                searchContainer.classList.add("px-3", "mt-1");
                searchContainer.classList.remove("fixed-top", "bg-dark", "pt-4", "pb-3", "d-none");
            }

            // Handle scroll event
            window.addEventListener("scroll", () => {
                if (window.scrollY > 50) {
                    searchContainer.classList.add("d-none");
                    searchContainer.classList.remove("px-3", "mt-1");
                } else {
                    restoreInitialState();
                }
            });

            // Handle search icon click
            searchIcon.addEventListener("click", () => {
                header.classList.add("d-none");
                searchContainer.classList.remove("d-none");
                searchContainer.classList.add("fixed-top", "bg-dark", "px-3", "pt-4", "pb-3");
                mainSearch.focus();
            });

            // Keyword search function
            mainSearch.addEventListener("keypress", (e) => {
                if (e.key === "Enter") {
                    const keyword = mainSearch.value.toLowerCase();
                    const bodyText = document.body.innerText.toLowerCase();
                    if (keyword && bodyText.includes(keyword)) {
                        const range = document.createRange();
                        const selection = window.getSelection();
                        const elements = Array.from(document.body.querySelectorAll("*"));

                        for (const el of elements) {
                            if (el.innerText.toLowerCase().includes(keyword)) {
                                range.selectNodeContents(el);
                                selection.removeAllRanges();
                                selection.addRange(range);
                                el.scrollIntoView({
                                    behavior: "smooth",
                                    block: "center"
                                });
                                break;
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush

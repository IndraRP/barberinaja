@section("styles")
    <style>
        .btn-duration,
        .btn-time {
            background-color: #5E50B2;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-duration:hover,
        .btn-time:hover {
            background-color: #dad356;
        }

        .btn-duration:focus,
        .btn-time:focus {
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
            border-color: #a48118;
        }

        .btn-time.taken-time {
            background-color: #392e2d7f;
            color: white;
            border-color: #5c5c5c7f;
        }

        .btn-time.taken-time:hover {
            background-color: #392e2d7f;
            border-color: #4542427f;
        }

        .btn-time.disabled {
            pointer-events: none;
        }

        .loading {
            opacity: 0.5;
        }

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

<div class="home mb-5 pb-4" id="content">

    <!-- Header -->
    <div x-data="{ isVisible: true }">
        <div class="navbar navbar-dark fixed-top d-flex justify-content-between align-items-center px-3" style="padding-top: 12px; padding-bottom: 12px; background-color: #333;">
            <div class="d-flex flex-column">
                <span class="fs-8 text-white">Selamat pagi, </span>
                <h1 class="h6 fs-7 m-0 text-white">{{ $name }}</h1>
            </div>
            <div class="d-flex align-items-center">
                <!-- Foto Profil -->
                @if (!empty($image))
                    <img src="{{ asset("storage/" . $image) }}" class="rounded-circle object-fit-cover ms-3 border border-white" style="height: 40px; width: 40px;" alt="Profile" data-bs-toggle="modal" data-bs-target="#profileModal">
                @endif
            </div>
        </div>
    </div>

    <!-- Modal untuk Foto Besar -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-body p-3">
                    <!-- Gambar Besar di dalam Modal -->
                    <img src="{{ asset("storage/" . ($image ?? "images/profiles/default1.jpg")) }}" class="img-fluid d-block mx-auto rounded" alt="Profile">
                </div>
            </div>
        </div>
    </div>


    <!-- Banner Section -->
    <section class="splide mx-1 mt-2 pb-1" style="border-radius: 15px">
        <div class="splide__track" style="border-radius: 15px">
            <ul class="splide__list" style="border-radius: 15px">
                @foreach ($banners as $banner)
                    <li class="splide__slide px-1" style="border-radius: 15px">
                        <img src="{{ asset("storage/" . $banner->image) }}" alt="Banner Image" class="splide__image" />
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- Attention Section -->
    @if (Auth::check() && ($pendingTransactions->isNotEmpty() || $waitingConfirmationTransactions->isNotEmpty() || $approvedTransactions->isNotEmpty()))
        <section class="mt-3 px-2">
            <div class="atas rounded p-2" style="white-space: nowrap; position: relative; overflow-x: auto; width: 100%; max-width: 100%;">
                <p class="fs-6 fw-bolder mb-0 text-white">Transaksi Anda</p>

                <div style="display: flex; min-width: 100%; overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none;">
                    <!-- Transaksi Pending -->
                    @foreach ($pendingTransactions as $transaction)
                        <a href="{{ url("/konfirmasi/" . $transaction->id) }}">
                            <li class="list-group-item abu border-warning my-1 me-2 rounded border px-2 text-white" style="flex: 0 0 auto; width: 260px; min-width: 260px;">
                                <div class="d-flex align-items-center py-1">
                                    <p class="fs-10 fw-bolder mb-0 mt-1 text-white">Jadwal Anda</p>
                                    <div class="fs-11 border-danger text-danger ms-auto rounded border bg-transparent px-2 py-1">
                                        Belum bayar
                                    </div>
                                </div>
                                <div class="d-flex fs-8 pb-2">
                                    <div class="d-block m-0">
                                        <p class="fs-7 m-0 mt-1">
                                            @foreach ($transaction->details as $detail)
                                                {{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}
                                            @endforeach
                                        </p>
                                        <p class="fs-7 emas fw-bolder m-0">
                                            <span>Total Harga</span>
                                            @foreach ($transaction->details as $detail)
                                                Rp {{ number_format($detail->total_harga) }}
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="m-0">
                                            <span class="me-1">{{ $transaction->formatted_date }}</span>
                                            <strong class="bi bi-calendar-week fs-6"></strong>
                                        </p>
                                        <p class="m-0">
                                            <span class="me-1">{{ $transaction->formatted_time }}</span>
                                            <strong class="bi bi-stopwatch" style="font-size: 18px;"></strong>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach

                    <!-- Transaksi Waiting Confirmation -->
                    @foreach ($waitingConfirmationTransactions as $transaction)
                        <a href="{{ url("/detail_riwayat/" . $transaction->id) }}">
                            <li class="list-group-item abu border-warning my-1 me-2 rounded border px-2 text-white" style="flex: 0 0 auto; width: 260px; min-width: 260px;">
                                <div class="d-flex align-items-center py-1">
                                    <p class="fs-10 fw-bolder mb-0 mt-1 text-white">Jadwal Anda</p>
                                    <div class="fs-11 border-warning text-warning ms-auto rounded border bg-transparent px-2 py-1">
                                        Menunggu Konfirmasi
                                    </div>
                                </div>
                                <div class="d-flex fs-8 pb-2">
                                    <div class="d-block m-0">
                                        <p class="fs-7 m-0 mt-1">
                                            @foreach ($transaction->details as $detail)
                                                {{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}
                                            @endforeach
                                        </p>

                                        <p class="fs-7 m-0">
                                            <strong class="bi bi-person-check" style="font-size: 18px;"></strong>
                                            @foreach ($transaction->details as $detail)
                                                <span class="ms-1">{{ $transaction->barber->name ?? "" }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="m-0">
                                            <span class="me-1">{{ $transaction->formatted_date }}</span>
                                            <strong class="bi bi-calendar-week fs-6"></strong>
                                        </p>
                                        <p class="m-0">
                                            <span class="me-1">{{ $transaction->formatted_time }}</span>
                                            <strong class="bi bi-stopwatch" style="font-size: 18px;"></strong>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach

                    <!-- Transaksi Approved -->
                    @foreach ($approvedTransactions as $transaction)
                        <a href="{{ url("/detail_riwayat/" . $transaction->id) }}">
                            <li class="list-group-item abu border-warning my-1 me-2 rounded border px-2 text-white" style="flex: 0 0 auto; width: 260px; min-width: 260px;">
                                <div class="d-flex align-items-center py-1">
                                    <p class="fs-10 fw-bolder mb-0 mt-1 text-white">Jadwal Anda</p>
                                    <div class="fs-11 border-success text-success ms-auto rounded border bg-transparent px-2 py-1">
                                        Menunggu Hari
                                    </div>
                                </div>
                                <div class="d-flex fs-8 pb-2">
                                    <div class="d-block m-0">
                                        <p class="fs-7 m-0 mt-1">
                                            @foreach ($transaction->details as $detail)
                                                {{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}
                                            @endforeach
                                        </p>
                                        <p class="fs-7 m-0">
                                            <strong class="bi bi-person-check" style="font-size: 18px;"></strong>
                                            @foreach ($transaction->details as $detail)
                                                <span class="ms-1">{{ $transaction->barber->name ?? "" }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="m-0">
                                            <span class="me-1">{{ $transaction->formatted_date }}</span>
                                            <strong class="bi bi-calendar-week fs-6"></strong>
                                        </p>
                                        <p class="m-0">
                                            <span class="me-1">{{ $transaction->formatted_time }}</span>
                                            <strong class="bi bi-stopwatch" style="font-size: 18px;"></strong>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </div>
            </div>

            <style>
                div::-webkit-scrollbar {
                    display: none;
                }
            </style>
        </section>
    @endif


    <!-- Layanan Section -->
    <section class="px-2 pt-3">
        <div class="d-flex align-items-center">
            <h2 class="fs-6 mb-0 text-white">Layanan</h2>
            <a href="/booking" class="text-info fs-7 text-decoration-none m-0 ms-auto">Lihat Semua</a>
        </div>

        <div class="pb-0 pt-3" style="white-space: nowrap; position: relative; overflow-x: auto">
            <div style="display: inline-flex; min-width: 100%; width: fit-content;">
                @foreach ($services as $service)
                    <div style="flex-shrink: 0; width: 120px;  {{ $loop->last ? "" : "margin-right: 10px;" }} position: relative;">
                        <a href="/bookingdetail/{{ $service->id }}" style="display: block;">
                            <img src="{{ asset("storage/" . $service->image) }}" alt="{{ $service->name }}" class="d-block rounded" style="height: 140px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                            <div class="position-absolute bg-dark fs-9 w-100 bottom-0 start-0 bg-opacity-50 p-1 text-center text-white">
                                <p class="mb-0">{{ $service->name }}</p>
                                <p class="emas mb-0">Rp {{ number_format($service->price) }}</p>
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
            <h2 class="fs-6 mb-0 text-white">Barber Kami</h2>
        </div>
        <div class="d-flex justify-content-center mt-3 gap-2">
            @foreach ($barbers as $barber)
                <a href="/barberdetail/{{ $barber->id }}">
                    <div class="text-center">
                        <img src="{{ asset("storage/" . $barber->image) }}" class="rounded-circle" style="height: 61px; width: 61px; cursor: pointer; object-fit: cover;" alt="{{ $barber->name }}">
                        <p class="fs-8 mt-1 text-white">{{ $barber->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mt-3 px-2">
        <div class="d-flex overflow-auto">
            @foreach ($discounts as $discount)
                @php
                    $usedDiscount = App\Models\UserDiscount::where("user_id", auth()->id())
                        ->where("discount_id", $discount->id)
                        ->exists();
                @endphp

                @if (!$usedDiscount)
                    <!-- Slide Pertama -->
                    <div class="kuning me-2 flex-shrink-0 rounded p-3" style="width: 265px;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="text-black-50 fs-8 fw-bolder mb-1">{{ $discount->description }}</p>
                                <h1 class="fw-bold fs-7 mb-2 text-white">{{ $discount->name }}</h1>
                                <!-- Tombol Pilih Diskon -->
                                <a href="{{ $discount->service ? "/bookingdetail/" . $discount->service->id : "/booking" }}">
                                    <button wire:click="selectDiscount({{ $discount->id }})" class="btn btn-dark btn-sm fs-9 rounded-pill">
                                        <span class="p-2">Pakai Sekarang</span>
                                    </button>
                                </a>
                            </div>
                            <!-- Gambar diposisikan di kanan -->
                            <img src="{{ asset("storage/" . $discount->image) }}" alt="{{ $discount->name }}" class="img-fluid ms-auto rounded" style="height: 55px; width: 55px;">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Tren Section -->
    <section class="px-1 pb-2 pe-2 pt-4">
        <h1 class="fs-6 mb-0 px-1 text-white">Tren Saat Ini</h1>
        <div style="overflow-x: auto; white-space: nowrap; padding-top: 16px;">
            @foreach ($trends as $index => $trend)
                <a href="/trendetail/{{ $trend->id }}">
                    <div class="tren {{ $loop->first || $loop->last ? "mx-1" : "mx-1" }} rounded" style="display: inline-block; width: 250px;">
                        <div class="p-2">
                            <div style="display: flex; justify-content: center; align-items: center; width: 230px; height: 150px; overflow: hidden;">
                                <img src="{{ asset("storage/" . $trend->image) }}" alt="{{ $trend->title }}" class="d-block rounded" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="px-2" style="overflow: hidden;">
                                <h5 class="fs-7 mb-0 pt-2 text-white">{{ $trend->title }}</h5>
                                <p class="fs-8 mb-0 text-white" style="overflow: hidden; text-overflow: ellipsis; max-width: 230px;">
                                    {{ $trend->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- MODALS --}}
    <div>
        <div x-data="{
            showModal: @entangle("showModaltime"),
            showCancelModal: false,
            showNotArrivedModal: false,
            showRecheduleModal: false
        }" @open-modal.window="showModal = true; startTimer()">

            <div x-show="showModal" x-cloak>
                <div class="modal fade show d-block" id="arrivalModal" tabindex="-1" aria-labelledby="arrivalModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark">
                            <div class="modal-header">
                                <h5 class="modal-title emas" id="arrivalModalLabel">Pemberitahuan!!!</h5>
                                {{-- <button type="button" class="btn-close" aria-label="Close" @click="showModal = false; Livewire.emit('close-modal')"></button> --}}
                            </div>
                            <div class="modal-body border-0">
                                <p class="fs-7 text-white">Saat ini waktunya anda dilayani oleh Barber Kami.</p>
                                <p class="fs-6 text-center text-white">Apakah anda sudah sampai di Barberinaja??</p>
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <button @click="showCancelModal = true" class="btn btn-outline-danger">Cancel Transaksi</button>
                                        <button @click="showNotArrivedModal = true" class="btn btn-warning">Belum</button>
                                        <button wire:click="markAsArrived()" class="btn btn-success">Sudah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            </div>

            <!-- Modal Not Arrived -->
            <div x-show="showNotArrivedModal" x-cloak>
                <div class="modal fade show d-block" id="NotArrivedModal" tabindex="-1" aria-labelledby="NotArrivedModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark">
                            <div class="modal-header">
                                <h5 class="modal-title emas" id="NotArrivedModal">Perhatian!!!</h5>
                            </div>
                            <div class="modal-body">
                                <p class="fs-10 text-white">Anda bisa memilih untuk cancel transaksi atau mengatur ulang jadwal berdasarkan jadwal yang kosong/sisa hari ini!!!</p>
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <button @click="showCancelModal = true" class="btn btn-outline-danger">Cancel Transaksi</button>
                                        <button @click="showRecheduleModal = true" @click="showNotArrivedModal = false" class="btn btn-secondary ms-1">Atur Ulang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            </div>


            <!-- Modal Cancel -->
            <div x-show="showCancelModal" x-cloak>
                <div class="modal fade show d-block" id="cancelModal" tabindex="-1" aria-labelledby="cancelModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark">
                            <div class="modal-header">
                                <h5 class="modal-title emas" id="cancelModal">Apakah anda yakin ingin mencancel ini?</h5>
                            </div>
                            <div class="modal-body">
                                <p class="fs-6 text-white">Jika anda mencancel transaksi ini maka kami tidak bisa mengembalikan uang anda!!!</p>
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <button wire:click="cancelTransaction()" class="btn btn-outline-danger me-1">Cancel Transaksi</button>
                                        <button @click="showCancelModal = false" class="btn btn-secondary">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            </div>

            <!-- Modal Reschedule -->
            <div x-show="showRecheduleModal" x-cloak>
                <div class="modal fade show d-block" id="showRecheduleModal" tabindex="-1" aria-labelledby="showRecheduleModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark">
                            <div class="modal-header">
                                <h5 class="modal-title emas" id="showRecheduleModal">Perhatian!!!</h5>
                            </div>
                            <div class="modal-body">
                                <p class="fs-6 text-white">Anda bisa mengatur ulang jadwal berdasarkan jadwal yang kosong/sisa hari ini!!!</p>
                                <p class="fs-10 text-white">
                                    <strong class="bi bi-calendar-week fs-6"></strong>
                                    <span class="ms-1">{{ $transaction ? $transaction->formatted_date : "Tanggal tidak tersedia" }}</span>
                                </p>

                                <div class="mx-1" wire:loading.class="loading">
                                    <label for="time" class="form-label emas">Atur Pertemuan</label>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        @foreach ($times as $time)
                                            @php
                                                $isTimeTaken = in_array($time, $takenTimes);
                                            @endphp
                                            <button type="button" class="btn btn-time fs-10 {{ $time == $this->time ? "active" : "" }} {{ $isTimeTaken ? "taken-time" : "" }} my-1" wire:click="setTime('{{ $time }}')" {{ $isTimeTaken ? "disabled" : "" }}>
                                                {{ $time }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error("time")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <!-- Tombol untuk update waktu -->
                                        <button @click="showRecheduleModal = false" class="btn btn-outline-secondary mt-2">Tutup</button>
                                        <button wire:click="notArrived('{{ $transaction ? $transaction->id : "" }}', '{{ $this->time }}')" class="btn btn-success mt-2">Atur Ulang Jadwal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            </div>

        </div>



        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('close-modal', () => {
                    console.log("Closing modal...");
                    const modal = document.querySelector('#arrivalModal');
                    if (modal) {
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                    }
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                    // Debugging log untuk memastikan perubahan pada showModal
                    console.log("Current showModal state before update: ", document.querySelector('[x-data]').__x.$data.showModal);

                    // Update state Alpine.js untuk menutup modal
                    document.querySelector('[x-data]').__x.$data.showModal = false;

                    // Debugging log setelah update showModal
                    console.log("Current showModal state after update: ", document.querySelector('[x-data]').__x.$data.showModal);
                });
            });
        </script>
    </div>

</div>



@push("scripts")
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
@endpush

@section("title", "Riwayat")

@section("styles")
    <style>
        .custom-nav-item {
            flex: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-nav-link {
            font-weight: bold;
            font-size: 10px;
            padding: 5px 8px;
            color: #ffffff;
            text-decoration: none;
        }

        .custom-nav-link.active {
            color: #f8b400;
            border-bottom: 2px solid #f8b400;
            background-color: #453e2900;
            border-top: #43434300;
            border-left: #43434300;
            border-right: #43434300;
        }

        .custom-nav-tabs {
            border-bottom: none;
        }

        .custom-nav-tabs {
            -ms-overflow-style: none;
            /* Untuk Internet Explorer dan Edge */
            scrollbar-width: none;
            /* Untuk Firefox */
        }

        .custom-nav-tabs::-webkit-scrollbar {
            display: none;
            /* Untuk Chrome, Safari, dan Edge */
        }
    </style>
@endsection

<div class="riwayat" wire:poll.60s="filterTransactions">
    <div class="d-flex atas align-items-center fixed-top pb-4" style="padding-top: 16px">
        <a href="/" class="position-absolute start-0 p-3 text-white" style="font-size: 24px; border-radius: 50%; background-color: transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>

        <h6 class="w-100 fw-bolder mb-0 mt-1 text-white" style="margin-left: 60px;">Pesanan Saya</h6>
        <i class="bi bi-funnel-fill fs-6 me-3 mt-2 text-white" data-bs-toggle="modal" data-bs-target="#filterModal"></i>
    </div>

    {{-- Navbar --}}
    <section class="bg-dark fixed-top pb-1 pt-2" style="margin-top: 70px;">
        <ul class="custom-nav-tabs justify-content-center d-flex mb-2 pe-3" role="tablist" style="white-space: nowrap; position: relative; overflow-x: auto; width: 100%; max-width: 100%; padding-left:190px;">
            @foreach ($statuses ?? [] as $key => $label)
                <li class="custom-nav-item" role="presentation">
                    <a class="custom-nav-link {{ $filter === $key ? "active" : "" }}" href="#{{ $key }}" role="tab" wire:click="setFilter('{{ $key }}')">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    <div class="" style="margin-top:120px; margin-bottom:100px;">
        @forelse ($transactions ?? [] as $transaction)
            <a href="{{ empty($transaction->bukti_image) && $transaction->status == "pending" ? "/konfirmasi/" . $transaction->id : "/detail_riwayat/" . $transaction->id }}">

                <div class="abu mx-3 mb-3 rounded border p-3" style="border-color: #ffffff9c !important;">
                    <div class="d-flex align-items-center">
                        <p class="fs-8 fw-bolder mb-1 me-auto text-white">{{ $transaction->appointment_date->format("d/m/Y") }}</p>
                        <div class="fw-bolder {{ $transaction->status === "completed" ? "btn-bright" : ($transaction->status === "canceled" ? "btn-bright-danger" : ($transaction->status === "approved" ? "btn-bright-primary" : ($transaction->status === "pending" && !empty($transaction->bukti_image) ? "btn-bright-info" : "btn-bright-warning text-white"))) }} fs-9 ms-auto py-1">
                            {{ $transaction->status === "pending" ? (!empty($transaction->bukti_image) ? "Menunggu Konfirmasi" : "Menunggu Pembayaran") : ($transaction->status === "approved" ? "Menunggu Hari" : ($transaction->status === "completed" ? "Selesai" : ($transaction->status === "canceled" ? "Dibatalkan" : ""))) }}
                        </div>
                        <style>
                            .btn-bright {
                                background-color: #69b86b;
                                color: #000000;
                                border: 2px solid #0a560d;
                                padding: 5px 10px;
                                border-radius: 10px;
                                text-align: center;
                                display: inline-block;
                            }

                            .btn-bright-danger {
                                background-color: #9a4e49;
                                color: #ffffff;
                                border: 2px solid #560a0a;
                                padding: 5px 10px;
                                border-radius: 10px;
                                text-align: center;
                                display: inline-block;
                            }

                            .btn-bright-primary {
                                background-color: #3f7098;
                                color: #ffffff;
                                border: 2px solid #0a0e56;
                                padding: 5px 10px;
                                border-radius: 10px;
                                text-align: center;
                                display: inline-block;
                            }

                            .btn-bright-info {
                                background-color: #438e98;
                                color: #ffffff;
                                border: 2px solid #0a2b56;
                                padding: 5px 10px;
                                border-radius: 10px;
                                text-align: center;
                                display: inline-block;
                            }

                            .btn-bright-warning {
                                background-color: #eaaf57;
                                border: 2px solid #56210a;
                                padding: 5px 10px;
                                border-radius: 10px;
                                text-align: center;
                                display: inline-block;
                            }
                        </style>

                    </div>

                    <hr class="style-two">
                    <style>
                        hr {
                            margin: 10px 0;
                            color: inherit;
                            border: 0;
                            border-top: var(--bs-border-width) solid;
                            opacity: .25;
                        }

                        hr.style-two {
                            border: 0;
                            height: 1px;
                            background-image: linear-gradient(to right, rgba(154, 154, 154, 0), rgba(255, 255, 255, 0.75), rgba(159, 159, 159, 0));
                        }
                    </style>

                    <div class="d-flex">
                        <img src="{{ asset("storage/" . ($transaction->bukti_image ?? "images/profiles/default1.jpg")) }}" alt="Service Image" class="img-fluid mt-1 rounded border border-white" style="height: 70px; width: 70px; object-fit: cover;">

                        <div class="d- align-items-center my-1 px-3 pb-1">
                            <div class="">
                                @foreach ($transaction->details as $detail)
                                    <p class="fw-bolder fs-7 mb-0 text-white">
                                        {{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}
                                    </p>
                                @endforeach
                                <p class="fs-9 mb-0 text-white">Jam Pesan: {{ $transaction->time }}</p>
                                <p class="fs-9 mb-0 text-white">Barberman:
                                    {{ $transaction->barber->name ?? "Tidak Diketahui" }}</p>
                                <p class="fw-bolder fs-7 emas mb-0">Rp
                                    {{ number_format($transaction->details->sum("total_harga"), 0, ",", ".") }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div x-data="lottieAnimation()" class="abu m-3 rounded p-3 text-center">
                <div x-ref="lottie" class="lottie-animation" wire:ignore></div>
                <p class="text-danger mt-3">Belum ada transaksi untuk status ini</p>
            </div>
        @endforelse

    </div>

    <div wire:ignore.self class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="margin-top: 80px;">
            <div class="modal-content bg-dark text-white">
                <!-- Header Modal -->
                <div class="modal-header">
                    <h5 class="modal-title emas" id="filterModalLabel">Filter</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body">
                    <form>
                        <!-- Pilihan Filter -->
                        <div class="mb-3">
                            <label for="filterType" class="form-label emas">Pilih Jenis Filter</label>
                            <select id="filterType" class="form-control bg-dark border-warning text-white" wire:model="filterType" wire:change="filterTransactions">
                                <option value="">Pilih Filter</option>
                                <option value="daily">Filter Harian</option>
                                <option value="monthly">Filter Bulanan</option>
                                <option value="yearly">Filter Tahunan</option>
                            </select>
                        </div>

                        <div>
                            @if ($filterType === "daily")
                                <div class="mb-3">
                                    <label for="day" class="form-label emas">Filter Harian</label>
                                    <input type="date" id="day" class="form-control bg-dark border-warning text-white" wire:model="day">
                                </div>
                            @endif

                            @if ($filterType === "monthly")
                                <div class="mb-3">
                                    <label for="month" class="form-label emas">Filter Bulanan</label>
                                    <select id="month" class="form-control bg-dark border-warning text-white" wire:model="month">
                                        <option value="">Pilih Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            @endif

                            @if ($filterType === "yearly")
                                <div class="mb-3">
                                    <label for="year" class="form-label emas">Filter Tahunan</label>
                                    <select id="year" class="form-control bg-dark border-warning text-white" wire:model="year">
                                        <option value="">Pilih Tahun</option>
                                        @for ($i = date("Y"); $i >= 2024; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                            @endif
                        </div>

                    </form>
                </div>

                <!-- Footer Modal -->
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-warning text-dark" wire:click="filterTransactions" data-bs-dismiss="modal">
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>

    <script>
        function lottieAnimation() {
            return {
                init() {
                    lottie.loadAnimation({
                        container: this.$refs.lottie,
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '{{ asset("images/Animation2.json") }}'
                    });
                }
            }
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Swipe handler
            const swipeContainer = document.querySelector('.riwayat');
            const hammer = new Hammer(swipeContainer);
            hammer.on('swipeleft', () => {
                @this.call('swipeFilter', 'next'); // Livewire method untuk filter berikutnya
            });

            hammer.on('swiperight', () => {
                @this.call('swipeFilter', 'previous'); // Livewire method untuk filter sebelumnya
            });
        });
    </script>
@endpush

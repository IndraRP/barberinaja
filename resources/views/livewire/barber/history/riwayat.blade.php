@section("title", "Riwayat Barber")

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
    </style>
@endsection

<div>
    <div class="d-flex justify-content-center atas align-items-center fixed-top py-4">
        <h6 class="w-100 fw-bolder mb-0 ms-3 pt-1 text-white">Riwayat Pekerjaan</h6>
        <i class="bi bi-funnel-fill fs-6 me-3 mt-2 text-white" data-bs-toggle="modal" data-bs-target="#filterModal"></i>
    </div>

    <div style="margin-top: 80px;" class="fixed-top bg-dark">
        <ul class="custom-nav-tabs justify-content-center d-flex mt-3 p-0" role="tablist">
            <li class="custom-nav-item" role="presentation">
                <a class="custom-nav-link {{ $filter === "pending" ? "active" : "" }}" wire:click="setFilter('pending')" role="tab">
                    Belum Dikerjakan
                </a>
            </li>
            <li class="custom-nav-item" role="presentation">
                <a class="custom-nav-link {{ $filter === "done" ? "active" : "" }}" wire:click="setFilter('done')" role="tab">
                    Sudah Dikerjakan
                </a>
            </li>
        </ul>
    </div>

    <div class="px-3 pb-3" style="margin-top: 135px;">
        @if (($filter === "done" && $doneSchedules->isEmpty()) || ($filter === "pending" && $pendingSchedules->isEmpty()))
            <!-- Menampilkan animasi jika salah satu filter kosong -->
            <div x-data="lottieAnimation()" class="d-flex justify-content-center align-items-center" style="margin-top: 250px;">
                <div x-ref="lottie" class="d-flex justify-content-center align-items-center mx-auto" style="width: 150px; height: 150px; transform: translateY(-10px);" wire:ignore>
                </div>
            </div>

            <p class="fs-6 emas d-block text-center" style="margin-top: -27px;">
                @if ($filter === "pending")
                    Belum ada pekerjaan <br><span>hari ini</span>
                @else
                    Anda belum mengerjakan sama sekali.
                @endif
            </p>
        @else
            <!-- Menampilkan jadwal berdasarkan filter -->
            <ul class="list-group fs-8 mb-5 pb-5 pt-1">
                @foreach ($filter === "done" ? $doneSchedules : $pendingSchedules as $schedule)
                    <div>
                        <li class="list-group-item abu border-warning my-1 rounded border px-2 text-white">
                            <div class="d-flex">
                                <div class="d-block m-0 pt-1">
                                    <p class="fs-7 fw-bolder m-0">
                                        @foreach ($schedule->transaction->details as $detail)
                                            {{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}
                                        @endforeach
                                    </p>
                                    <p class="fs-7 fw-bolder m-0 pt-1">Customer : {{ $schedule->customer_name }}</p>
                                </div>

                                <div class="ms-auto text-end">
                                    <p class="m-0">
                                        <span>{{ $schedule->formatted_date }}</span> : <strong class="bi bi-calendar fs-6"></strong>
                                    </p>
                                    <p class="m-0">
                                        <span>{{ $schedule->formatted_time }}</span> : <strong class="bi bi-stopwatch fs-6"></strong>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
        @endif
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
                            <select id="filterType" class="form-control bg-dark border-warning text-white" wire:model="filterType" wire:change="loadSchedules">
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
                    <button type="button" class="btn btn-warning text-dark" wire:click="loadSchedules" data-bs-dismiss="modal">
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>





@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

    <script>
        function lottieAnimation() {
            return {
                init() {
                    lottie.loadAnimation({
                        container: this.$refs.lottie,
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '{{ asset("images/Animation1.json") }}'
                    });
                }
            }
        }
    </script>
@endpush

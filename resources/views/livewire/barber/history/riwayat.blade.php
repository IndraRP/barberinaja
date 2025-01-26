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
    <div class="d-flex justify-content-center abu align-items-center position-relative fixed py-4">
        <!-- Icon Kembali -->
        <a href="/home_berber" class="position-absolute start-0 p-3 text-white" style="font-size: 24px; border-radius: 50%; background-color: transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>

        <h6 class="w-100 fw-bolder mb-0 pt-1 text-white" style="margin-left: 60px;">Jadwal Selesai</h6>
    </div>

    <div>
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

    <div class="px-3 pb-3">
        @if (($filter === "done" && $doneSchedules->isEmpty()) || ($filter === "pending" && $pendingSchedules->isEmpty()))
            <!-- Menampilkan animasi jika salah satu filter kosong -->
            <div class="d-flex justify-content-center align-items-center pb-5" style="margin-top: 100px;">
                <div class="text-center">
                    <div id="lottie" class="d-flex justify-content-center align-items-center mx-auto" wire.ignore style="width: 150px; height: 150px; transform: translateY(-10px);"></div>
                    <p class="fs-6 emas d-block" style="margin-top: -27px;">
                        @if ($filter === "pending")
                            Belum ada pekerjaan <br><span>hari ini</span>
                        @else
                            Anda belum mengerjakan sama sekali.
                        @endif
                    </p>
                </div>
            </div>
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
</div>





@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/Animation1.json") }}'
        });
    </script>
@endpush

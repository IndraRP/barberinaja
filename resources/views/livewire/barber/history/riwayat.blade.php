@section('title', 'Riwayat Barber')

@section('styles')
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
    <div class="d-flex justify-content-center abu fixed py-4 align-items-center position-relative">
        <!-- Icon Kembali -->
        <a href="/home_berber" class="position-absolute start-0 p-3 text-white"
            style="font-size: 24px; border-radius: 50%; background-color: transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>

        <!-- Judul Teks -->
        <h5 class="mb-0 text-white text-center w-100">Jadwal Selesai</h5>
    </div>

    <ul class="custom-nav-tabs justify-content-center d-flex p-0 mt-3" role="tablist">
        <li class="custom-nav-item" role="presentation">
            <a class="custom-nav-link {{ $filter === 'pending' ? 'active' : '' }}" wire:click="setFilter('pending')"
                role="tab">
                Belum Dikerjakan
            </a>
        </li>
        <li class="custom-nav-item" role="presentation">
            <a class="custom-nav-link {{ $filter === 'done' ? 'active' : '' }}" wire:click="setFilter('done')"
                role="tab">
                Sudah Dikerjakan
            </a>
        </li>
    </ul>

    <div class="px-3 pb-3">
        @if ($filter === 'done')
            <!-- Menampilkan jadwal dengan status 'done' -->
            @if ($doneSchedules->isEmpty())
                <div class="abu border border-warning rounded px-2 text-white">
                    <p class="text-center text-danger p-3 mb-0">Anda belum mengerjakan sama sekali.</p>
                </div>
            @else
                <ul class="list-group fs-8 pt-1 pb-5 mb-5">
                    @foreach ($doneSchedules as $schedule)
                        <div>
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
        @elseif ($filter === 'pending')
            <!-- Menampilkan jadwal dengan status 'pending' -->
            @if ($pendingSchedules->isEmpty())
                <div class="abu border border-warning rounded text-white">
                    <p class="text-center text-danger p-3 mb-0">Belum ada perkerjaan hari ini.</p>
                </div>
            @else
                <ul class="list-group fs-8 pt-1 pb-5 mb-5">
                    @foreach ($pendingSchedules as $schedule)
                        <div>
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
        @endif
    </div>

</div>

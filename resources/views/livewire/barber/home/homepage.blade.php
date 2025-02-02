@section("title", "Home Barber")

@section("styles")
    <style>
        body {
            overflow: hidden;
        }
    </style>
@endsection

<div>
    <!-- Header -->
    <div id="header" class="navbar navbar-dark abu rounded-bottom fixed-top d-flex justify-content-between align-items-center p-3">
        <div class="d-flex flex-column">
            <span class="fs-8 text-white">Selamat pagi</span>
            <h1 class="h6 fs-7 m-0 text-white">Barber {{ $name }}</h1>
        </div>
        <div class="d-flex align-items-center">
            <img src="{{ asset("storage/" . ($image ?? "images/profiles/barber1.png")) }}" class="rounded-circle object-fit-cover ms-3 border border-white" style="height: 40px; width: 40px;" alt="Profile" data-bs-toggle="modal" data-bs-target="#profileModal">
        </div>
    </div>

    <!-- Modal untuk Foto Besar -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-body bg-dark rounded" style="width: 330px; height: 330px; object-fit: cover;">
                <img src="{{ asset("storage/" . ($image ?? "images/profiles/barber1.png")) }}" class="img-fluid d-block mx-auto rounded" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; margin-top:0px;">
            </div>
        </div>
    </div>

    <div class="px-3">

        @if ($pendingSchedules->isEmpty())
            <div class="d-flex justify-content-center align-items-center vh-100 pb-5">
                <div class="text-center">
                    <div id="lottie" class="d-flex justify-content-center align-items-center mx-auto" style="width: 150px; height: 150px; transform: translateY(-10px);"></div>
                    <p class="fs-6 emas d-block" style="margin-top: -27px;">Belum ada pekerjaan
                        <br><span>hari ini</span>
                    </p>
                </div>
            </div>
        @else
            <style>
                body {
                    overflow: auto;
                }
            </style>


            <div class="d-flex align-items-center mt-5 pt-5">
                <h3 class="emas fs-6 fs-bolder m-0">Jadwal Anda :</h3>
                <button type="button" class="btn btn-outline-danger fs-11 ms-auto">Belum Dikerjakan</button>
            </div>
            <ul class="list-group fs-8 pt-1">
                @foreach ($pendingSchedules as $schedule)
                    <div wire:click="selectSchedule({{ $schedule->id }})" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                        <li class="list-group-item abu border-warning my-1 rounded border px-2 text-white">
                            <div class="d-flex">
                                <div class="d-block m-0 pt-1">
                                    <p class="fs-7 fw-bolder m-0">
                                        @foreach ($schedule->transaction->details as $detail)
                                            {{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}
                                        @endforeach
                                    </p>
                                    <div class="d-flex">
                                        <p class="fs-7 fw-bolder m-0" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            Customer: {{ $schedule->customer_name }}
                                        </p>
                                    </div>

                                </div>

                                <div class="ms-auto text-end">
                                    <p class="m-0">
                                        <span class="me-2">{{ $schedule->formatted_date }}</span><strong class="bi bi-calendar fs-6"></strong>
                                    </p>
                                    <p class="m-0">
                                        <span class="me-2">{{ $schedule->formatted_time }}</span><strong class="bi bi-stopwatch fs-6"></strong>
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
    <div wire:ignore.self class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                                <li>{{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn kuning fs-6 fw-bold px-3 py-2 text-white" wire:click="startNow()">Selesai
                            Mengerjakan</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- barber-arrival-modal -->
    <div>
        <div class="modal fade {{ $showModal ? "show d-block" : "" }}" tabindex="-1" id="arrivalModal" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark border-0">
                    <div class="modal-header emas border-0">
                        <h5 class="modal-title">Konfirmasi Pengerjaan</h5>
                    </div>
                    <div class="modal-body fs-10 px-3 py-0 text-white">
                        <!-- Cek jika $selectedSchedule tidak null sebelum mengakses properti -->
                        <p><strong>Customer: </strong> {{ $selectedSchedule ? $selectedSchedule->customer_name ?? "Nama Tidak Tersedia" : "Nama Tidak Tersedia" }}</p>
                        <p><strong>Tanggal: </strong> {{ $selectedSchedule ? $selectedSchedule->formatted_date : "Tanggal Tidak Tersedia" }}</p>
                        <p><strong>Waktu: </strong> {{ $selectedSchedule ? $selectedSchedule->formatted_time : "Waktu Tidak Tersedia" }}</p>
                        <p><strong>Layanan: </strong></p>
                        <ul>
                            @if ($selectedSchedule && $selectedSchedule->transaction && $selectedSchedule->transaction->details)
                                @foreach ($selectedSchedule->transaction->details as $detail)
                                    <li>{{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}</li>
                                @endforeach
                            @else
                                <li>Layanan Tidak Tersedia</li>
                            @endif
                        </ul>

                        <p class="fs-6 fw-bolder mt-2 text-center">Apakah Anda ingin mulai mengerjakan sekarang?</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center border-0">
                        <div>
                            <button type="button" class="btn btn-secondary fs-7 fw-bolder px-3 py-2 text-white" wire:click="startLater">Kerjakan Nanti</button>
                            <button type="button" class="btn kuning fs-7 fw-bolder px-3 py-2 text-white" wire:click="startNow">Kerjakan Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($showModal)
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            // Mendengarkan event 'close-modal' yang dikirim oleh Livewire
            Livewire.on('close-modal', () => {
                // Menutup modal dengan menggunakan Bootstrap modal
                $('#arrivalModal').modal('hide');
            });
        });
    </script>

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

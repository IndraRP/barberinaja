@section("title", "Detail Riwayat")

@section("styles")
    <style>
        .abu1 {
            background-color: #2c3034;
        }
    </style>
@endsection

<div class="detail_riwayat" style="margin-top: 60px;">
    <!-- Bagian header -->
    <div class="d-flex abu1 fixed-top align-items-center py-3">
        <a href="javascript:void(0)" onclick="handleBack()" class="position-absolute start-0 p-3 text-white" style="font-size: 24px; border-radius: 50%; background-color: transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>

        <script>
            function handleBack() {
                if (document.referrer) {
                    window.history.back();
                } else {
                    window.location.href = '/riwayat';
                }
            }
        </script>

        <p class="fs-6 fw-bolder w-100 mb-0 ms-5 mt-1 text-white">Informasi Pemesanan</p>
    </div>

    <!-- Alert jika ada -->
    @if (session()->has("success"))
        <div class="alert alert-success">
            {{ session("success") }}
        </div>
    @endif

    @if ($transaction->status == "canceled")
        <div class="abu fs-10 d-flex border-danger text-danger mx-3 mb-1 rounded border p-2" style="margin-top: 75px;">
            <p class="mb-0 me-auto">Dibatalkan Karena</p>

            <div class="ms-auto">
                @if ($transaction->canceled == "payment")
                    <p class="mb-0">Ditolak oleh admin</p>
                @elseif ($transaction->canceled == "timeout")
                    <p class="mb-0">Melewati Waktu Dilayani</p>
                @elseif ($transaction->canceled == "not_paid")
                    <p class="mb-0">Belum Dibayar</p>
                @else
                @endif
            </div>
        </div>
    @endif


    <!-- Detail Transaksi -->
    <section class="px-3 pb-3 pt-2">

        <div class="d-flex justify-content-center align-items-center @if ($transaction->status == "canceled") @else mb-2 p-1 @endif">
            <div class="fs-10 m-0 text-white">
                @if ($transaction->status == "pending")
                    <div class="fs-10 border-warning text-warning rounded border p-2">Menunggu Konfirmasi</div>
                @elseif ($transaction->status == "approved")
                    <div class="fs-10 border-primary text-primary rounded border p-2">Menunggu Hari</div>
                @elseif ($transaction->status == "completed" || $transaction->status == "arrived")
                    <div class="fs-10 border-success text-success rounded border p-2">Transaksi Selesai</div>
                @elseif ($transaction->status == "cancel")
                    <div class="fs-10 border-danger text-danger rounded border p-2">
                        @if ($transaction->canceled == "payment")
                            Ditolak oleh admin
                        @elseif ($transaction->canceled == "timeout")
                            Melewati Waktu Dilayani
                        @elseif ($transaction->canceled == "not_paid")
                            Belum Dibayar
                        @endif
                    </div>
                @else
                @endif
            </div>
        </div>


        <div class="abu mb-3 rounded border px-3 pb-4">
            <h5 class="fs-7 fs-6 fw-bolder mb-0 mt-4 text-white">Data Pemesan</h5>
            <hr class="text-secondary px-2">
            <div class="text-start">
                <div class="d-flex justify-content-between align-items-center p-1">
                    <p class="fs-10 m-0 text-white">Nama Lengkap</p>
                    <p class="fs-10 m-0 text-white">{{ $transaction->name_customer }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center p-1">
                    <p class="fs-10 m-0 text-white">No. Handphone</p>
                    <p class="fs-10 m-0 text-white">{{ $transaction->phone_number }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center p-1">
                    <p class="fs-10 m-0 text-white">Pesan untuk Tgl.</p>
                    <p class="fs-10 m-0 text-white">
                        {{ \Carbon\Carbon::parse($transaction->appointment_date)->format("d/m/Y") }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center p-1">
                    <p class="fs-10 m-0 text-white">Jam Dipilih</p>
                    <p class="fs-10 m-0 text-white"> {{ \Carbon\Carbon::parse($transaction->time)->format("H:i") }} WIB</p>
                </div>
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="abu rounded border px-3 pb-4" style="border-color: #4343433a !important;">
            <h5 class="fs-7 fs-6 fw-bolder mb-0 mt-4 text-white">Detail Layanan</h5>
            <hr class="text-secondary px-2">
            @foreach ($transaction->details as $detail)
                <div class="d-flex justify-content-between align-items-center p-1">
                    <img src="{{ asset("storage/" . ($detail->service->image ?? "default.jpg")) }}" alt="Foto Layanan" class="img-fluid rounded" style="height: 70px; width: 70px; object-fit: cover; border-radius: 50%;" />
                    <div class="d-block text-end">
                        <p class="fs-10 m-0 text-white">{{ $detail->service->name ?? "Layanan Tidak Ditemukan" }}</p>
                        <p class="fs-10 emas m-0">Rp {{ number_format($detail->service->price, 0, ",", ".") }}</p>
                    </div>
                </div>
            @endforeach


            <hr class="text-secondary px-2">
            @if ($transaction->barber && $transaction->barber->image)
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <img src="{{ asset("storage/" . $transaction->barber->image) }}" alt="Foto Barber" class="img-fluid rounded-circle me-auto" style="height: 60px; width: 60px; object-fit: cover; border-radius: 50%;" />
                    <div class="d-block ms-auto text-end">
                        <p class="fs-10 fw-bolder m-0 text-white">Barber yang Dipilih</p>
                        <p class="fs-10 emas m-0 ms-auto">{{ $transaction->barber->name ?? "Barber Tidak Ditemukan" }}
                        </p>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <p class="text-white">Foto Barber Tidak Tersedia</p>
                    </div>
            @endif
        </div>
</div>


<div class="abu mt-3 rounded border px-3 py-4" style="border-color: #4343433a !important;">
    <p class="fs-6 fw-bolder m-0 text-white">Detail Pembayaran</p>
    <hr class="text-secondary px-2">

    <div class="d-flex justify-content-between align-items-center fs-10 p-1 text-white">
        <p class="m-0">Biaya Layanan</p>
        <p class="m-0">Rp {{ number_format($detail->service->price, 0, ",", ".") }}</p>
    </div>

    <div class="d-flex justify-content-between align-items-center fs-10 p-1 text-white">
        <p class="m-0">Biaya Admin</p>
        <p class="m-0">Rp 1.000</p>
    </div>

    <div class="d-flex justify-content-between align-items-center fs-10 p-1 text-white">
        <p class="m-0">Biaya Aplikasi</p>
        <p class="m-0">Rp 1.000</p>
    </div>

    <hr class="text-secondary px-2">
    <p class="fs-10 fw-bolder m-0 text-white">Bukti Pembayaran</p>

    <div class="d-flex justify-content-center align-items-center mt-2">
        <img src="{{ asset("storage/" . $transaction->bukti_image ?? "https://via.placeholder.com/70") }}" alt="Service Image" class="img-fluid mt-1 rounded border border-white" style="height: 70px; width: 70px; object-fit: cover;"data-bs-toggle="modal" data-bs-target="#buktiModal">

        <div class="d-block ms-auto text-end">
            <p class="fs-10 fw-bolder m-0 text-white">Metode Pembayaran</p>
            <p class="fs-10 m-0 text-white">Transfer BRI</p>
        </div>
    </div>

    <hr class="text-secondary px-2">
    <div class="d-flex justify-content-between align-items-center emas p-1">
        <p class="fs-6 fw-bolder m-0">Total Harga</p>
        <p class="fs-6 fw-bolder m-0">
            Rp{{ number_format($transaction->details->sum("total_harga"), 0, ",", ".") }}</p>
    </div>

</div>
</section>

<!-- Modal untuk Foto Besar -->
<div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-body bg-dark rounded" style="width: 330px; height: 390px; object-fit: cover;">
            <p class="fs-10 fw-bolder mb-2 text-white">Bukti Pembayaran</p>
            <img src="{{ asset("storage/" . $transaction->bukti_image ?? "default1.jpg") }}" class="img-fluid d-block mx-auto rounded" alt="Profile" style="width: 100%; height: 91%; object-fit: cover; margin-top:0px;">
        </div>
    </div>
</div>

</div>

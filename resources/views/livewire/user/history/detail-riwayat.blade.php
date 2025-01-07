<div class="detail_riwayat">
    <!-- Bagian header -->
    <div class="d-flex justify-content-center abu fixed py-4 align-items-center position-relative">
        <a href="/riwayat" class="position-absolute start-0 p-3 text-white"
            style="font-size: 24px; border-radius: 50%; background-color: transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>
        <h5 class="mb-0 text-white text-center fw-bolder w-100">Informasi Pemesanan</h5>
    </div>

    <!-- Alert jika ada -->
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Detail Transaksi -->
    <section class="px-3 pt-3 pb-5 mb-2">
        <div class="abu px-3 pb-4 mb-3 rounded border">
            <h5 class="fs-7 text-white mb-0 fs-6 fw-bolder mt-4">Data Pemesan</h5>
            <hr class="px-2 text-secondary">
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
                        {{ \Carbon\Carbon::parse($transaction->appointment_date)->format('d/m/Y') }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center p-1">
                    <p class="fs-10 m-0 text-white">Jam Dipilih</p>
                    <p class="fs-10 m-0 text-white">{{ $transaction->time }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="abu px-3 pb-4 rounded border" style="border-color: #4343433a !important;">
            <h5 class="fs-7 text-white mb-0 fs-6 fw-bolder mt-4">Detail Layanan</h5>
            <hr class="px-2 text-secondary">
            @foreach ($transaction->details as $detail)
                <div class="d-flex justify-content-between align-items-center p-1">
                    <img src="{{ asset('storage/' . ($detail->service->image ?? 'default.jpg')) }}" alt="Foto Layanan"
                        class="img-fluid rounded"
                        style="height: 70px; width: 70px; object-fit: cover; border-radius: 50%;" />
                    <div class="d-block text-end">
                        <p class="fs-10 m-0 text-white">{{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}</p>
                        <p class="fs-10 m-0 emas">Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach


            <hr class="px-2 text-secondary">
            <p class="fs-10 m-0 text-white fw-bolder">Barber yang Dipilih</p>

            @if ($transaction->barber && $transaction->barber->image)
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <img src="{{ asset('storage/' . $transaction->barber->image) }}" alt="Foto Barber"
                        class="img-fluid rounded-circle"
                        style="height: 70px; width: 70px; object-fit: cover; border-radius: 50%;" />

                    <p class="fs-10 m-0 text-white ms-auto">{{ $transaction->barber->name ?? 'Barber Tidak Ditemukan' }}
                    </p>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <p class="text-white">Foto Barber Tidak Tersedia</p>
                </div>
            @endif  
        </div>

        <div class="abu px-3 py-4 mt-3 rounded border" style="border-color: #4343433a !important;">
            <p class="fs-6 text-white m-0 fw-bolder">Detail Pembayaran</p>
            <hr class="px-2 text-secondary">
            <p class="fs-10 m-0 text-white fw-bolder">Biaya Tambahan</p>
            <div class="d-flex justify-content-between align-items-center p-1 text-white fs-10">
                <p class="m-0">Biaya Admin</p>
                <p class="m-0">Rp 1.000</p>
            </div>

            <div class="d-flex justify-content-between align-items-center p-1 text-white fs-10">
                <p class="m-0">Biaya Aplikasi</p>
                <p class="m-0">Rp 1.000</p>
            </div>

            <hr class="px-2 text-secondary">
            <p class="fs-10 m-0 text-white fw-bolder">Bukti Pembayaran</p>

            <div class="d-flex justify-content-center align-items-center mt-2">
                <img src="{{ asset('storage/' . $transaction->bukti_image ?? 'https://via.placeholder.com/70') }}"
                    alt="Service Image" class="mt-1 img-fluid rounded border border-white"
                    style="height: 70px; width: 70px; object-fit: cover;">

                <div class="d-block text-end ms-auto">
                    <p class="fs-10 m-0 text-white fw-bolder">Metode Pembayaran</p>
                    <p class="fs-10 m-0 text-white">Transfer {{ $transaction->payment_method ?? 'BRI' }}</p>
                </div>
            </div>         

            <hr class="px-2 text-secondary">
            <div class="d-flex justify-content-between align-items-center p-1 emas">
                <p class="fs-6 m-0 fw-bolder">Total Harga</p>
                <p class="fs-6 m-0 fw-bolder">Rp{{ number_format($transaction->details->sum('total_harga'), 0, ',', '.') }}</p>
            </div>

        </div>
    </section>
</div>

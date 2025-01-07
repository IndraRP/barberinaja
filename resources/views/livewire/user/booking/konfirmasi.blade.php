<div>
    <div class="d-flex justify-content-center abu fixed py-4 align-items-center position-relative">
        <a href="/" class="position-absolute start-0 p-3 text-white"
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

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <section class="px-3 pt-3 pb-3">
        <!-- Data Pemesan -->
        <div class="abu px-3 pb-4 mb-3 rounded border" style="border-color: #4343433a !important;">
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
                    <p class="fs-10 m-0 text-white"> {{ \Carbon\Carbon::parse($transaction->time)->format('h:i') }}</p>
                </div>
            </div>
        </div>

        <div class="abu px-3 pb-4 mb-3 rounded border" style="border-color: #4343433a !important;">
            <h5 class="fs-7 text-white mb-0 fs-6 fw-bolder mt-4">Pembayaran</h5>
            <hr class="px-2 text-secondary">
            <div class="text-start">
                <div class="d-flex justify-content-between align-items-center p-1 emas">
                    <p class="fs-6 m-0 fw-bolder">Total Harga</p>
                    <p class="fs-6 m-0 fw-bolder">
                        Rp{{ number_format($transaction->details->sum('total_harga'), 0, ',', '.') }}</p>
                </div>
            </div>
</div>

<!-- Form Upload Bukti Pembayaran -->
<div class="abu px-3 pb-4 mb-4 rounded border" style="border-color: #4343433a !important;">
    <h5 class="fs-6 text-white mb-0 fw-bolder fs-5 mt-4">Upload Bukti Pembayaran</h5>
    <hr class="px-2 text-secondary">
    <div>
        <input type="file" wire:model="bukti_image" class="form-control mb-3">
        @error('bukti_image')
            <span class="text-danger">{{ $message }}</span>
        @else
            @if ($bukti_image)
                <span class="text-success">File telah dipilih: {{ $bukti_image->getClientOriginalName() }}</span>
            @endif
        @enderror
    </div>

    <button wire:click="confirmPayment" class="btn btn-warning text-white">Konfirmasi Pembayaran</button>
</div>

<div class="abu px-3 pb-4 mb-4 rounded border" style="border-color: #4343433a !important;">
    <button class="btn btn-outline-danger mt-4" onclick="confirmCancellation()">Batalkan Transaksi</button>
</div>
</section>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        console.log('Script loaded');

        function confirmCancellation() {
            console.log('confirmCancellation called');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan transaksi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak',
                background: '#1e1e2d',
                color: '#ffffff',
                iconColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('cancelTransaction');
                }
            });
        }
    </script>
@endpush


{{-- // try {
    //     let {
    //         components: components2,
    //         assets
    //     } = JSON.parse(content);
    // } catch (error) {
    //     console.error("Error parsing JSON:", content);
    // } --}}

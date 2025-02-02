@section("title", "Konfirmasi")

@section("styles")
    <style>
        .abu1 {
            background-color: #2c3034;
        }
    </style>
@endsection

<div>
    <div class="d-flex abu1 fixed-top align-items-center py-3">
        <a href="/" class="position-absolute start-0 p-3 text-white" style="font-size: 24px; border-radius: 50%; background-color: transparent;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>
        <p class="fs-6 fw-bolder w-100 mb-0 ms-5 mt-1 text-white">Informasi Pemesanan</p>
    </div>

    @if (session()->has("success"))
        <div class="alert alert-success">
            {{ session("success") }}
        </div>
    @endif

    @if (session()->has("error"))
        <div class="alert alert-danger">
            {{ session("error") }}
        </div>
    @endif

    <section class="px-3 pb-3" style="margin-top:80px;">
        <!-- Data Pemesan -->
        <div class="abu mb-3 rounded border px-3 pb-4" style="border-color: #4343433a !important;">
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
                    <p class="fs-10 m-0 text-white"> {{ \Carbon\Carbon::parse($transaction->time)->format("H:i") }}</p>
                </div>
            </div>
        </div>

        <div class="abu mb-3 rounded border px-3 pb-4" style="border-color: #4343433a !important;">
            <h5 class="fs-7 fs-6 fw-bolder mb-0 mt-4 text-white">Pembayaran</h5>
            <hr class="text-secondary px-2">
            <div class="text-start">
                <div class="d-flex justify-content-between align-items-center fs-10 p-1 text-white" onclick="copyAccountNumber()" wire:click="showAlert">
                    <p class="m-0">No Rekening</p>
                    <div x-data="{ active: false }" @click="active = !active" class="col-2 fs-6 m-0 ms-5 p-0 text-end">
                        <i :class="active ? 'emas' : 'text-white'" class="bi bi-copy"></i>
                    </div>
                    <p class="m-0" id="accountNumber">123456789123</p>
                </div>

                <div class="d-flex justify-content-between align-items-center fs-10 p-1 text-white">
                    <p class="m-0">Nama Bank</p>
                    <p class="m-0">Bank BRI</p>
                </div>

                <div class="d-flex justify-content-between align-items-center fs-10 p-1 text-white">
                    <p class="m-0">Atas Nama</p>
                    <p class="m-0">Indra Pratama</p>
                </div>

                <div class="d-flex justify-content-between align-items-center emas p-1">
                    <p class="fs-6 fw-bolder m-0">Total Harga</p>
                    <p class="fs-6 fw-bolder m-0">
                        Rp{{ number_format($transaction->details->sum("total_harga"), 0, ",", ".") }}</p>
                </div>

            </div>
        </div>

        <!-- Form Upload Bukti Pembayaran -->
        <div class="abu mb-4 rounded border px-3 pb-4" style="border-color: #4343433a !important;">
            <h5 class="fs-6 fw-bolder fs-5 mb-0 mt-4 text-white">Upload Bukti Pembayaran</h5>
            <hr class="text-secondary px-2">
            <div>
                <input type="file" wire:model="bukti_image" class="form-control">

                @error("bukti_image")
                    <span class="text-danger fs-8">{{ $message }}</span>
                @else
                    @if ($bukti_image)
                        <span class="text-success fs-8">File telah dipilih: {{ $bukti_image->getClientOriginalName() }}</span>
                    @endif
                @enderror

                <!-- Loading indicator -->
                <div wire:loading wire:target="bukti_image">
                    <span class="text-info fs-8">Mengunggah file...</span>
                </div>
            </div>


            <div class="d-flex justify-content-center fs-8">
                <!-- Menambahkan wire:loading untuk menampilkan status loading di tombol -->
                <button wire:click="confirmPayment" class="btn btn-warning fs-6 mt-3 text-white" wire:loading.attr="disabled">
                    <!-- Status loading di dalam tombol -->
                    <span wire:loading.remove>Konfirmasi Pembayaran</span>
                    <span wire:loading>Loading...</span>
                </button>
            </div>
        </div>

    </section>
</div>

@push("scripts")
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

    <script>
        function copyAccountNumber(text) {
            var tempTextarea = document.createElement("textarea");
            tempTextarea.style.position = "absolute";
            tempTextarea.style.left = "-9999px";
            tempTextarea.style.opacity = "0"; // Pastikan elemen tidak terlihat
            tempTextarea.value = text; // Isi dengan teks yang akan disalin
            document.body.appendChild(tempTextarea);

            // Pilih teks di dalam elemen <textarea>
            tempTextarea.select();
            tempTextarea.setSelectionRange(0, tempTextarea.value.length); // Pastikan teks terpilih sepenuhnya

            // Salin teks ke clipboard
            // try {
            //     document.execCommand("copy");
            //     alert("Code copied to clipboard: " + text); // Opsi: Tambahkan pesan alert atau visual feedback
            // } catch (err) {
            //     console.error("Gagal menyalin teks:", err);
            // }

            // Hapus elemen sementara
            document.body.removeChild(tempTextarea);
        }
    </script>
@endpush

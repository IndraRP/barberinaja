@section('title', 'Detail Pemesanan | Metode Pembayaran')
@section('styles')
    <style>
        /* General Styles for Select2 */
        .select2-container--default .select2-selection--single {
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Pusatkan label */
            text-align: center;
            background-color: #333;
            /* Warna latar belakang dropdown */
            color: #a48118;
            /* Warna teks */
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #a48118;
            /* Border emas */
            border-radius: 10px;
            padding: 0;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--single:hover {
            background-color: #222;
            /* Hover lebih gelap */
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #dddddd;
            background-color: #2f2f2f;
            color: #cfaf4b;
            /* Warna teks di search */
        }

        .select2-container--default .select2-results__option {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #242424;
            /* Background untuk opsi */
            color: #cfaf4b;
            /* Warna teks opsi */
            padding: 10px;
            font-size: 14px;
            border-bottom: 1px solid #333;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #333;
            /* Highlight opsi */
            color: #cfaf4b;
        }

        /* Style for Selected Option */
        .select2-container--default .select2-selection__rendered {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Pusatkan opsi terpilih */
            gap: 10px;
            color: #cfaf4b;
            /* Warna teks opsi terpilih */
            font-size: 15px;
        }

        .select2-container--default .select2-selection__rendered img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            object-fit: cover;
            /* Jaga agar gambar tidak terdistorsi */
        }

        /* Search Box */
        .select2-search--dropdown {
            display: block;
            padding: 4px;
            background-color: #bfa946;
            /* Warna latar belakang pencarian */
        }

        /* Scrollbar Styling */
        .select2-container--default .select2-results__options::-webkit-scrollbar {
            width: 8px;
            background-color: #333;
            /* Scroll background */
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar-thumb {
            background-color: #cfaf4b;
            /* Warna scroll */
            border-radius: 5px;
        }

        /* Dropdown Arrow */
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            position: absolute;
            top: 23px;
            right: 10px;
            width: 0;
        }

        /* Ensure Selected Text is White */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff;
        }


        .custom-swal-popup {
            width: 90%;
            max-width: 600px;
            min-width: 330px;
        }
    </style>
@endsection

<div class="pb-5 mb-2">
    <section>
        <div class="d-flex justify-content-center atas py-4 align-items-center fixed-top">
            <!-- Icon Kembali -->
            <a href="javascript:void(0);" class="position-absolute start-0 p-3 text-white"
                style="font-size: 24px; border-radius: 50%; background-color: transparent;" onclick="history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
            </a>

            <!-- Judul Teks -->
            <h5 class="mb-0 text-white text-center fw-bolder w-100">Informasi Pemesanan</h5>
        </div>

        <section class="px-3 pt-5 mt-5">
            <div class="abu px-3 pb-4 mb-4 rounded border" style="border-color: #4343433a !important;">
                <h5 class="fs-7 text-white mb-0 fs-6 fw-bolder mt-4">Data Pemesan</h5>
                <hr class="px-2 text-secondary">
                <div class="text-start">
                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">Nama Lengkap</p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">{{ $detail['name'] ?? '-' }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">No. Handphone </p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">{{ $detail['phone_number'] ?? '-' }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">Pesan untuk Tgl.</p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">
                            {{ isset($detail['tanggal']) ? \Carbon\Carbon::parse($detail['tanggal'])->format('d-m-Y') : '-' }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">Jam Dipilih</p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">{{ $detail['time'] ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="abu px-3 pb-4 mb-4 rounded border" style="border-color: #4343433a !important;">
                <h5 class="fs-6 text-white mb-0 fw-bolder fs-5 mt-4">Detail Layanan</h5>
                <hr class="px-2 text-secondary">
                <div class="d-flex align-items-center mt-2">
                    <img src="{{ session()->get('service_detail') ? asset('storage/' . session()->get('service_detail')['service_image']) : null }}"
                        alt="{{ $service->service_name }}" class="rounded d-block"
                        style="height: 70px; width: 70px; border: none; box-shadow: none; object-fit: cover;">

                    <div class="align-items-center px-3">
                        <p class="fs-10 mb-0 text-white">{{ $service->name ?? 'Nama Layanan' }}</p>
                        <p class="fs-10 emas">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>


                <div class="d-flex mt-4">
                    <img src="{{ session()->get('detail') ? asset('storage/' . session()->get('detail')['barber_image']) : null }}"
                        alt="{{ $barber }}" class="rounded-circle"
                        style="height: 55px; width: 55px; cursor: pointer; object-fit: cover;">

                    <div class="align-items-center px-3">
                        <p class="fs-10 mb-0 text-white pt-1">Barber yang Dipilih</p>
                        <p class="fs-10 emas">{{ $barber }}</p>
                    </div>
                </div>
            </div>

            <?php
            // Menghitung total pembayaran dengan menambahkan harga layanan dan biaya lainnya
            $totalPembayaran = ($service->price ?? 0) + ($detail['biaya_admin'] ?? 1000) + ($detail['biaya_aplikasi'] ?? 1000);
            ?>

            <!-- Rincian Pembayaran -->
            <div class="abu px-3 pb-4 mb-4 rounded border" style="border-color: #4343433a !important;">
                <h5 class="fs-7 text-white mb-0 fs-5 fw-bolder mt-4">Rincian Pembayaran</h5>
                <hr class="px-2 text-secondary">
                <div class="text-start">
                    <div class="d-flex justify-content-between align-items-center p-1 mt-2">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">Subtotal Layanan</p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">
                            Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">Biaya Admin</p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">
                            Rp {{ number_format($detail['biaya_admin'] ?? 1000, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-0">
                            <p class="fs-10 m-0">Biaya Aplikasi</p>
                        </div>
                        <div class="text-end fs-10 m-0 text-white">
                            Rp {{ number_format($detail['biaya_aplikasi'] ?? 1000, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-1">
                        <div class="rounded text-white gap-y-1">
                            <p class="fs-6 fw-bolder emas m-0">Total Pembayaran</p>
                        </div>
                        <div class="text-end fw-bolder fs-6 emas m-0">
                            Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                        </div>
                    </div>

                </div>
            </div>


            <div class="p-2 bawah fixed-bottom">
                <div class="d-flex justify-content-between align-items-center px-1" id="main-container">
                    <div class="d-flex flex-column m-0" id="text-container">
                        <h1 class="fs-5 text-white m-0"> Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h1>
                    </div>
                    <button type="button" class="btn kuning text-white fs-6 fw-bold py-2 px-3" data-bs-toggle="modal"
                        data-bs-target="#transactionModal" wire:click="bayar">
                        Lanjutkan
                    </button>
                </div>
            </div>

        </section>
 
        <!-- Modal -->
        <div class="modal fade align-items-center" wire:ignore.self id="transactionModal" tabindex="-1"
            aria-labelledby="transactionModalLabel" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: #1e1e2d; color: #ffffff;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel">Instruksi Pembayaran</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-warning py-1 mb-3 fs-9">Menunggu
                                Pembayaran</button>
                        </div>
                        <p class="fs-7 fw-bolder mb-1">Data Pemesan</p>
                        <div class="row">
                            <div class="col-6 fs-7">Nama Lengkap</div>
                            <div class="col-6 fs-7 text-end">{{ $detail['name'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 fs-7">No. Handphone</div>
                            <div class="col-6 fs-7 text-end">{{ $detail['phone_number'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 fs-7">Dipesan untuk tgl. </div>
                            <div class="col-6 fs-7 text-end">
                                {{ isset($detail['tanggal']) ? \Carbon\Carbon::parse($detail['tanggal'])->format('d-m-Y') : '-' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 fs-7">Jam Dilayani</div>
                            <div class="col-6 fs-7 text-end">{{ $detail['time'] ?? '-' }}</div>
                        </div>
                        <p class="fs-7 fw-bolder mb-1 mt-3">Detail Layanan</p>
                        <div class="row">
                            <div class="col-6 fs-7">Layanan</div>
                            <div class="col-6 fs-7 text-end">{{ $service->name ?? 'Layanan Tidak Ditemukan' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 fs-7">Barber yang Dipilih</div>
                            <div class="col-6 fs-7 text-end">{{ $barber }}</div>
                        </div>

                        <p class="fs-7 fw-bolder mb-1 mt-3">Pembayaran</p>
                        <div class="row">
                            <div class="col-6 fs-7">Metode Pembayaran</div>
                            <div class="col-6 fs-7 text-end" id="selectedBank">Transfer</div>
                        </div>
                        <div class="row">
                            <div class="col-4 fs-7">Nama Bank</div>
                            <div class="col-7 fs-7 text-end ms-auto">Bank BRI</div>
                        </div>
                        <div class="row">
                            <div class="col-6 fs-7">No. Rekening</div>
                            <div class="col-6 fs-7 text-end" id="accountNumber">123456789012</div>
                        </div>
                        <div class="row">
                            <div class="col-4 fs-7">Atas Nama</div>
                            <div class="col-7 fs-7 text-end ms-auto">Indra Pratama</div>
                        </div>
                        <div class="row">
                            <div class="col-6 fs-7 emas fw-bolder">Total Pembayaran</div>
                            <div class="col-6 fs-7 text-end emas fw-bolder">
                                Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                            </div>
                        </div>

                        <p class="fs-7 mt-3 text-center">Silahkan unggah bukti pembayaran di halaman konfirmasi setelah
                            selesai.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn kuning text-white fs-6 fw-bold py-2 px-3"
                            onclick="copyAccountNumber({{ $transactionId }})">
                            Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

@push('scripts')
    <!-- Script SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function copyAccountNumber(transactionId) {
            const accountNumber = document.getElementById('accountNumber').textContent; // Elemen dengan nomor rekening

            try {
                if (!accountNumber) {
                    console.error("Nomor rekening tidak ditemukan");
                    return;
                }

                // Membuat elemen textarea dummy untuk menyalin teks
                const dummy = document.createElement('textarea');
                dummy.value = accountNumber;
                dummy.style.position = 'absolute';
                dummy.style.left = '-9999px';

                // Menambahkan elemen ke body
                document.body.appendChild(dummy);

                // Memilih teks dan menyalin ke clipboard
                dummy.select();
                dummy.setSelectionRange(0, 99999); // Untuk kompatibilitas perangkat mobile

                document.execCommand('copy');

                // Menghapus elemen dummy
                document.body.removeChild(dummy);

                Swal.fire({
                    icon: 'success',
                    title: 'Nomor Rekening Disalin',
                    text: 'Nomor rekening telah disalin ke clipboard.',
                    background: '#1e1e2d',
                    color: '#ffffff',
                }).then(() => {
                    // Mengarahkan ke halaman konfirmasi dengan ID transaksi
                    window.location.href = '/konfirmasi/' + transactionId;
                });
            } catch (err) {
                console.error('Gagal menyalin nomor rekening:', err);

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyalin',
                    text: 'Terjadi kesalahan saat menyalin nomor rekening.',
                    background: '#1e1e2d',
                    color: '#ffffff',
                });
            }
        }
    </script>
@endpush

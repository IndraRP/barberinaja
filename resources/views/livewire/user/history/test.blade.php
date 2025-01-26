<div>
    @forelse ($transactions ?? [] as $transaction)
        <a href="{{ empty($transaction->bukti_image) ? "/konfirmasi/" . $transaction->id : "/detail_riwayat/" . $transaction->id }}">
            <div class="abu mx-3 mb-3 rounded border p-3" style="border-color: #ffffff9c !important;">
                <div class="d-flex align-items-center">
                    <p class="fs-8 fw-bolder mb-1 me-auto text-white">{{ $transaction->appointment_date->format("d/m/Y") }}</p>
                    <div class="fw-bolder {{ $transaction->status === "completed" ? "btn-bright" : ($transaction->status === "canceled" ? "btn-bright-danger" : ($transaction->status === "approved" ? "btn-bright-primary" : ($transaction->status === "pending" && !empty($transaction->bukti_image) ? "btn-bright-info" : "btn-bright-warning"))) }} fs-9 ms-auto py-1">
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

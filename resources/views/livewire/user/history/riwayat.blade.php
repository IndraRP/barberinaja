@section('title', 'Riwayat')

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

<div class="riwayat">
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

        <h5 class="mb-0 text-white text-center w-100">Pesanan Saya</h5>
    </div>

    <ul class="custom-nav-tabs justify-content-center d-flex p-0 mt-3" role="tablist">
        @foreach ($statuses as $key => $label)
            <li class="custom-nav-item" role="presentation">
                <a class="custom-nav-link {{ $filter === $key ? 'active' : '' }}"
                    wire:click="setFilter('{{ $key }}')" role="tab">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-3">
        @forelse ($transactions as $transaction)
            <a
                href="{{ $transaction->status === 'pending' ? '/konfirmasi/' . $transaction->id : '/detail_riwayat/' . $transaction->id }}">
                <div class="abu p-3 rounded border mb-3 mx-3" style="border-color: #4343433a !important;">
                    <div class="d-flex align-items-center">
                        <h1 class="fw-bold fs-6 mb-1 text-white">Layanan</h1>
                        <button type="button"
                            class="btn btn-outline-{{ $transaction->status === 'completed'
                                ? 'success'
                                : ($transaction->status === 'canceled'
                                    ? 'danger'
                                    : ($transaction->status === 'approved'
                                        ? 'primary'
                                        : 'warning')) }} ms-auto py-1 fs-9">
                            {{ $transaction->status === 'pending'
                                ? 'Menunggu Pembayaran'
                                : ($transaction->status === 'approved'
                                    ? 'Menunggu Hari'
                                    : ($transaction->status === 'completed'
                                        ? 'Selesai'
                                        : ($transaction->status === 'canceled'
                                            ? 'Dibatalkan'
                                            : ''))) }}
                        </button>
                    </div>

                    <div>
                        <p class="fs-9 mb-1 text-white ms-auto">{{ $transaction->appointment_date->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="d-flex">
                        <img src="{{ asset('storage/' . $transaction->bukti_image ?? 'https://via.placeholder.com/70') }}"
                            alt="Service Image" class="mt-1 img-fluid rounded border border-white"
                            style="height: 70px; width: 70px; object-fit: cover;">
                        <div class="d- align-items-center pb-1 px-3 my-1">
                            <div class="">
                                @foreach ($transaction->details as $detail)
                                    <p class="fw-bolder fs-7 mb-0 text-white">
                                        {{ $detail->service->name ?? 'Layanan Tidak Ditemukan' }}
                                    </p>
                                @endforeach
                                <p class="fs-9 mb-0 text-white">Jam Pesan: {{ $transaction->time }}</p>
                                <p class="fs-9 mb-0 text-white">Barberman:
                                    {{ $transaction->barber->name ?? 'Tidak Diketahui' }}</p>
                                <p class="fw-bolder fs-7 mb-0 emas">Rp
                                    {{ number_format($transaction->details->sum('total_harga'), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center m-3 p-3 abu rounded">
                <p class="text-danger mt-3">Belum ada transaksi untuk status</p>

                <div wire:ignore.self id="lottie"></div>
            </div>
        @endforelse
{{--         
        <div class="pb-4">
            <p class="fs-6 emas m-0">Anda Belum memiliki jadwal</p>
            <div id="lottie"></div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
            <script>
                var animation = lottie.loadAnimation({
                    container: document.getElementById('lottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: '{{ asset('images/Animation2.json') }}'
                });
            </script>
        </div> --}}
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                initializeLottie();
            });

            document.addEventListener('livewire:update', function() {
                initializeLottie();
            });

            function initializeLottie() {
                var lottieElement = document.getElementById('lottie');
                if (lottieElement && lottieElement.childElementCount === 0) { // Cek apakah elemen kosong
                    lottie.loadAnimation({
                        container: lottieElement,
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '{{ asset('images/Animation2.json') }}'
                    });
                }
            }
        </script>
    @endpush

</div>

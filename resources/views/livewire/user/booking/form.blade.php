@section("title", "Form")

@section("styles")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .text-emas {
            color: #cfaf4b;
        }

        ::placeholder {
            color: #fff !important;
        }

        .form-control,
        .form-select {
            background-color: #333;
            color: #ffffff;
            border: 1px solid #626060;
            border-radius: 10px;
            padding: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff;
            line-height: 28px;
        }

        .gas:focus {
            background-color: #333;
            color: #ffffff;
            box-shadow: 0 0 8px rgb(255, 217, 0);
            border-color: #ffd900;
        }

        .btn-check:checked+.btn,
        .btn.active,
        .btn.show,
        .btn:first-child:active,
        :not(.btn-check)+.btn:active {
            color: white;
            background-color: #d9c240;
            border-color: var(--bs-btn-active-border-color);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #333;
            color: #ffffff;
            box-shadow: 0 0 8px rgb(255, 217, 0);
            border-color: #ffd900;
        }

        .form-label {
            color: #cfaf4b;
            font-weight: bold;
        }

        .card {
            background-color: #222;
            border: 1px solid #444;
            border-radius: 12px;
        }

        .card-body {
            padding: 20px;
        }

        hr.text-emas {
            border-color: #a48118;
            margin-bottom: 20px;
        }

        h3 {
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-duration,
        .btn-time {
            background-color: #5E50B2;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-duration:hover,
        .btn-time:hover {
            background-color: #dad356;
        }

        .btn-duration:focus,
        .btn-time:focus {
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
            border-color: #a48118;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        button {
            margin: 5px;
        }


        /* Label di tengah dropdown */
        .select2-container--default .select2-selection--single {
            height: 50px;
            display: flex;
            align-items: center;
            text-align: center;
            background-color: #333;
            color: #a48118;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #a48118;
            border-radius: 10px;
            padding: 0;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--single:hover {
            background-color: #222;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #dddddd;
            background-color: #2f2f2f;
        }

        .select2-container--default .select2-results__option {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #242424;
            color: #cfaf4b;
            padding: 10px;
            font-size: 16px;
            border-bottom: 1px solid #333;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #333;
            color: #cfaf4b;
        }

        .select2-container--default .select2-results__option img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #cfaf4b;
        }

        /* Gaya untuk opsi terpilih */
        .select2-container--default .select2-selection__rendered {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #cfaf4b;
            font-size: 16px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #dddddd;
            line-height: 28px;
        }

        .select2-container--default .select2-selection__rendered img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #cfaf4b;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            background-color: #bfa946;
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar {
            width: 8px;
            background-color: #333;
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar-thumb {
            background-color: #cfaf4b;
            border-radius: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            margin-left: -10px;
            margin-top: -2px;
            position: absolute;
            top: 23px;
            width: 0;
        }

        .btn-time.taken-time {
            background-color: #392e2d7f;
            color: white;
            border-color: #5c5c5c7f;
        }

        .btn-time.taken-time:hover {
            background-color: #392e2d7f;
            border-color: #4542427f;
        }

        .btn-time.disabled {
            pointer-events: none;
        }

        .loading {
            opacity: 0.5;
        }
    </style>
@endsection


<div class="pb-4">
    <div class="d-flex justify-content-start align-items-center">
        <a href="javascript:void(0);" class="p-3 text-white" style="font-size: 24px; border-radius: 50%; margin-right: 10px; background-color: transparent;" onclick="history.back();">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" onclick="history.back();">
            </svg>
        </a>

        <h1 class="text-emas fs-3 mb-0">Form Pemesanan</h1>
    </div>

    <div class="mx-3 mt-1">
        <form wire:submit.prevent="submitBooking">
            <!-- Data Diri -->
            <div class="">
                <hr class="text-emas m-0 border-2 p-0">

                <div class="my-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control text-white" id="name" wire:model="name" required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control text-white" id="phone_number" wire:model="phone_number" required>
                </div>
            </div>
            <!-- Pilih Barber -->
            <div class="mb-3">
                <label for="barber" class="form-label">Pilih Barber</label>
                <select class="form-select" id="barber" wire:model="barber_id" required>
                    <option value="" selected>Barber Kami</option>
                    @foreach ($barbers as $barber)
                        <option value="{{ $barber->id }}" data-image="{{ asset("storage/" . $barber->image) }}">
                            {{ $barber->name }}
                        </option>
                    @endforeach
                </select>
                @error("barber_id")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <!-- Tanggal -->
            @if ($barber_id)
                <!-- Hanya tampilkan input tanggal jika barber telah dipilih -->
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Dipesan untuk tgl.</label>
                    <input type="date" id="tanggal" class="form-control" wire:model.live="tanggal" min="{{ now()->format("Y-m-d") }}" required>
                    @error("tanggal")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <!-- Waktu -->

            @if ($tanggal)
                <div class="mx-1 mb-5 pb-4" wire:loading.class="loading">
                    <label for="time" class="form-label text-emas">Pertemuan dimulai pada</label>
                    <div class="d-flex justify-content-between flex-wrap">
                        @foreach ($times as $time)
                            @php
                                $isTimeTaken = in_array($time, $takenTimes);
                            @endphp
                            <button type="button" class="btn btn-time fs-10 {{ $time == $this->time ? "active" : "" }} {{ $isTimeTaken ? "taken-time" : "" }}" wire:click="setTime('{{ $time }}')" {{ $isTimeTaken ? "disabled" : "" }}>
                                {{ $time }}
                            </button>
                        @endforeach
                    </div>
                    @error("time")
                        <span class="text-danger">Jadwal ini Wajib Diisi !!!</span>
                    @enderror
                </div>
            @endif

            <!-- Tombol Pesan -->
            <div class="d-flex justify-content-center fixed-bottom bawah pb-2 pt-3">
                <button type="submit" class="btn kuning px-4 py-2 text-white">Pesan Sekarang</button>
            </div>
        </form>
    </div>
</div>

@push("scripts")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        function add_image(dt) {
            var data = $(dt.element).data();
            var text = $(dt.element).text();

            // Cek apakah data gambar ada, jika ada tampilkan gambar dan teks
            if (data && data['image']) {
                var image = data['image']; // Nama file gambar
                var dt_image = $("<span><img src='" + image +
                    "' style='width:25px; height:25px; border-radius:50%; margin-right:5px;' />" + text +
                    "</span>");
                return dt_image;
            }
            return text;
        }

        var pilihan = {
            'placeholder': "Select a state",
            'templateSelection': add_image, // Menampilkan gambar saat item dipilih
            'templateResult': add_image, // Menampilkan gambar di dropdown
            'minimumResultsForSearch': -1 // Menonaktifkan pencarian
        };

        $("#barber").select2(pilihan);

        $('#barber').on('change', function() {
            @this.set('barber_id', $(this).val());
        });
    </script>
@endpush

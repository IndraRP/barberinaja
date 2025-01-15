@section('title', 'Auth ForgotPassword')

@section('styles')
    <style>
        .cont {
            padding-top: 170px;
            padding-bottom: 190px;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .abu {
            background-color: #292a2dc0;
            border-radius: 10px;
        }

        .atas {
            background-color: #1f2022;
            border-radius: 10px;
        }
    </style>
@endsection

<div class="cont"
    style="background-image: url('https://i.pinimg.com/474x/60/fe/cb/60fecbac0b8368d71a5d5360fc591316.jpg'); background-size: cover; background-position: center;">
    <div class="row justify-content-center mx-4 abu">
        <div class="col-md-6 my-5 ">
            <h4 class="emas text-center">Reset Password</h4>
            <p class="fs-7 text-white text-center">
                Masukkan alamat email Anda yang telah terdaftar, dan kami akan mengirimkan link untuk mengatur ulang
                kata sandi Anda.
            </p>
            <form wire:submit.prevent="sendResetLink">
                @csrf
                <div class="form-group emas">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" class="form-control bg-secondary text-light border-warning"
                        wire:model.defer="email" placeholder="Ketik di sini" required>

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-3 d-flex justify-content-center">
                    <button type="submit" class="btn kuning text-white fs-7 px-3 py-2 btn-sm booking-btn"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Atur Ulang Kata Sandi</span>
                        <span wire:loading>Kirim...</span>
                    </button>
                </div>

            </form>
        </div>


        <!-- Header dengan Tombol Kembali -->
        <div id="header" class="position-fixed w-100 top-0 start-0 atas transition-all">
            <div class="d-flex justify-content-between align-items-center p-1">
                <!-- Tombol Kembali -->
                <div class="d-flex align-items-center">
                    <a href="/login" id="backButton" class="text-white rounded-circle p-2 my-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a>
                    <!-- Text Detail Layanan -->
                    <p id="detailText" class="text-white fs-6 mt-3 fw-bolder ms-2">Kembali ke Login</p>
                </div>
            </div>
        </div>

    </div>

</div>

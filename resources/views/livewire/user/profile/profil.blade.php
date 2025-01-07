@section('title', 'Home')

@section('styles')
    <style>
        .profile-card {
            color: #eecc66;
            background-color: #001f3f00;
            border-radius: 20px;
            width: 100%;
            padding: 20px 10px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-card .profile-header {
            background: linear-gradient(135deg, #351e00, #846d17);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 280px;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            z-index: 1;
        }

        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            position: relative;
            z-index: 2;
            margin-top: 40px;
        }

        .profile-card h2 {
            font-size: 20px;
            margin: 15px 0 0px;
            position: relative;
            z-index: 2;
        }

        .profile-card p {
            font-size: 14px;
            margin: 0;
            color: #ababab;
            position: relative;
            z-index: 2;
        }

        .edit-icon {
            background: #ffffff;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 115px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 3;
        }

        .warna {
            background-color: #262b2f;
        }

        .bg-modal {
            background-color: #cfcfcf;
        }

        .swal-dark-mode {
            background-color: #1c1c1c !important;
            color: rgb(255, 255, 255) !important;
        }

        .swal-title-dark {
            color: #ebc349 !important;
            /* Emas untuk judul */
        }

        .swal-icon-dark {
            color: #ebc349 !important;
            /* Emas untuk ikon */
        }

        .swal-btn-dark {
            background-color: #a48118 !important;
            color: white !important;
            border: none;
            font-weight: bold;
        }

        .swal-btn-cancel {
            background-color: transparent !important;
            color: #d33 !important;
            border: 2px solid #d33 !important;
        }

        .swal-btn-cancel:hover {
            background-color: #d33 !important;
            color: white !important;
        }

        .swal-cancel-outline {
            border: 2px solid #d33;
            color: #d33;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .swal-cancel-outline:hover {
            background-color: #d33;
            color: white;
        }

        div:where(.swal2-icon).swal2-question {
            border-color: rgb(104, 105, 24);
            color: #87adbd;
        }

        .nav_card {
            margin-top: 65px;
        }
    </style>
@endsection

<div>
    <section>
        <div class="body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="profile-card">
                <div class="profile-header"></div>

                <img src="{{ asset('storage/' . ($image ?? 'images/profiles/barber1.png')) }}" alt="Profile Picture" class="profile-image">

                <div class="edit-icon mt-5" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square emas fw-bold fs-10"></i>
                </div>

                <h2>{{ $name }}</h2>
                <p>{{ $email }}</p>

                <div class="nav_card py-4 warna mx-2 rounded">
                    <div class="mt-1 py-2 px-3 rounded d-flex align-items-center mx-2 edit-profile"
                        data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square emas fw-bold fs-5"></i>
                        <h1 class="fs-7 text-white mx-3 pt-2">Edit Profile</h1>
                        <i class="fa-solid fa-chevron-right ms-auto chevron-right"></i>
                    </div>

                    <div class="mt-1 py-2 px-3 rounded d-flex align-items-center mx-2 edit-profile"
                        data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                        <i class="fa-solid fa-unlock-keyhole emas fw-bold fs-5"></i>
                        <h1 class="fs-7 text-white mx-3 pt-2">Ubah Password</h1>
                        <i class="fa-solid fa-chevron-right ms-auto chevron-right"></i>
                    </div>

                    <a href="mailto:indra@gmail.com?subject=Hubungi%20Kami&body=Halo,%20saya%20ingin%20menghubungi%20Anda"
                        class="text-decoration-none">
                        <div class="mt-1 py-2 px-3 rounded d-flex align-items-center mx-2 edit-profile">
                            <i class="fa-solid fa-square-phone emas fw-bold fs-5"></i>
                            <h1 class="fs-7 text-white mx-3 pt-2">Hubungi Kami</h1>
                            <i class="fa-solid fa-chevron-right ms-auto chevron-right emas"></i>
                        </div>
                    </a>

                    <div class="mt-1 py-2 px-3 rounded d-flex align-items-center mx-2 edit-profile"
                        onclick="confirmLogout()">
                        <i class="bi bi-arrow-right-square-fill text-danger fw-bold fs-5"></i>
                        <h1 class="fs-7 text-danger mx-3 pt-2">Logout</h1>
                        <i class="fa-solid fa-chevron-right ms-auto chevron-right text-danger"></i>
                    </div>
                </div>
            </div>
        </div> 
    </section>

    <div wire:ignore.self class="modal fade align-items-center" id="editProfileModal" tabindex="-1"
        aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateProfile">
                        <div class="mb-3">
                            <label for="name" class="form-label emas">Nama</label>
                            <input type="text" class="form-control bg-modal" id="name"
                                placeholder="Masukkan Nama" wire:model.defer="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label emas">Email</label>
                            <input type="email" class="form-control bg-modal" id="email"
                                placeholder="Masukkan Email" wire:model.defer="email">
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label emas">Foto</label>
                            <input type="file" class="form-control bg-modal" id="photo" wire:model="imageUpload">
                            @if ($imageUpload)
                                <div class="mt-2">
                                    <p class="text-success">Gambar berhasil dipilih:
                                        <strong>{{ $imageUpload->getClientOriginalName() }}</strong>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="kuning text-white rounded py-1 px-3 border border-warning"
                        wire:click="updateProfile">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade align-items-center" id="editPasswordModal" tabindex="-1"
        aria-labelledby="editPasswordModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="editPasswordModalLabel">Edit Password</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updatePassword">
                        <div class="mb-3">
                            <label for="password" class="form-label emas">Password Lama</label>
                            <input type="password" class="form-control bg-modal" id="password"
                                placeholder="Masukkan Password Lama" wire:model.defer="password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label emas">Password Baru</label>
                            <input type="password" class="form-control bg-modal" id="new_password"
                                placeholder="Masukkan Password Baru" wire:model.defer="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label emas">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control bg-modal" id="confirm_password"
                                placeholder="Masukkan kembali Password Baru" wire:model.defer="confirm_password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="kuning text-white rounded py-1 px-3 border border-warning"
                        wire:click="updatePassword">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Apakah Anda ingin keluar dari Akun ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffd700',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    cancelButton: 'swal-cancel-outline',
                    popup: 'swal-dark-mode', 
                    title: 'swal-title-dark',
                    icon: 'swal-icon-dark',
                    confirmButton: 'swal-btn-dark', 
                    cancelButton: 'swal-btn-cancel'
                },
                background: '#1c1c1c',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('logout');
                }
            });
        }
    </script>
@endpush

@section("title", "Home")

@section("styles")
    <style>
        .icon-size {
            font-size: 1.5rem;
        }

        .icon-size2 {
            font-size: 1.3rem;
        }

        .profile-card {
            color: #eecc66;
            background-color: #001f3f00;
            border-radius: 20px;
            width: 100%;
            padding: 20px 10px 50px;
            min-height: screen;
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

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 1);
        }
    </style>
@endsection

<div>
    <section>
        <div class="body">
            @if (session("success"))
                <div class="alert alert-success">
                    {{ session("success") }}
                </div>
            @endif

            @if (session("error"))
                <div class="alert alert-danger">
                    {{ session("error") }}
                </div>
            @endif

            <div class="profile-card">
                <div class="profile-header"></div>

                <img src="{{ asset("storage/" . ($image ?? "images/profiles/default.jpg")) }}" alt="Profile Picture" class="profile-image" data-bs-toggle="modal" data-bs-target="#profileModal">

                <div class="edit-icon mt-5" data-bs-toggle="modal" data-bs-target="#editimageModal">
                    <i class="bi bi-camera-fill emas fw-bold fs-6"></i>
                </div>

                <h2>{{ $name }}</h2>
                <p>{{ $email }}</p>

                <div class="nav_card warna mx-2 rounded py-4">
                    <div class="d-flex align-items-center edit-profile mx-2 mt-1 rounded px-3 py-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fa-solid fa-square-pen emas fw-bold icon-size"></i>
                        <h1 class="fs-7 mx-3 pt-2 text-white">Edit Profile</h1>
                        <i class="fa-solid fa-chevron-right chevron-right ms-auto"></i>
                    </div>

                    <div class="d-flex align-items-center edit-profile mx-2 mt-1 rounded px-3 py-2" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                        <i class="fa-solid fa-table-cells-row-unlock emas fw-bold icon-size2"></i>
                        <h1 class="fs-7 mx-3 pt-2 text-white">Ubah Password</h1>
                        <i class="fa-solid fa-chevron-right chevron-right ms-auto"></i>
                    </div>

                    <a href="mailto:indra@gmail.com?subject=Hubungi%20Kami&body=Halo,%20saya%20ingin%20menghubungi%20Anda" class="text-decoration-none">
                        <div class="d-flex align-items-center edit-profile mx-2 mt-1 rounded px-3 py-2">
                            <i class="fa-solid fa-square-phone emas fw-bold icon-size"></i>
                            <h1 class="fs-7 mx-3 pt-2 text-white">Hubungi Kami</h1>
                            <i class="fa-solid fa-chevron-right chevron-right emas ms-auto"></i>
                        </div>
                    </a>

                    <div class="d-flex align-items-center edit-profile mx-2 mt-1 rounded px-3 py-2" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-arrow-right-square-fill text-danger fw-bold icon-size2"></i>
                        <h1 class="fs-7 text-danger mx-3 pt-2">Logout</h1>
                        <i class="fa-solid fa-chevron-right chevron-right ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal untuk Foto Besar -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-body bg-dark rounded" style="width: 330px; height: 330px; object-fit: cover;">
                <!-- Gambar Besar di dalam Modal -->
                <img src="{{ asset("storage/" . ($image ?? "images/profiles/default.jpg")) }}" class="img-fluid d-block mx-auto rounded border-0" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; margin-top:0px;">
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade align-items-center" id="editimageModal" tabindex="-1"aria-labelledby="editimageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="editimageModalLabel">Edit Foto Profile</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveimage">
                        <div class="mb-3">
                            <label for="photo" class="form-label emas">Unggah Foto</label>
                            <input type="file" class="form-control bg-modal" id="photo" wire:model="imageUpload">

                            @error("imageUpload")
                                <span class="text-danger fs-8">{{ $message }}</span>
                            @enderror

                            @if ($imageUpload && !$errors->has("imageUpload"))
                                <div class="mt-2">
                                    <p class="text-success fs-8">Gambar berhasil dipilih:
                                        <strong>{{ $imageUpload->getClientOriginalName() }}</strong>
                                    </p>
                                </div>
                            @endif

                            <!-- Loading indicator -->
                            <div wire:loading wire:target="imageUpload">
                                <span class="text-info fs-8">Mengunggah file...</span>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="kuning border-warning rounded border px-3 py-1 text-white" wire:click="saveimage" wire:loading.attr="disabled">
                        <span wire:loading.remove>Ubah Gambar</span>
                        <span wire:loading>Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade align-items-center" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="editProfileModalLabel">Edit Profile</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateProfile">
                        <div class="mb-3">
                            <label for="name" class="form-label emas">Nama Lengkap</label>
                            <input type="text" class="form-control bg-modal" id="name" placeholder="Ketik di sini" wire:model.defer="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label emas">Email</label>
                            <input type="email" class="form-control bg-modal" id="email" placeholder="Ketik di sini" wire:model.defer="email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="kuning border-warning rounded border px-3 py-1 text-white" wire:click="updateProfile">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade align-items-center" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="editPasswordModalLabel">Edit Kata Sandi</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updatePassword">
                        <div class="mb-3">
                            <label for="password" class="form-label emas">Kata Sandi Lama</label>
                            <input type="password" class="form-control bg-modal" id="password" placeholder="Ketik di sini" wire:model.defer="password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label emas">Kata Sandi Baru</label>
                            <input type="password" class="form-control bg-modal" id="new_password" placeholder="Ketik di sini" wire:model.defer="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label emas">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control bg-modal" id="confirm_password" placeholder="Ketik di sini" wire:model.defer="confirm_password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="kuning border-warning rounded border px-3 py-1 text-white" wire:click="updatePassword">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered px-5">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0">
                    <div class="d-flex justify-content-center w-100">
                        <img src="https://cdn-icons-png.freepik.com/256/14442/14442285.png?ga=GA1.1.894313801.1732955252&semt=ais_hybrid" alt="Logout Icon" style="height: 150px; width:150px">
                    </div>
                </div>
                <div class="modal-body border-0 py-1">
                    <p class="fs-6 fw-bolder emas text-center">Apakah Anda Yakin ingin keluar dari Akun ini?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="Livewire.dispatch('logout')">Ya,
                        Logout</button>
                </div>
            </div>
        </div>
    </div>

</div>

<nav class="navbar navbar-custom d-lg-none">
    <div class="container-fluid">
        <ul class="navbar-nav d-flex flex-row justify-content-around w-100">
            <li class="nav-item text-center">
                <a class="nav-link" href="/home_barber" id="dashboardLink">
                    <i class="bi bi-house-door-fill"></i>
                    <p class="nav-text m-0 p-0">Utama</p>
                </a>
            </li>

            <li class="nav-item text-center pt-2">
                <a class="nav-link" href="/layanan_barber" id="bookingLink" style="font-size: 7px;">
                    <i class="fa-solid fa-scissors mb-2"></i>
                    <p class="nav-text pt-1">Layanan</p>
                </a>
            </li>

            <li class="nav-item text-center">
                <a class="nav-link" href="/history_barber" id="orderLink">
                    <i class="bi bi-calendar2-check-fill"></i>
                    <p class="nav-text m-0 p-0">Riwayat</p>
                </a>
            </li>

            <li class="nav-item text-center">
                <a class="nav-link" href="/profile_barber" id="profileLink">
                    <i class="bi bi-person-fill"></i>
                    <p class="nav-text m-0 p-0">Profil</p>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;

        const links = [
            { path: '/home_barber', id: 'dashboardLink' },
            { path: '/layanan_barber', id: 'bookingLink' },
            { path: '/history_barber', id: 'orderLink' },
            { path: '/profile_barber', id: 'profileLink' }
        ];

        links.forEach(link => {
            const element = document.getElementById(link.id);

            // Menghapus kelas active dari semua elemen
            element.classList.remove('active');

            // Menambahkan kelas active hanya pada elemen yang sesuai
            if (currentPath === link.path) {
                element.classList.add('active');
            }
        });
    });
</script>

<style>
    .navbar-custom {
        background-color: #333;
        padding: 5px 0;
        border-radius: 20px 20px 0 0;
        position: fixed;
        bottom: 0;
        width: 100%;
        box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .navbar-nav {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        width: 100%;
    }

    .nav-item {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        font-size: 10px;
        transition: color 0.3s, transform 0.3s;
    }

    .nav-link i {
        font-size: 25px;
        margin-bottom: 4px;
        transition: transform 0.3s, color 0.3s;
    }

    .nav-link.active {
        color: #c7980b;
    }

    .nav-link.active i {
        color: #c7980b;
        font-size: 28px;
        margin-bottom: 0;
        transform: scale(1.1);
    }

    .nav-link.active .nav-text {
        color: #c7980b;
        margin-top: 0;
        padding-top: 0;
    }

    .nav-text {
        font-size: 10px;
        line-height: 1;
        margin: 0;
        transition: color 0.3s;
    }

    @media (min-width: 768px) {
        .navbar-custom {
            display: none;
        }
    }
</style>

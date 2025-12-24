<?php
/**
 * home.php
 * Konten utama untuk halaman Beranda.
 * File ini akan di-include di antara header.php dan footer.php.
 * Diasumsikan variabel seperti $is_logged_in, $user_name, dan url_for() sudah tersedia.
 */

// Set judul halaman untuk header.php
$page_title = "Beranda"; 

// --- Perhatikan: Navbar sudah ada di header.php, jadi konten dimulai setelah <nav> --- 
?>

    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Welcome To Website CampusIntern!</h1>
            <p>
                Cari Magangan Sesuai dengan Minat dan Keahlianmu! Temukan tempat
                magang favoritmu di Sini!
            </p>
        </div>

        <div class="search-box">
            <!-- Mengganti route('info') dengan url_for('info') -->
            <button><a href="<?= url_for('info') ?>">🔍Cari Magang</a></button>
        </div>
    </section>

    <section class="section">
        <div class="text">
            <h2>Jelajahi Potensi, Raih Prestasi</h2>
            <p>
                Inilah kesempatan Anda untuk menggali potensi diri dalam lingkungan
                profesional...
            </p>
        </div>
        <div class="image">
            <!-- Mengganti asset('img/...') dengan path relatif dari index.php -->
            <img src="img/presentasi.jpg" alt="gak tampil" />
        </div>
    </section>

    <section class="section reverse">
        <div class="image">
            <!-- Mengganti asset('img/...') dengan path relatif dari index.php -->
            <img src="img/pengalaman.jpg" alt="pengalaman" />
        </div>
        <div class="text">
            <h2>Bersiap Berkembang Secara Profesional</h2>
            <p>
                Jadikan pengalaman magang ini sebagai awal perjalanan Anda menuju
                kesuksesan...
            </p>
        </div>
    </section>

    <section class="steps">
        <div class="step">
            <div class="circle">1</div>
            <h3>Registrasi Akun</h3>
            <p>
                Calon pengguna dapat melakukan registrasi akun melalui menu “Daftar
                Sekarang”.
            </p>
        </div>
        <div class="step">
            <div class="circle">2</div>
            <h3>Pilih Program Magang</h3>
            <p>
                Jelajahi daftar Program Magang yang tersedia pada menu “Cari
                Lowongan”.
            </p>
        </div>
        <div class="step">
            <div class="circle">3</div>
            <h3>Proses Seleksi</h3>
            <p>Simak terus status penerimaanmu pada menu “Status Lamaran”.</p>
        </div>
        <div class="step">
            <div class="circle">4</div>
            <h3>Pelaksanaan Magang</h3>
            <p>
                Lengkapi laporan aktivitas harian agar kamu berhak menerima sertifikat
                magang resmi.
            </p>
        </div>
    </section>

    <section class="faq">
        <h2>Pertanyaan yang Paling Sering Ditanyakan</h2>
        <div class="faq-item">
            <div class="faq-question">
                <span>Apakah semua program magang di sini berbayar?</span>
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                Seluruh program magang yang tersedia disini bersifat gratis.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Apa itu Website CampusIntern?</span>
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                Website CampusIntern adalah sebuah platform digital yang
                memudahkan siswa/mahasiswa/freshgraduate menemukan program magang
                sesuai minat dan keahlian mereka masing-masing, sekaligus
                menghubungkan mereka dengan perusahaan penyedia magang.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Bagaimana cara mendaftar di Website CampusIntern?</span>
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                Untuk mendaftar: Klik tombol "Daftar" di halaman utama. Isi data
                diri seperti nama, email, dan kata sandi. Verifikasi akun melalui
                email. Lengkapi profil dengan informasi pendidikan dan
                keterampilan.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Apakah saya bisa melamar lebih dari satu perusahaan magang?</span>
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                Bisa, karena pengguna bebas mau mendaftar berapapun perusahaan.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Bagaimana cara mengetahui status lamaran saya?</span>
                <span class="toggle-btn">+</span>
            </div>
            <div class="faq-answer">
                Status lamaran Anda akan diperbarui di menu “informasi”. Selain
                itu, notifikasi akan dikirim melalui email atau aplikasi setiap
                kali ada perubahan status.
            </div>
        </div>
    </section>
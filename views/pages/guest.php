<?php
/**
 * home.php
 * Konten utama untuk halaman Beranda.
 * File ini akan di-include di antara header.php dan footer.php.
 * Diasumsikan variabel seperti $is_logged_in, $user_name, dan url_for() sudah tersedia.
 */

// Set judul halaman untuk header.php
$page_title = "Guest"; 

// --- Perhatikan: Navbar sudah ada di header.php, jadi konten dimulai setelah <nav> --- 
?>
   
    <body>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth-page-container">
        
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg auth-form-card">
                {{ $slot }}
            </div>
        </div>
        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
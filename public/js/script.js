const toggleBtn = document.getElementById('darkModeToggle');

// Cek preferensi dark mode sebelumnya dari localStorage
if (localStorage.getItem('darkMode') === 'enabled') {
  document.body.classList.add('dark');
  toggleBtn.textContent = 'Light Mode';
} else {
  toggleBtn.textContent = 'Dark Mode';
}

// Tombol toggle
toggleBtn.addEventListener('click', () => {
  document.body.classList.toggle('dark');

  // Simpan preferensi di localStorage
  if (document.body.classList.contains('dark')) {
    localStorage.setItem('darkMode', 'enabled');
    toggleBtn.textContent = 'Light Mode';
  } else {
    localStorage.setItem('darkMode', 'disabled');
    toggleBtn.textContent = 'Dark Mode';
  }
});

  // filter search berdasar jurusan

  
  // ====== FAQ TOGGLE ======
  // Ambil semua elemen pertanyaan FAQ
  const faqQuestions = document.querySelectorAll(".faq-question");

  // Tambahkan event klik ke setiap pertanyaan
  faqQuestions.forEach((question) => {
    question.addEventListener("click", () => {
      const parent = question.parentElement;
      const toggleBtn = question.querySelector(".toggle-btn");

      // Toggle class aktif
      parent.classList.toggle("active");

      // Ubah tanda + jadi - dan sebaliknya
      if (parent.classList.contains("active")) {
        toggleBtn.textContent = "–";
      } else {
        toggleBtn.textContent = "+";
      }
    });
  });

  
  // --- FITUR DROPDOWN DESKRIPSI ---
  // --- FITUR DROPDOWN DESKRIPSI (hanya satu terbuka) ---
  const cardHeaders = document.querySelectorAll(".card-header");
  cardHeaders.forEach((header) => {
    header.addEventListener("click", function () {
      const card = this.closest(".card");
      const content = card.querySelector(".card-content");
      const icon = this.querySelector(".toggle-icon");

      // Tutup semua card lain
      document.querySelectorAll(".card-content").forEach((otherContent) => {
        if (otherContent !== content) {
          otherContent.classList.remove("active");
        }
      });
      document
        .querySelectorAll(".card-header .toggle-icon")
        .forEach((otherIcon) => {
          if (otherIcon !== icon) {
            otherIcon.style.transform = "rotate(0deg)";
          }
        });

      // Toggle dropdown yang diklik
      const isOpen = content.classList.toggle("active");
    });
  });

  // ====== MULTI-STEP FORM ini punya zala ======
  const form = document.getElementById("multiStepForm");

  if (form) {
    // ✅ Cek dulu apakah form ada di halaman ini
    const steps = document.querySelectorAll(".form-step");
    const nextBtn = document.querySelectorAll(".btn-next");
    const prevBtn = document.querySelectorAll(".btn-prev");
    const successMsg = document.createElement("div");
    let currentStep = 0;

    // Tambah pesan berhasil
    successMsg.classList.add("success-message");
    successMsg.innerHTML = `
    <h3>✅ Pendaftaran Berhasil!</h3>
    <p>Terima kasih, data kamu sudah terkirim. Kami akan segera menghubungi melalui email.</p>
    <button id="backBtn">Kembali</button>
  `;
    successMsg.style.display = "none";

    // ✅ Benerin append di luar form-container
    const wrapper = document.querySelector(".form-wrapper");
    if (wrapper) wrapper.appendChild(successMsg);

    // Next step
    nextBtn.forEach((button) => {
      button.addEventListener("click", () => {
        const inputs = steps[currentStep].querySelectorAll(
          "input, select, textarea"
        );
        let valid = true;

        inputs.forEach((input) => {
          if (input.hasAttribute("required")) {
            // ✅ Validasi khusus FILE (upload)
            if (input.type === "file") {
              if (input.files.length === 0) {
                input.style.border = "1px solid red";
                valid = false;
              } else {
                input.style.border = "1px solid #ccc";
              }

              // ✅ Validasi input biasa (text, email, select, textarea)
            } else if (!input.value.trim()) {
              input.style.border = "1px solid red";
              valid = false;
            } else {
              input.style.border = "1px solid #ccc";
            }
          }
        });

        if (!valid) return;

        steps[currentStep].classList.remove("active");
        currentStep++;
        steps[currentStep].classList.add("active");
      });
    });

    // Prev step
    prevBtn.forEach((button) => {
      button.addEventListener("click", () => {
        steps[currentStep].classList.remove("active");
        currentStep--;
        steps[currentStep].classList.add("active");
      });
    });

    // Submit form
    form.addEventListener("submit", (e) => {
      // Validasi CV wajib
      const cvFile = document.getElementById("cvFile");
    cvFile.setCustomValidity(""); 
    if (!cvFile.files.length) {
      cvFile.setCustomValidity("Silakan upload CV kamu dulu ya (PDF wajib).");
      cvFile.reportValidity(); 
      e.preventDefault(); // JIKA GAGAL, baru hentikan
      return;
    }

      // ✅ Kalau lolos validasi, baru lanjut ke tampilan sukses
      document.querySelector(".form-container").style.display = "none";
      successMsg.style.display = "block";
    });
  }

  // Event tombol kembali
    const backBtn = document.getElementById("backBtn");
    if (backBtn) {
        backBtn.addEventListener("click", () => {
            // Laravel mengeksekusi ini sebelum halaman dimuat di browser
            window.location.href = "{{ route('halaman_utama') }}"; 
        });
    }

  // hamburger menuuuuu
  document.addEventListener("DOMContentLoaded", () => {
  const hamburgerBtn = document.getElementById("hamburgerBtn");
  const navMenu = document.querySelector(".nav-menu");

  if (hamburgerBtn && navMenu) { // ✅ sudah aman
    hamburgerBtn.addEventListener("click", () => {
      navMenu.classList.toggle("active");
    });
  }
});


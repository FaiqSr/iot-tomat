// ===== Navbar Scroll Effect =====
window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar-custom");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

// ===== Scroll Reveal Section Animation =====
const sections = document.querySelectorAll(".section");
window.addEventListener("scroll", revealSections);

function revealSections() {
    const triggerBottom = window.innerHeight * 0.85;
    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop < triggerBottom) {
            section.classList.add("visible");
        }
    });
}

// ===== Smooth Page Fade-in =====
document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = 0;
    setTimeout(() => {
        document.body.style.transition = "opacity 1s ease-in";
        document.body.style.opacity = 1;
    }, 100);
});

// ===== Parallax Hero Background Effect =====
window.addEventListener("scroll", () => {
    const hero = document.querySelector(".hero");
    if (hero) {
        let offset = window.scrollY * 0.4;
        hero.style.backgroundPositionY = `${offset}px`;
    }
});
// Contoh animasi saat scroll
document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll(".section");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add("fade-in");
            }
        });
    }, { threshold: 0.1 });

    sections.forEach(section => observer.observe(section));
});

//dashboard
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    if(toggle && sidebar) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
    }
    document.addEventListener('click', (e) => {
        if(window.innerWidth < 901 && sidebar.classList.contains('open')) {
            if(!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
});

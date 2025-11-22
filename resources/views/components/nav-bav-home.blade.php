<header id="mainHeader"
    class="flex fixed w-full justify-between p-5 items-center bg-transparent transition-colors duration-300 z-50">
    <nav class="font-semibold text-lg">IOT Tomat Guard</nav>

    <!-- Desktop links -->
    <ul class="hidden md:flex gap-5">
        <li><a href="{{ route('home') }}" class="hover:text-gray-700">Home</a></li>
        <li><a href="{{ route('about') }}" class="hover:text-gray-700">About Us</a></li>
        <li><a href="{{ route('panduan') }}" class="hover:text-gray-700">Panduan</a></li>
        <li><a href="{{ route('contact') }}" class="hover:text-gray-700">Contact</a></li>
    </ul>

    <!-- Mobile: hamburger -->
    <section class="hidden md:flex">
        <a href="{{ route('login') }}"
            class="px-5 py-2 border border-gray-700 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors text-center">Login</a>
    </section>
    <div class="md:hidden flex items-center gap-3">
        <button id="mobileMenuBtn" aria-label="Open menu" aria-expanded="false" class="p-2 rounded-md">
            <svg id="hamburgerIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile slide-in panel & backdrop -->
    <div id="mobileMenuBackdrop" class="hidden fixed inset-0 bg-black/40 z-40"></div>

    <aside id="mobileMenuPanel"
        class="fixed right-0 top-0 h-full w-64 bg-white p-6 transform translate-x-full transition-transform shadow-lg z-50"
        aria-hidden="true">
        <div class="flex items-center justify-between mb-6">
            <div class="font-semibold">Menu</div>
            <button id="mobileMenuClose" aria-label="Close menu" class="p-2 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <nav class="space-y-4">
            <a href="{{ route('home') }}" class="block text-gray-700 font-medium">Home</a>
            <a href="{{ route('about') }}" class="block text-gray-700 font-medium">About Us</a>
            <a href="{{ route('panduan') }}" class="block text-gray-700 font-medium">Panduan</a>
            <a href="{{ route('contact') }}" class="block text-gray-700 font-medium">Contact</a>
        </nav>

        <div class="mt-6">
            <a href="{{ route('login') }}"
                class="block w-full text-center px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold">Login</a>
        </div>
    </aside>


</header>

@push('scripts')
    <script>
        (function() {
            const btn = document.getElementById('mobileMenuBtn');
            const closeBtn = document.getElementById('mobileMenuClose');
            const panel = document.getElementById('mobileMenuPanel');
            const backdrop = document.getElementById('mobileMenuBackdrop');

            function openMenu() {
                panel.classList.remove('translate-x-full');
                panel.setAttribute('aria-hidden', 'false');
                btn.setAttribute('aria-expanded', 'true');
                backdrop.classList.remove('hidden');
                // trap focus to panel
                panel.querySelector('a, button')?.focus();
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                panel.classList.add('translate-x-full');
                panel.setAttribute('aria-hidden', 'true');
                btn.setAttribute('aria-expanded', 'false');
                backdrop.classList.add('hidden');
                btn.focus();
                document.body.style.overflow = '';
            }

            btn.addEventListener('click', openMenu);
            closeBtn.addEventListener('click', closeMenu);
            backdrop.addEventListener('click', closeMenu);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeMenu();
            });

            // Header background on scroll
            const headerEl = document.getElementById('mainHeader');
            const logoEl = headerEl.querySelector('nav.font-semibold');
            const desktopLinks = headerEl.querySelectorAll('ul a');
            const mobilePanel = document.getElementById('mobileMenuPanel');

            function onScroll() {
                if (window.scrollY > 12) {
                    headerEl.classList.add('bg-white', 'shadow-md');
                    headerEl.classList.remove('bg-transparent');
                    if (logoEl) logoEl.classList.add('text-gray-800');
                    desktopLinks.forEach(a => a.classList.add('text-gray-800'));
                } else {
                    headerEl.classList.remove('bg-white', 'shadow-md');
                    headerEl.classList.add('bg-transparent');
                    if (logoEl) logoEl.classList.remove('text-gray-800');
                    desktopLinks.forEach(a => a.classList.remove('text-gray-800'));
                }
            }

            window.addEventListener('scroll', onScroll, {
                passive: true
            });
            // run once on load
            onScroll();
        })();
    </script>
@endpush

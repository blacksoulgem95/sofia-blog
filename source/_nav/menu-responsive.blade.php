<nav id="js-nav-menu" class="fixed inset-0 z-50 hidden lg:hidden flex items-center justify-center" aria-modal="true" role="dialog">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="navMenu.toggle()"></div>

    <div class="relative z-10 w-[92%] max-w-sm nes-container is-dark bg-black/90 border-4 border-[var(--color-trans-pink)] p-6 pixel-border">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-[var(--color-retro-green)]">Menu</h2>
            <button class="nes-btn is-error px-3 py-1" onclick="navMenu.toggle()" aria-label="Close menu">✕</button>
        </div>

        <ul class="my-0">
            <li class="mb-2">
                <a
                    title="{{ $page->siteName }} Blog"
                    href="/blog"
                    class="block py-2 text-base no-underline {{ $page->isActive('/blog') ? 'active text-[var(--color-trans-pink)]' : 'text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]' }}"
                >Blog</a>
            </li>
            <li class="mb-2">
                <a
                    title="{{ $page->siteName }} About"
                    href="/about"
                    class="block py-2 text-base no-underline {{ $page->isActive('/about') ? 'active text-[var(--color-trans-pink)]' : 'text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]' }}"
                >About</a>
            </li>
            <li>
                <a
                    title="{{ $page->siteName }} Contact"
                    href="https://www.sofiavicedomini.me/contact"
                    target="_blank"
                    class="block py-2 text-base no-underline text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]"
                >Contact</a>
            </li>
        </ul>
    </div>
</nav>

<nav id="js-nav-menu" class="w-auto px-2 pt-6 pb-2 bg-black/70 shadow hidden lg:hidden">
    <ul class="my-0">
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} Blog"
                href="/blog"
                class="block mt-0 mb-4 text-sm no-underline {{ $page->isActive('/blog') ? 'active text-[var(--color-trans-pink)]' : 'text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]' }}"
            >Blog</a>
        </li>
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} About"
                href="/about"
                class="block mt-0 mb-4 text-sm no-underline {{ $page->isActive('/about') ? 'active text-[var(--color-trans-pink)]' : 'text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]' }}"
            >About</a>
        </li>
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} Contact"
                href="https://www.sofiavicedomini.me/contact"
                target="_blank"
                class="block mt-0 mb-4 text-sm no-underline text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]"
            >Contact</a>
        </li>
    </ul>
</nav>

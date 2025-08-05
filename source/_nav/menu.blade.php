<nav class="hidden lg:flex items-center justify-end text-lg">
    <a title="{{ $page->siteName }} Blog" href="/blog"
        class="ml-6 text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)] {{ $page->isActive('/blog') ? 'active text-[var(--color-trans-pink)]' : '' }}">
        Blog
    </a>

    <a title="{{ $page->siteName }} About" href="/about"
        class="ml-6 text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)] {{ $page->isActive('/about') ? 'active text-[var(--color-trans-pink)]' : '' }}">
        About
    </a>

    <a title="{{ $page->siteName }} Contact" href="https://www.sofiavicedomini.me/contact" target="_blank"
        class="ml-6 text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]">
        Contact
    </a>
</nav>

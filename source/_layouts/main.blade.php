<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ? $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="{{ $page->type ?? 'website' }}" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}" />

        <title>{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.ico">
        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        @if ($page->production)
            <!-- Insert analytics code here -->
        @endif

        @viteRefresh()
        <link rel="stylesheet" href="{{ vite('source/_assets/css/main.css') }}">
        <script defer type="module" src="{{ vite('source/_assets/js/main.js') }}"></script>
    </head>

    <body class="flex flex-col justify-between min-h-screen text-white leading-normal font-sans bg-sparkly">
        <header class="flex items-center bg-black/70 border-b-4 border-[var(--color-trans-pink)] h-24 py-4" role="banner">
            <div class="container flex items-center max-w-8xl mx-auto px-4 lg:px-8">
                <div class="flex items-center">
                    <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                        <img class="h-8 md:h-10 mr-3 border-blue-500 border-2 rounded-full" src="/assets/img/sofia-pfp.webp" alt="{{ $page->siteName }} logo" />

                        <h1 class="text-lg md:text-2xl text-[var(--color-trans-white)] font-extrabold my-0">{{ $page->siteName }}</h1>
                    </a>
                </div>

                <div id="vue-search" class="flex flex-1 justify-end items-center bg-transparent">
                    @include('_components.search')

                    @include('_nav.menu')

                    @include('_nav.menu-toggle')
                </div>
            </div>
        </header>

        @include('_nav.menu-responsive')

        <main role="main" class="flex-auto w-full container max-w-4xl mx-auto border-x-4 border-b-4 border-[var(--color-trans-pink)] px-8 py-12 my-8 bg-black/70">
            @yield('body')
        </main>

        <footer class="bg-black/70 text-center text-sm mt-12 py-4 border-t-4 border-[var(--color-trans-pink)]" role="contentinfo">
            <ul class="flex flex-col md:flex-row justify-center list-none">
                <li class="md:mr-2">
                    &copy; <a href="https://tighten.co" title="Tighten website" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-white)]">Tighten</a> {{ date('Y') }}.
                </li>

                <li>
                    Built with <a href="http://jigsaw.tighten.co" title="Jigsaw by Tighten" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-white)]">Jigsaw</a>
                    and <a href="https://tailwindcss.com" title="Tailwind CSS, a utility-first CSS framework" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-white)]">Tailwind CSS</a>.
                </li>
            </ul>
        </footer>

        @include('_components.toaster')

        @stack('scripts')
    </body>
</html>

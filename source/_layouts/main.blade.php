<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        @php
            $seoTitle = ($page->title ? $page->title . ' | ' : '') . $page->siteName;
            $seoDescription = $page->description ?? $page->siteDescription;
            $imageCandidate = $page->cover_image ?? '/apple-touch-icon.png';
            $seoImage = preg_match('/^https?:\/\//', $imageCandidate) ? $imageCandidate : rtrim($page->baseUrl, '/') . $imageCandidate;
        @endphp

        <meta name="description" content="{{ $seoDescription }}">
        <meta name="robots" content="{{ $page->production ? 'index,follow' : 'noindex,nofollow' }}">
        <link rel="canonical" href="{{ $page->getUrl() }}">

        <meta property="og:site_name" content="{{ $page->siteName }}"/>
        <meta property="og:title" content="{{ $page->title ? $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="{{ $page->type ?? 'website' }}" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $seoDescription }}" />
        <meta property="og:image" content="{{ $seoImage }}" />
        <meta property="og:image:alt" content="{{ $seoTitle }}" />

        @if (($page->type ?? 'website') === 'article')
            <meta property="article:published_time" content="{{ isset($page->date) ? date('c', $page->date) : '' }}" />
            <meta property="article:author" content="{{ $page->author ?? $page->siteAuthor }}" />
        @endif

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ $seoTitle }}" />
        <meta name="twitter:description" content="{{ $seoDescription }}" />
        <meta name="twitter:image" content="{{ $seoImage }}" />
        <meta name="twitter:site" content="@blacksoulgem95" />
        <meta name="twitter:creator" content="@blacksoulgem95" />

        <meta name="author" content="{{ $page->author ?? $page->siteAuthor }}" />

        <title>{{ $seoTitle }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.ico">
        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $page->siteName,
            'url' => rtrim($page->baseUrl, '/'),
            'inLanguage' => 'en',
            'description' => $seoDescription,
            'sameAs' => [
                'https://sofiavicedomini.me',
                'https://linkedin.com/in/sofiavicedomini',
                'https://github.com/blacksoulgem95',
                'https://x.com/blacksoulgem95',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>

        @stack('meta')

        @if ($page->production)
            <!-- Insert analytics code here -->
            <script type="text/javascript" src="//embeds.iubenda.com/widgets/31e362dc-edd8-4952-8f9c-7c6a61a66393.js"></script>

            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6063500575269047"
                    crossorigin="anonymous"></script>
        @endif

        @viteRefresh()
        <link rel="stylesheet" href="{{ vite('source/_assets/css/main.css') }}">
        <script defer type="module" src="{{ vite('source/_assets/js/main.js') }}"></script>
        <style>
        .blink {
            animation: blink 1s steps(2, start) infinite;
        }
        @keyframes blink {
            to { visibility: hidden; }
        }
        .retro-header {
            text-shadow: 0 0 5px lime, 0 0 10px cyan;
        }
        .pixelated {
            image-rendering: pixelated;
        }
        </style>
    </head>

    <body class="flex flex-col justify-between items-center min-h-screen text-white leading-normal font-sans bg-sparkly">
        <header class="nes-container is-dark flex items-center bg-black/70 border-b-4 border-[var(--color-trans-pink)] md:h-24 py-4 retro-header pixel-border" role="banner" style="background-image: url('https://example.com/retro-bg.gif'); background-repeat: repeat; font-family: 'Comic Sans MS', cursive; color: lime; text-align: center;">
            <div class="container flex flex-col md:flex-row items-start md:items-center justify-between max-w-8xl mx-auto px-4 lg:px-8 gap-2">
                <div class="flex items-center">
                    <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                        <img class="h-8 md:h-10 mr-3 border-blue-500 border-2 rounded-full pixelated" src="/assets/img/sofia-pfp.webp" alt="{{ $page->siteName }} logo" style="image-rendering: pixelated;" />

                        <marquee behavior="alternate" scrollamount="3"><h1 class="text-lg md:text-2xl text-[var(--color-trans-white)] font-extrabold my-0 blink" style="animation: blink 1s steps(2, start) infinite;">{{ $page->siteName }}</h1></marquee>
                    </a>
                </div>

                <div id="vue-search" class="flex w-full md:flex-1 md:justify-end justify-center items-center bg-transparent mt-2 md:mt-0">
                    @include('_components.search')

                    @include('_nav.menu')

                    @include('_nav.menu-toggle')
                </div>
            </div>
        </header>

        @include('_nav.menu-responsive')

        <main role="main" class="nes-container is-dark is-rounded flex-auto w-full max-w-4xl mx-auto border-x-4 border-b-4 border-[var(--color-trans-pink)] px-8 py-12 mb-8 bg-black/70 pixel-border">
            @yield('body')
        </main>

        <footer class="nes-container is-dark is-rounded retro-footer bg-black/70 text-center text-sm mt-12 py-8 border-t-4 border-[var(--color-trans-pink)] pixel-border" role="contentinfo">
            <div class="container max-w-4xl mx-auto px-4">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-[var(--color-retro-green)] mb-4 retro-text-glow pixel-border">Sofia Vicedomini</h3>
                    <p class="text-[var(--color-trans-white)] mb-2">Full Stack Developer & Tech Professional</p>
                    <p class="text-[var(--color-retro-gray)] text-xs">Available for remote opportunities across Europe</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4 mb-6">
                    <a href="https://sofiavicedomini.me"
                       class="retro-badge text-[var(--color-retro-green)] hover:text-[var(--color-trans-pink)] inline-flex items-center gap-2"
                       title="Sofia's Portfolio" target="_blank" rel="noopener">
                        <i class="nes-icon star"></i> PORTFOLIO
                    </a>
                    <a href="https://linkedin.com/in/sofiavicedomini"
                       class="retro-badge text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)] inline-flex items-center gap-2"
                       title="LinkedIn Profile" target="_blank" rel="noopener">
                        <i class="nes-icon linkedin"></i> LINKEDIN
                    </a>
                    <a href="https://github.com/blacksoulgem95"
                       class="retro-badge text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)] inline-flex items-center gap-2"
                       title="GitHub Profile" target="_blank" rel="noopener">
                        <i class="nes-icon github"></i> GITHUB
                    </a>
                    <a href="https://x.com/blacksoulgem95"
                       class="retro-badge text-[var(--color-retro-yellow)] hover:text-[var(--color-trans-pink)] inline-flex items-center gap-2"
                       title="X (Twitter) Profile" target="_blank" rel="noopener">
                        <i class="nes-icon twitter"></i> X
                    </a>
                </div>

                <div class="border-t-2 border-[var(--color-retro-gray)] pt-4 mt-6">
                    <div class="flex flex-col md:flex-row justify-center items-center gap-2 text-xs text-[var(--color-retro-gray)]">
                        <div>&copy; {{ date('Y') }} Sofia Vicedomini. All rights reserved.</div>
                        <div class="hidden md:block">•</div>
                        <div>
                            Built with
                            <a href="http://jigsaw.tighten.co" title="Jigsaw by Tighten" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)]">Jigsaw</a>
                            &
                            <a href="https://tailwindcss.com" title="Tailwind CSS" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)]">Tailwind CSS</a>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col md:flex-row justify-center items-center gap-2 text-xs">
                    <a href="https://www.iubenda.com/privacy-policy/17758942" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe" title="Privacy Policy">Privacy Policy</a>
                    <span class="hidden md:block">•</span>
                    <a href="https://www.iubenda.com/privacy-policy/17758942/cookie-policy" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe" title="Cookie Policy">Cookie Policy</a>
                </div>

                @if ($page->production)
                    <script type="text/javascript">
                        (function (w,d) {
                            var loader = function () {
                                var s = d.createElement("script"),
                                    tag = d.getElementsByTagName("script")[0];
                                s.src = "https://cdn.iubenda.com/iubenda.js";
                                tag.parentNode.insertBefore(s, tag);
                            };
                            if (w.addEventListener) {
                                w.addEventListener("load", loader, false);
                            } else if (w.attachEvent) {
                                w.attachEvent("onload", loader);
                            } else {
                                w.onload = loader;
                            }
                        })(window, document);
                    </script>
                @endif
            </div>
        </footer>

        @include('_components.toaster')

        @stack('scripts')
    </body>
</html>

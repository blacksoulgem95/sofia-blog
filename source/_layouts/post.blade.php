@extends('_layouts.main')

@php
    $page->type = 'article';
@endphp

@push('meta')
    @php
        $imageCandidate = $page->cover_image ?? '/apple-touch-icon.png';
        $seoImage = preg_match('/^https?:\/\//', $imageCandidate) ? $imageCandidate : rtrim($page->baseUrl, '/') . $imageCandidate;

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $page->title,
            'description' => $page->description ?? $page->getExcerpt(200),
            'image' => $seoImage,
            'author' => [
                '@type' => 'Person',
                'name' => $page->author ?? $page->siteAuthor,
            ],
            'datePublished' => isset($page->date) ? date('c', $page->date) : null,
            'dateModified' => isset($page->updated) ? date('c', $page->updated) : (isset($page->date) ? date('c', $page->date) : null),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $page->getUrl(),
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode(array_filter($jsonLd), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('body')
    <div class="container is-dark is-rounded mx-auto max-w-3xl w-full px-4 text-left prose prose-invert prose-a:text-[var(--color-trans-pink)]">

        @if ($page->cover_image)
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
        @endif

        <h1 class="leading-none mb-2 retro-text-glow border-b-4 text-[var(--color-retro-green)]">{{ $page->title }}</h1>

        <p class="text-[var(--color-trans-white)] text-xl md:mt-0 retro-text-glow">{{ $page->author }}
            • {{ date('F j, Y', $page->date) }}</p>

        @if ($page->categories)
            @foreach ($page->categories as $i => $category)
                <a
                        href="{{ '/blog/categories/' . $category }}"
                        title="View posts in {{ $category }}"
                        class="inline-block bg-[var(--color-retro-dark)] hover:bg-[var(--color-trans-pink)] leading-loose tracking-wide text-[var(--color-trans-white)] uppercase text-xs font-semibold rounded-sm mr-4 px-3 pt-px pixel-border retro-text-glow"
                >{{ $category }}</a>
            @endforeach
        @endif

        <div class="border-b mb-10 pb-4" v-pre>
            @yield('content')
        </div>

        <div class="border-b mb-10 pb-4" v-pre>
            @include('_components.gravatar-hovercard')
        </div>

        <nav class="flex flex-col items-center justify-between text-sm md:text-base pixel-border p-4">
            <div>
                @if ($next = $page->getNext())
                    <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}" class="retro-button">
                        &LeftArrow; {{ $next->title }}
                    </a>
                @endif
            </div>

            <div>
                @if ($previous = $page->getPrevious())
                    <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}" class="retro-button">
                        {{ $previous->title }} &RightArrow;
                    </a>
                @endif
            </div>
        </nav>

    </div>
@endsection

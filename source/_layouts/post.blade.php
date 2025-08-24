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

        <h1 class="leading-none mb-2 border-b-4 text-white font-black" style="text-shadow: 0 0 10px var(--color-retro-green), 0 0 15px var(--color-retro-green), 2px 2px 0 var(--color-trans-pink), 3px 3px 0 var(--color-trans-light-blue); border-image: linear-gradient(to right, var(--color-retro-green), var(--color-trans-pink)) 1;">{{ $page->title }}</h1>

        <p class="text-white text-xl md:mt-0 font-bold" style="text-shadow: 0 0 8px var(--color-trans-light-blue), 1px 1px 0 var(--color-trans-pink);">{{ $page->author }}
            • {{ date('F j, Y', $page->date) }}</p>

        @if ($page->categories)
            @foreach ($page->categories as $i => $category)
                <a
                        href="{{ '/blog/categories/' . $category }}"
                        title="View posts in {{ $category }}"
                        class="inline-block bg-[var(--color-retro-dark)] hover:bg-[var(--color-trans-pink)] leading-loose tracking-wide text-white uppercase text-xs font-bold rounded-sm mr-4 px-3 pt-px pixel-border"
                        style="text-shadow: 0 0 5px var(--color-retro-yellow); box-shadow: 0 0 8px var(--color-trans-pink);"
                >{{ $category }}</a>
            @endforeach
        @endif

        <div class="border-b mb-10 pb-4" v-pre>
            @yield('content')
        </div>

        <div class="border-b mb-10 pb-4" v-pre>
            @include('_components.gravatar-hovercard')
        </div>

        <nav class="flex flex-col gap-4 text-sm md:text-base pixel-border p-4 bg-black/50">
            @if ($next = $page->getNext())
                <div class="w-full">
                    <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}" class="retro-button text-white font-bold block w-full text-center" style="text-shadow: 0 0 8px var(--color-retro-yellow), 1px 1px 0 var(--color-trans-pink); box-shadow: 0 0 10px var(--color-trans-light-blue); overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; hyphens: auto; white-space: normal; display: flex; align-items: center; justify-content: center; min-height: 60px;">
                        <span class="inline-block mr-2">&LeftArrow;</span>
                        <span class="inline-block">{{ $next->title }}</span>
                    </a>
                </div>
            @endif

            @if ($previous = $page->getPrevious())
                <div class="w-full">
                    <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}" class="retro-button text-white font-bold block w-full text-center" style="text-shadow: 0 0 8px var(--color-retro-yellow), 1px 1px 0 var(--color-trans-pink); box-shadow: 0 0 10px var(--color-trans-light-blue); overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; hyphens: auto; white-space: normal; display: flex; align-items: center; justify-content: center; min-height: 60px;">
                        <span class="inline-block">{{ $previous->title }}</span>
                        <span class="inline-block ml-2">&RightArrow;</span>
                    </a>
                </div>
            @endif
        </nav>

    </div>
@endsection

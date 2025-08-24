@extends('_layouts.main')

@push('meta')
    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $page->title,
            'description' => $page->description ?? ('Posts in ' . $page->title),
            'url' => $page->getUrl(),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('body')
    <div class="nes-container is-dark is-rounded text-center">

        <h1 class="retro-text-glow pixel-border border-b-4 text-[var(--color-retro-green)] mb-6">{{ $page->title }}</h1>

        <div class="text-2xl pixel-border border-b mb-6 pb-10 retro-text-glow text-[var(--color-trans-white)]">
            @yield('content')
        </div>

        @foreach ($page->posts($posts) as $post)
            @include('_components.post-preview-inline')

            @if (! $loop->last)
                <hr class="w-full pixel-border mt-2 mb-6">
            @endif
        @endforeach

        @include('_components.newsletter-signup')
    </div>
@stop

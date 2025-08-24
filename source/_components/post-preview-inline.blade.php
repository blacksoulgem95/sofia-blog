<div class="flex flex-col h-full mb-4">
    <p class="text-gray-400 font-medium my-2">
        {{ $post->getDate()->format('F j, Y') }}
    </p>

    <h2 class="text-3xl mt-0">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="text-[var(--color-trans-white)] font-extrabold"
        >{{ $post->title }}</a>
    </h2>

    <p class="mb-4 mt-2 pt-2 text-gray-300">{!! $post->getExcerpt(200) !!}</p>

    <a
        href="{{ $post->getUrl() }}"
        title="Read more - {{ $post->title }}"
        class="uppercase font-semibold tracking-wide mb-2 underline text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)] mt-auto block"
    >Read</a>
</div>

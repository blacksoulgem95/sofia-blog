<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<rss version="2.0">
    <channel>
        <title>{{ $page->siteName }}</title>
        <link>{{ rightTrimPath($page->baseUrl) }}/{{ $page->site_path }}</link>
        <description>{{ $page->siteDescription }}</description>
        <language>en</language>
        <lastBuildDate>{{ date(DATE_RSS) }}</lastBuildDate>
        @yield('entries')
    </channel>
</rss>

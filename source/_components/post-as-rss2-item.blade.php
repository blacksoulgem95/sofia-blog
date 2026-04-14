<item>
    <title><![CDATA[{{ $entry->title }}]]></title>
    <link>{{ $entry->getUrl() }}</link>
    <guid>{{ $entry->getUrl() }}</guid>
    <pubDate>{{ date(DATE_RSS, $entry->date) }}</pubDate>
    <description><![CDATA[{!! $entry->getExcerpt() !!}]]></description>
</item>

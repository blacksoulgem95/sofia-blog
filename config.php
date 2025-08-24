<?php

use Illuminate\Support\Str;

return [
    "baseUrl" => "",
    "production" => false,
    "siteName" => 'Sofia\'s Blog',
    "siteDescription" => "The Little Web Corner of Sofia Vicedomini",
    "siteAuthor" => "Sofia Vicedomini",
    "brevo_form_action" => "https://2df94f02.sibforms.com/serve/MUIFABEuu287s0js3XUQbPXGWdLHeVSQJAilWNX0hjZRj3gZrCCA5BXf7jixDBGtEr-yRNV8joHA3uvHJ9EEeTPf4AEWjI6we0umdIswpLxf5nge6stb0qleX2zASRJb-IV7rAPxjKhNxUAxh8gCvKZkYdfoYELOAGcwwmU5PDwEWXtK7m6B27JZkv1p2XlmL-7-kow-Q69PyWBy", // Hosted Brevo form action
    "turnstile_site_key" => "0x4AAAAAABiH0qGq8eNIC4nj", // Cloudflare Turnstile site key
    "turnstile_language" => "it", // Turnstile language

    // collections
    "collections" => [
        "posts" => [
            "author" => "Sofia Vicedomini", // Default author, if not provided in a post
            "sort" => "-date",
            "path" => "blog/{filename}",
        ],
        "categories" => [
            "path" => "/blog/categories/{filename}",
            "posts" => function ($page, $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->categories
                        ? in_array(
                            $page->getFilename(),
                            $post->categories,
                            true,
                        )
                        : false;
                });
            },
        ],
    ],

    // helpers
    "getDate" => function ($page) {
        return Datetime::createFromFormat("U", $page->date);
    },
    "getExcerpt" => function ($page, $length = 255) {
        if ($page->excerpt) {
            return $page->excerpt;
        }

        $content = preg_split("/<!-- more -->/m", $page->getContent(), 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(
                    ["/<pre>[\w\W]*?<\/pre>/", "/<h\d>[\w\W]*?<\/h\d>/"],
                    "",
                    $content[0],
                ),
                "<code>",
            ),
        );

        if (count($content) > 1) {
            return $cleaned;
        }

        $truncated = substr($cleaned, 0, $length);

        if (
            substr_count($truncated, "<code>") >
            substr_count($truncated, "</code>")
        ) {
            $truncated .= "</code>";
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', "", $truncated) . "..."
            : $cleaned;
    },
    "isActive" => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
];

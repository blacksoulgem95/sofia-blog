---
title: About
description: A little bit about the site
---
@extends('_layouts.main')

@section('body')
    <h1>About</h1>

    <img src="/assets/img/sofia-pfp.webp"
        alt="About image"
        class="flex rounded-full h-64 w-64 bg-contain mx-auto md:float-right my-6 md:ml-10">

    <p class="mb-6">Hi there! I'm Sofia Vicedomini, a dedicated software engineering consultant with a passion for building innovative, accessible solutions in a fully remote environment. Based in the EMEA region, I work as a Full-Stack Senior Software Engineer specializing in EU/US/CA/UK markets.</p>

    <p class="mb-6">When I'm not crafting code, you'll find me exploring the world through adventure travel, experimenting with artificial intelligence, or unwinding with action video games. I'm fascinated by the intersection of technology and education, and I love sharing knowledge about software engineering, history, and investing.</p>

    <p class="mb-6">I'm a native Italian speaker with C1 proficiency in English and B1 level French. Whether you're looking for technical consulting, want to collaborate on a project, or just want to chat about the latest in tech, feel free to reach out through any of my social channels!</p>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3">Find me online:</h3>
        <ul class="list-disc list-inside space-y-1">
            <li><a href="https://github.com/blacksoulgem95" class="text-blue-500 hover:underline">GitHub</a> - Check out my code</li>
            <li><a href="https://www.linkedin.com/in/sofiavicedomini" class="text-blue-500 hover:underline">LinkedIn</a> - Professional networking</li>
            <li><a href="https://x.com/blacksoulgem95" class="text-blue-500 hover:underline">X (Twitter)</a> - Tech thoughts and updates</li>
            <li><a href="https://stackoverflow.com/users/21117356/sofia-vicedomini" class="text-blue-500 hover:underline">Stack Overflow</a> - Helping the community</li>
            <li><a href="https://twitch.tv/blacksoulgem95" class="text-blue-500 hover:underline">Twitch</a> - Gaming and coding streams</li>
            <li><a href="https://www.youtube.com/channel/UCupNJgTvn7yxwCFHIK2IzDA" class="text-blue-500 hover:underline">YouTube</a> - Educational content</li>
        </ul>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3">Support my work:</h3>
        <ul class="list-disc list-inside space-y-1">
            <li><a href="https://ko-fi.com/blacksoulgem95" class="text-blue-500 hover:underline">Ko-Fi</a> - Buy me a pizza slice</li>
            <li><a href="https://revolut.me/sofiavicedomini" class="text-blue-600 hover:underline">Revolut</a> - Quick payments</li>
            <li>Bitcoin: <code class="text-sm text-white bg-gray-800 px-1 rounded cursor-pointer hover:bg-gray-700 transition-colors" onclick="copyBitcoinAddress()" id="bitcoin-address">bc1q4wndp7sqy5l68yp0w67lnl96s4vug2xujjk300</code></li>
        </ul>
    </div>

<script>
    function copyBitcoinAddress() {
        const bitcoinAddress = document.getElementById('bitcoin-address').textContent;
        navigator.clipboard.writeText(bitcoinAddress).then(function() {
            toast.success('Bitcoin address copied to clipboard!');
        }).catch(function(err) {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = bitcoinAddress;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            toast.success('Bitcoin address copied to clipboard!');
        });
    }
</script>
@endsection

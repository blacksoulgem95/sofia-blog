---
title: About me
description: I'm Sofia Vicedomini, a dedicated software engineering consultant with a passion for building innovative, accessible solutions in a fully remote environment.
---
@extends('_layouts.main')

@section('body')
    <h1>About</h1>

    <img src="/assets/img/sofia-pfp.webp"
        alt="About image"
        class="flex rounded-full h-64 w-64 bg-contain mx-auto md:float-right my-6 md:ml-10">

    <p class="mb-6">Hi there! I'm Sofia Vicedomini, a dedicated software engineering consultant with a passion for building innovative, accessible solutions in a fully remote environment. Based in the EMEA region, I work as a Full-Stack Senior Software Engineer specializing in EU/US/CA/UK markets.</p>

    <p class="mb-6">When I'm not crafting code, you'll find me exploring the world through adventure travel, experimenting with artificial intelligence, or unwinding with action video games. As a self-proclaimed gamer and nerd, my journey into gaming started with Prince of Persia by Jordan Mechner on DOS, and I've been passionate about platformers and RPGs ever since. I'm fascinated by the intersection of technology and education, and I love sharing knowledge about software engineering, history, and investing.</p>

    <p class="mb-6">I'm a native Italian speaker with C1 proficiency in English and B1 level French. Whether you're looking for technical consulting, want to collaborate on a project, or just want to chat about the latest in tech, feel free to reach out through any of my social channels!</p>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3">Find me online:</h3>
        <ul class="retro-list space-y-3">
            <li class="flex items-center gap-3"><i class="nes-icon star"></i><a href="https://sofiavicedomini.me" class="text-[var(--color-retro-green)] hover:text-[var(--color-trans-pink)]" target="_blank" rel="noopener">Portfolio</a> - My complete professional portfolio</li>
            <li class="flex items-center gap-3"><i class="nes-icon github"></i><a href="https://github.com/blacksoulgem95" class="text-[var(--color-trans-white)] hover:text-[var(--color-trans-pink)]">GitHub</a> - Check out my code</li>
            <li class="flex items-center gap-3"><i class="nes-icon linkedin"></i><a href="https://www.linkedin.com/in/sofiavicedomini" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)]">LinkedIn</a> - Professional networking</li>
            <li class="flex items-center gap-3"><i class="nes-icon twitter"></i><a href="https://x.com/blacksoulgem95" class="text-[var(--color-trans-light-blue)] hover:text-[var(--color-trans-pink)]">X (Twitter)</a> - Tech thoughts and updates</li>
            <li class="flex items-center gap-3"><i class="nes-icon trophy"></i><a href="https://stackoverflow.com/users/21117356/sofia-vicedomini" class="text-[var(--color-retro-yellow)] hover:text-[var(--color-trans-pink)]">Stack Overflow</a> - Helping the community</li>
            <li class="flex items-center gap-3"><i class="nes-icon twitch"></i><a href="https://twitch.tv/blacksoulgem95" class="text-[var(--color-trans-pink)] hover:text-[var(--color-retro-green)]">Twitch</a> - Gaming and coding streams</li>
            <li class="flex items-center gap-3"><i class="nes-icon youtube"></i><a href="https://www.youtube.com/channel/UCupNJgTvn7yxwCFHIK2IzDA" class="text-[var(--color-retro-red)] hover:text-[var(--color-trans-pink)]">YouTube</a> - Educational content</li>
        </ul>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3 text-[var(--color-retro-green)]">Support my work:</h3>
        <ul class="retro-list space-y-3">
            <li class="flex items-center gap-3"><i class="nes-icon coin"></i><a href="https://ko-fi.com/blacksoulgem95" class="text-[var(--color-retro-yellow)] hover:text-[var(--color-trans-pink)]">Ko-Fi</a> - Buy me a pizza slice</li>
            <li class="flex items-center gap-3"><i class="nes-icon coin"></i><a href="https://revolut.me/sofiavicedomini" class="text-[var(--color-retro-green)] hover:text-[var(--color-trans-pink)]">Revolut</a> - Quick payments</li>
            <li class="flex items-center gap-3"><i class="nes-icon coin"></i>Bitcoin: <code class="text-sm text-[var(--color-retro-green)] bg-black border-2 border-[var(--color-trans-light-blue)] px-2 py-1 cursor-pointer hover:bg-[var(--color-retro-dark)] transition-colors font-mono" onclick="copyBitcoinAddress()" id="bitcoin-address">bc1q4wndp7sqy5l68yp0w67lnl96s4vug2xujjk300</code></li>
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

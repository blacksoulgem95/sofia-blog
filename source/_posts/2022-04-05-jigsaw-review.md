---
extends: _layouts.post
section: content
title: Building Static Sites with Jigsaw – Honest Review & GitHub Deploy Setup
date: 2022-04-05
description: A hands-on review of Jigsaw, the Laravel-based static site generator. Use cases, real-world setup, GitHub Actions deploy, and why I moved away from WordPress.
cover_image: /assets/img/post-cover-image-33.png
featured: false
categories: [static websites, jigsaw, laravel, blade, github, github pages, TailwindCSS, markdown, blog, databaseless, devtools, Frontend, deployment automation]
---

<p><strong>Jigsaw</strong> is a static site generator built on top of Laravel's Blade templating engine and Laravel Mix. And here’s the thing: this blog is built with it.</p>

<blockquote><p><strong>Author’s Note:</strong> This blog was proudly built with <strong>Jigsaw</strong> in 2022… and then inevitably torn down and rebuilt with <a href="/work/personal-website"><strong>Next.js</strong> and headless Drupal</a>, because I apparently can’t stop reinventing my own website every time a new tech stack catches my eye. Consider this article a nostalgic look into one of those beautiful, fleeting architectural phases.</p></blockquote>

### What is Jigsaw good for?

<p>Jigsaw shines when you want a site that’s fast, secure, and database-free. Here are the use cases I think it nails:</p>

<ul>
  <li><strong>Portfolio sites</strong>: Static = blazing fast. I use it for my own “Projects” section.</li>
  <li><strong>Markdown-powered blogs</strong>: You can structure posts and categories using collections, write in Markdown, and let Jigsaw compile everything beautifully.</li>
  <li><strong>Company landing pages</strong>: Most companies don’t need a CMS or dynamic backend. A static site with a form (even via Typeform) does the job.</li>
</ul>

<p>For more real-life examples, check out the <a href="https://jigsaw.tighten.com/#built-with-jigsaw" target="_blank" rel="noopener">Built with Jigsaw showcase</a>.</p>

### Why I migrated from WordPress

<p>I spent a weekend migrating this site from WordPress to Jigsaw, and honestly? It felt like a breath of fresh air. I got rid of a bloated backend and ended up with something leaner, faster, and much easier to style with <strong>Tailwind CSS</strong>.</p>

<p>Blade templates made layout creation smooth, and since I already knew Laravel, the learning curve was almost flat. Jigsaw also comes with great starter templates and is fully customizable out of the box.</p>

### Deployment with GitHub Actions

<p>Jigsaw builds everything statically, so I automated deployment using GitHub Actions. The process:</p>

<ol>
  <li>Push to the <code>main</code> branch</li>
  <li>GitHub Action runs <code>npm run prod</code></li>
  <li>Build is moved from <code>/build_production</code> to <code>/docs</code></li>
  <li>The <code>docs</code> folder is pushed to a branch called <code>live</code></li>
</ol>

<p>GitHub Pages is configured to serve the site from that <code>live</code> branch's <code>/docs</code> directory.</p>

<p>And yes – don’t forget to include a <code>CNAME</code> file in the build to keep your custom domain settings intact.</p>

### Final Thoughts

<p>Working with Jigsaw has been a joy. It’s simple, fast, and powerful enough for real-world use. If you’re tired of WordPress, or just want a smooth, modern stack for your personal site or blog, I wholeheartedly recommend giving Jigsaw a shot.</p>

### Files required to deploy on GitHub Pages

#### CNAME file

<p><code>/source/CNAME.blade.php</code></p>

<p><strong>Content:</strong></p>

```text
---
permalink: CNAME
---
italianprogrammer.pizza
```

#### Workflow file

<p><code>/.github/workflows/build-docs.yml</code></p>

<p><strong>Content:</strong></p>

```yaml
on:
  push:
    branches:
      - 'main'
name: deploy
jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v1
        with:
          fetch-depth: 1
      - name: Setup PHP Action
        uses: shivammathur/setup-php@2.17.0
      - uses: actions/setup-node@v2
        with:
          node-version: '16'
      - name: Install dependencies
        run: |
          sudo apt update && sudo apt install git zip unzip -y
          git config --global user.email "41898282+github-actions[bot]@users.noreply.github.com"
          git config --global user.name "GitHubActions BOT"
          composer update --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
          composer install --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
          npm install
      - name: Build the site
        run: npm run prod
      - name: deploy
        run: |
          if [ -d "./docs" ]; then rm -Rf ./docs; fi
          mv ./build_production ./docs
          git add ./docs
          git commit -m "Deployment of website - $(date)"
      - name: Push changes
        uses: ad-m/github-push-action@master
        with:
          github_token: ${{ secrets.DEPLOY_SECRET }}
          branch: live
          force: true
```
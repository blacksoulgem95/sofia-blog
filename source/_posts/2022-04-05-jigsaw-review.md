---
extends: _layouts.post
section: content
title: Building Static Sites with Jigsaw – Honest Review & GitHub Deploy Setup (2025 Update)
date: 2022-04-05
description: A hands-on review of Jigsaw, the Laravel-based static site generator. Use cases, real-world setup, GitHub Actions deploy, and why I returned to Jigsaw after trying other solutions.
cover_image: /assets/images/jigsaw.png
featured: false
categories: [ static websites, jigsaw, laravel, blade, github, github pages, TailwindCSS, markdown, blog, databaseless, devtools, Frontend, deployment automation, vite, jamstack ]
---

**Jigsaw** is a static site generator built on top of Laravel's Blade templating engine and Laravel Mix. And here’s the
thing: this blog is built with it.

> **2024 Author’s Note:** This blog was proudly built with **Jigsaw** in 2022… and then inevitably torn down and rebuilt
> with **Next.js** and headless **Drupal**, because I apparently can’t stop reinventing my own website every time a new
> tech stack catches my eye. Consider this article a nostalgic look into one of those beautiful, fleeting architectural
> phases.

> **2025 Author's Note:** Well well well, I redid it in Jigsaw again, as it is more efficient, fast, cheap and easy to
> maintain.

### What is Jigsaw good for?

Jigsaw shines when you want a site that’s fast, secure, and database-free. Here are the use cases I think it nails:

* **Portfolio sites**: Static = blazing fast. I use it for my own “Projects” section.
* **Markdown-powered blogs**: You can structure posts and categories using collections, write in Markdown, and let
  Jigsaw compile everything beautifully.
* **Company landing pages**: Most companies don’t need a CMS or dynamic backend. A static site with a form (even via
  Typeform) does the job.
* **Technical documentation**: Perfect for project documentation with native code highlighting support.

For more real-life examples, check out the [Built with Jigsaw showcase](https://jigsaw.tighten.com/#built-with-jigsaw).

### Why I migrated from WordPress

I spent a weekend migrating this site from WordPress to Jigsaw, and honestly? It felt like a breath of fresh air. I got
rid of a bloated backend and ended up with something leaner, faster, and much easier to style with **Tailwind CSS**.

Blade templates made layout creation smooth, and since I already knew Laravel, the learning curve was almost flat.
Jigsaw also comes with great starter templates and is fully customizable out of the box.

In 2025, when I decided to rebuild the site with Jigsaw again, the experience was even smoother thanks to the
integration with **Vite** instead of Laravel Mix, offering much faster compilation times and an improved development
experience with hot module replacement (HMR).

### Deployment with GitHub Actions

Jigsaw generates everything statically, so I automated deployment using GitHub Actions. The updated process in 2025:

1. Push to the `main` branch
2. GitHub Action runs `npm run build` (which uses Vite instead of Laravel Mix)
3. The build output is uploaded as an artifact
4. The artifact is downloaded and published directly to the `live` branch

GitHub Pages is configured to serve the site from the `live` branch.

Using GitHub Actions artifacts allows for a cleaner and more reliable deployment process, eliminating the need to manage
the `/docs` directory and preventing potential merge conflicts.

And yes – don’t forget to include a `CNAME` file in the build to keep your custom domain settings intact.

### Final Thoughts

Working with Jigsaw has been a joy. It’s simple, fast, and powerful enough for real-world use. If you’re tired of
WordPress, or just want a smooth, modern stack for your personal site or blog, I wholeheartedly recommend giving Jigsaw
a shot.

### Files required to deploy on GitHub Pages #### CNAME file

`/source/CNAME.blade.php`

**Content:**

```text 
permalink: CNAME 
blog.sofiavicedomini.me
``` 

#### Workflow file

`/.github/workflows/build-docs.yml`

**Content:**

```yaml
# Workflow: deploys a static site to GitHub Pages by publishing to the "live" branch
name: Deploy to GitHub Pages (live)

# Triggers:
# - on push to "main" (automatic deploy)
# - manual run via "workflow_dispatch"
on:
  push:
    branches:
      - main
  workflow_dispatch:

# Prevent concurrent deploy runs; cancel any that are still in progress
concurrency:
  group: pages-deploy
  cancel-in-progress: true

# Default GITHUB_TOKEN permissions at workflow level (jobs can override)
permissions:
  contents: write

jobs:
  build:
    name: Build site
    runs-on: ubuntu-latest
    permissions:
      contents: read
    # Build job: prepare dependencies, compile assets, and generate the static site

    steps:
      - name: Checkout
        uses: actions/checkout@v4
        # Check out the repository source at the current commit

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          coverage: none
          extensions: mbstring, intl, dom, json, libxml, curl, openssl, zip
        # Set up PHP with required extensions for build tools (e.g., Jigsaw/Laravel)

      - name: Cache Composer
        uses: actions/cache@v4
        with:
          path: ~/.composer/cache/files
          key: composer-${{ hashFiles('**/composer.lock') }}
          restore-keys: composer-
        # Speed up Composer installs by reusing downloaded packages

      - name: Install Composer dependencies
        run: composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader
        # Install PHP dependencies in a reproducible and quiet way

      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: 'npm'
        # Install Node.js and enable npm caching to speed up "npm ci"

      - name: Install Node dependencies
        run: npm ci
        # Clean, lockfile-based install for deterministic builds

      - name: Build frontend assets
        run: npm run build
        # Compile JS/CSS assets with Vite

      - name: Build Jigsaw site (production)
        run: vendor/bin/jigsaw build production
        # Generate the static site in production mode (output in build_production)

      - name: Upload site artifact
        uses: actions/upload-artifact@v4
        with:
          name: site
          path: build_production
          if-no-files-found: error
        # Upload the generated site as an artifact for the deploy job
        # Fail if no files are found, to catch build issues

  deploy:
    name: Deploy to live branch
    needs: build
    runs-on: ubuntu-latest
    permissions:
      contents: write
    # Deploy job: publish the generated files to the "live" branch

    steps:
      - name: Download site artifact
        uses: actions/download-artifact@v4
        with:
          name: site
          path: build_production
        # Download the artifact produced by the build job

      - name: Publish to live
        uses: peaceiris/actions-gh-pages@v4
        with:
          github_token: ${{ github.token }}
          publish_dir: build_production
          publish_branch: live
          force_orphan: true
          cname: blog.sofiavicedomini.me
        # Publish the contents of build_production to the "live" branch
        # force_orphan: create orphan commits to keep the deploy branch history clean
        # cname: automatically set the CNAME file for the custom domain
```
# Sofia's Blog

[![Build](https://github.com/blacksoulgem95/sofia-blog/actions/workflows/deploy.yml/badge.svg)](https://github.com/blacksoulgem95/sofia-blog/actions/workflows/deploy.yml)
![Last Commit](https://img.shields.io/github/last-commit/blacksoulgem95/sofia-blog/main)

My personal blog made with [Jigsaw](https://jigsaw.tighten.com/), a Laravel-based static site generator that combines the power of Blade templates with the simplicity of Markdown.

Hosted at [blog.sofiavicedomini.me](https://blog.sofiavicedomini.me) via **GitHub Pages**.  
Deployment is fully automated through GitHub Actions.

---

## 🚀 Installation

Make sure you have the following installed:

- **PHP 8.4+**
- **Composer**
- **Node.js 20** (see `.nvmrc` for version pinning)
- **npm** or **yarn**

### 1. Clone the repo
```bash
git clone https://github.com/blacksoulgem95/sofia-blog.git
cd sofia-blog
````

### 2. Install dependencies

```bash
composer install
npm ci
```

### 3. Run the development server

```bash
npm run dev
```

This will:

* Compile frontend assets via **Vite**
* Serve the site locally at `http://localhost:8000`

---

## ⚙️ Configuration

* **Site metadata** is defined in `config.php` (and overridden in `config.production.php` for production).
* **Custom domain** is handled via `CNAME` in the repository, ensuring GitHub Pages keeps `blog.sofiavicedomini.me` active.
* **Content** lives in the `source/` folder, written in Markdown with optional Blade components.

---

## 📦 Building

To generate a production build manually:

```bash
npm run build     # Compile frontend assets
vendor/bin/jigsaw build production
```

The compiled site will be output to the `build_production/` directory.

---

## 🤖 Deployment (Automated)

Every push to the `main` branch triggers the **GitHub Actions workflow** (`.github/workflows/deploy.yml`):

1. Install PHP & Node dependencies
2. Build assets with Vite
3. Build the static site with Jigsaw
4. Deploy the contents of `build_production/` to the `live` branch
5. GitHub Pages serves from the `live` branch with the configured custom domain

You can also trigger deployments manually from the Actions tab in GitHub.

---

## 🛠 Useful Scripts

| Command                   | Description                                     |
| ------------------------- |-------------------------------------------------|
| `npm run dev`             | Run local dev server with hot reload            |
| `npm run build`           | Compile assets                                  |
| `vendor/bin/jigsaw build` | Build the site (use `production` flag for prod) |

---

## 📖 Notes

* Blog posts are written in Markdown inside `source/_posts/`.
* Blade templates (`source/_layouts/`) control layout and structure.
* Tailwind CSS powers styling (integrated via Vite).
* Deployment is fully hands-off thanks to GitHub Actions.
# CLAUDE.md — Irreversível Magazine Theme

## Project Overview

Custom WordPress theme for **Irreversível Magazine** (irreversivel.pt).
Based on Underscores (_s) starter theme, built by **.peter**.

- **Package name:** `IRREV-MAG`
- **Text domain:** `im`
- **Function prefix:** `irrev_mag_`
- **Constant prefix:** `IRREV_`
- **Version constant:** `IRREV_VERSION`

## Tech Stack

| Layer       | Tool                                    |
|-------------|-----------------------------------------|
| CMS         | WordPress (PHP 8.2)                     |
| CSS         | Tailwind CSS v3 + SASS (Dart Sass)      |
| PostCSS     | Tailwind + Autoprefixer                 |
| Build       | Vite 7                                  |
| Web server  | nginx (LocalWP)                         |
| Database    | MySQL 5.7.28                            |
| Environment | Local by Flywheel (LocalWP)             |
| OS          | Windows 11                              |

## Local Environment

| Setting     | Value                         |
|-------------|-------------------------------|
| Site domain | `irreversvel.digid`           |
| Site URL    | `https://irreversvel.digid`   |
| SSL         | Trusted (`irreversvel.digid.crt`) |
| Vite dev    | `http://localhost:5173`       |

## Project Structure

```
irreversivel/
├── src/
│   ├── js/main.js            # JS entry point (imports SASS)
│   └── sass/
│       ├── main.sass          # SASS entry point (@tailwind + imports)
│       └── _base.sass         # Base styles, CSS variables, theme tokens
├── inc/
│   ├── vite.php               # Vite integration (dev/prod asset loading)
│   ├── template-functions.php  # Body classes, pingback header
│   └── template-tags.php      # Post meta, thumbnails, hero picture
├── template-parts/
│   ├── content.php            # Default post content
│   ├── content-none.php       # No results
│   ├── content-page.php       # Page content
│   └── content-search.php     # Search results
├── page-templates/             # Custom page templates
├── languages/                  # Translation files
├── header.php                  # <head> + site header
├── footer.php                  # Footer + wp_footer()
├── functions.php               # Theme setup, enqueues, includes
├── index.php / single.php / page.php / archive.php / search.php / 404.php
├── sidebar.php / comments.php
├── style.css                   # Theme metadata (required by WP)
├── vite.config.js              # Vite config (plugins, build, server)
├── tailwind.config.js          # Tailwind config (theme, plugins)
├── postcss.config.js           # PostCSS (Tailwind + Autoprefixer)
└── package.json                # Dependencies + browserslist
```

## Development Workflow

### Build Commands

```bash
npm run dev          # Start Vite dev server with HMR + PHP reload
npm run build        # Production build to dist/
```

### Asset Pipeline

1. `src/js/main.js` imports `src/sass/main.sass`
2. `main.sass` loads Tailwind via `@tailwind base/components/utilities` + custom SASS
3. Vite compiles SASS → PostCSS (Tailwind + Autoprefixer) → output
4. Dev: `inc/vite.php` detects `dist/hot` file → loads from `http://localhost:5173`
5. Prod: `inc/vite.php` reads `dist/.vite/manifest.json` → enqueues hashed files

### Adding Styles

- Use **Tailwind utility classes** directly in PHP templates
- For WordPress-generated HTML (menus, comments), use `@apply` in SASS
- Custom styles go in `src/sass/` — import from `main.sass` with `@import`
- CSS custom properties for theming go in `_base.sass`
- `style.css` at root is **metadata only** — do not add styles there

### Adding JavaScript

- Add new JS in `src/js/` and import from `main.js`
- Use vanilla JS — no jQuery dependency unless strictly necessary
- ES6+ syntax (modules, arrow functions, const/let)

### Dark Mode

- Controlled via `dark` class on `<html>` (`darkMode: 'class'` in Tailwind config)
- CSS variables in `_base.sass` define light/dark tokens
- Anti-FOUC script in `header.php` reads `localStorage` before paint
- Toggle button uses `data-theme-toggle` attribute
- Respects `prefers-color-scheme` as default, user override via `localStorage`

## Core Principles

### Performance

- **Always consider page weight.** Minimize HTTP requests, avoid unnecessary assets
- **Lazy load** images below the fold (`loading="lazy"`), hero images use `loading="eager"` + `fetchpriority="high"`
- **Conditional loading:** only enqueue scripts/styles on pages that need them (e.g. CF7 + reCAPTCHA only on pages with forms)
- **Use native WordPress image handling** (`srcset`, `sizes`, `wp_get_attachment_image()`) for responsive images
- **Avoid render-blocking resources.** JS in footer with `type="module"`, critical CSS inline if needed
- **Cache busting** is automatic via Vite's hashed filenames
- **No unused CSS/JS** — Tailwind purges unused classes, keep JS minimal

### Accessibility (WCAG)

- **Semantic HTML** — use correct heading hierarchy (`h1` → `h6`), landmarks (`<main>`, `<nav>`, `<header>`, `<footer>`), and ARIA attributes where needed
- **Skip link** — always present (`<a class="skip-link screen-reader-text">`)
- **Keyboard navigation** — all interactive elements must be focusable and operable via keyboard
- **Alt text** — every `<img>` must have meaningful `alt` (use WordPress attachment alt field)
- **Color contrast** — meet WCAG AA minimum (4.5:1 for text, 3:1 for large text)
- **Focus indicators** — never remove `outline` without providing a visible alternative
- **Screen reader text** — use `.screen-reader-text` (mapped to Tailwind `sr-only`) for visually hidden but accessible content
- **ARIA labels** — on buttons/links that lack visible text (e.g. icon-only toggle)
- **Form labels** — every input must have an associated `<label>`

### SEO

- **Semantic markup** — proper heading hierarchy, structured `<article>`, `<time datetime="">`, `<nav>`
- **One `<h1>` per page** — on homepage it's the site title, on single/page it's the post title
- **`<title>` tag** — managed by WordPress via `add_theme_support( 'title-tag' )`
- **Meta description** — delegate to SEO plugin (Yoast/RankMath), do not hardcode
- **Open Graph / Schema** — delegate to SEO plugin, theme provides clean semantic HTML
- **Canonical URLs** — handled by WordPress core
- **Image alt text** — always populated, descriptive
- **Fast load times** — performance directly impacts SEO ranking
- **Mobile-first** — responsive design, proper viewport meta tag

## Coding Standards

### PHP — PHPCS + WPCS

All PHP code **must** follow:

- **WordPress Coding Standards (WPCS)** via PHP_CodeSniffer
- Ruleset: `WordPress` (includes `WordPress-Core`, `WordPress-Docs`, `WordPress-Extra`)

Key rules to follow:

| Rule | Example |
|------|---------|
| Tabs for indentation | `\t` not spaces |
| Spaces inside parentheses | `function_name( $arg )` not `function_name($arg)` |
| Yoda conditions | `if ( true === $var )` not `if ( $var === true )` |
| Escape all output | `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()` |
| Sanitize all input | `sanitize_text_field()`, `absint()`, `wp_unslash()` |
| Nonce verification | `wp_nonce_field()` / `wp_verify_nonce()` for forms |
| Prefix everything | Functions: `irrev_mag_`, hooks: `irrev_mag_`, constants: `IRREV_` |
| Text domain | Always `'im'` — `esc_html__( 'Text', 'im' )` |
| File docblocks | `@package IRREV-MAG` + `@subpackage` where appropriate |
| Inline comments | `// Single-line.` with period, space after `//` |

### PHP File Template

```php
<?php
/**
 * Description of the file
 *
 * @package IRREV-MAG
 * @subpackage Component-Name
 */

// Code here.
```

### CSS / Tailwind

- Prefer Tailwind utility classes in templates over custom CSS
- Use `@apply` in SASS for WordPress-generated HTML you can't add classes to
- When custom CSS is needed, use BEM naming: `.block__element--modifier`
- Keep `style.css` as metadata only

### JavaScript

- ES6+ syntax (modules, arrow functions, const/let)
- No jQuery unless required by a WP dependency
- Load as `type="module"` in footer

## Theme Conventions

### Template Hierarchy

Follow WordPress template hierarchy strictly:
- `index.php` → fallback
- `single.php` → single posts
- `page.php` → pages
- `archive.php` → archives
- `search.php` → search results
- `404.php` → not found
- `page-templates/` → custom page templates (Template Name header)

### Template Parts

Use `get_template_part()` for reusable components:
```php
get_template_part( 'template-parts/content', get_post_type() );
```

### Registered Locations

- **Nav menu:** `menu-1` (Primary)
- **Sidebar:** `sidebar-1`
- **Custom logo:** 250x250, flex dimensions

### Custom Image Sizes

- `irrev-hero` — 1920×1080 (landscape hero, hard crop)
- `irrev-hero-portrait` — 768×1024 (portrait hero, hard crop)

### Theme Supports

Already registered: `automatic-feed-links`, `title-tag`, `post-thumbnails`, `html5`, `custom-background`, `customize-selective-refresh-widgets`, `custom-logo`.

## Vite Integration

### How it works

- `inc/vite.php` handles all asset loading logic
- **Dev mode:** `dist/hot` file exists → PHP loads scripts from `http://localhost:5173`
- **Production:** `dist/hot` absent → PHP reads `dist/.vite/manifest.json` and enqueues compiled files
- `vite.config.js` has two custom plugins:
  - `wordpressPhpReload` — watches PHP files and triggers browser reload
  - `wordpressHotFile` — creates/removes `dist/hot` file on server start/stop
- Scripts get `type="module" crossorigin` via `script_loader_tag` filter

### Known limitation

- Vite HTTPS disabled due to Node.js 22.x HTTP/2 bug — uses `http://localhost:5173` instead (browsers treat localhost as secure context)

## Known Issues / Tech Debt

- `inc/template-functions.php` still uses `testing_` prefix — needs refactoring
- `header.php` menu toggle button uses text domain `'testing'` instead of `'im'`
- `page-templates/` and `languages/` directories are empty
- No PHPCS config file (`.phpcs.xml.dist`) yet — should be added
- SASS `@import` is deprecated (Dart Sass) — silenced via `silenceDeprecations` in Vite config, works until Dart Sass 3.0

## Do NOT

- Add styles to `style.css` (metadata only)
- Use `$wpdb` directly without `prepare()`
- Output unescaped data — always escape
- Use closing `?>` tag at end of PHP-only files
- Commit `node_modules/` or `dist/` to version control
- Use generic function names — always prefix with `irrev_mag_`
- Remove focus outlines without providing a visible alternative
- Use `display: none` to hide accessible content — use `.screen-reader-text` instead
- Hardcode meta tags for SEO — delegate to SEO plugins
- Load scripts/styles globally when they're only needed on specific pages

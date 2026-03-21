# Irreversível Magazine — WordPress Theme

Custom WordPress theme for [Irreversível Magazine](https://irreversivel.pt), built by **.peter**.

## Tech Stack

- WordPress (PHP 8.2)
- Tailwind CSS v3 + SASS
- Vite 7 (build + HMR)
- GSAP + Lenis (animations + smooth scroll)

## Setup

```bash
npm install
```

## Development

```bash
npm run dev
```

Starts Vite dev server at `http://localhost:5173` with HMR and PHP file reload.

## Production Build

```bash
npm run build
```

Compiles and minifies assets to `dist/`.

## Branching

| Branch | Purpose |
|--------|---------|
| `main` | Production — deployed to live |
| `dev`  | Active development |

Feature workflow: `dev` → PR → `main`.

## License

GPLv2 or later.

Based on [Underscores](https://underscores.me/) by Automattic.

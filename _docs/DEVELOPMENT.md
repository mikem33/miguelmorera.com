# Development Guide

## Branches

This repo uses two branches with different purposes — they are not merged into each other:

- **`develop`** — source files. This is where active development happens.
- **`master`** — compiled/built output. Production-ready files generated from `develop`.

## Develop branch structure

```
src/
├── source/                  # Theme source files (never edit compiled output directly)
│   ├── assets/
│   │   ├── css/styl/        # Stylus stylesheets
│   │   ├── javascript/      # JS source files
│   │   │   ├── compile/     # Files bundled and transpiled via Babel
│   │   │   └── source/      # Files minified individually
│   │   ├── images/          # Images and SVG sprites source
│   │   └── fonts/
│   ├── includes/            # PHP partials (acf-json, page data)
│   ├── functions/           # Theme functions
│   ├── page-templates/      # WordPress page templates
│   └── *.php                # Theme root PHP files
├── content/
│   ├── mu-plugins/          # Must-use plugins (custom post types, etc.)
│   ├── plugins/             # Plugins submodule (private repo)
│   └── uploads -> ../shared/content/uploads  # Symlink
├── wp/                      # WordPress core submodule
├── private/                 # Local config submodule (private repo)
├── shared/                  # Gitignored. Contains persistent files (uploads, etc.)
│   └── content/uploads/
├── gulpfile.js
├── package.json
└── wp-config.php
```

## Submodules

The project has three git submodules:

| Submodule | Repo | Notes |
|-----------|------|-------|
| `wp/` | [github.com/WordPress/WordPress](https://github.com/WordPress/WordPress) | WordPress core |
| `private/` | Private repo (SSH access required) | Local environment config (`private/config.php`) |
| `content/plugins/` | Private repo (SSH access required) | Site plugins |

After cloning, initialise them with:

```bash
git submodule init
git submodule update
```

> SSH key with access to the private Bitbucket repos is required for `private/` and `content/plugins/`.

## Requirements

- Node.js (v18+)
- pnpm
- A local web server (Apache or Nginx) with PHP and MySQL/MariaDB

If `pnpm` is not installed, enable it with Corepack (included with modern Node.js):

```bash
sudo corepack enable
corepack prepare pnpm@latest --activate
```

## Setup

1. Clone the repo and switch to `develop`:
   ```bash
   git clone git@github.com:mikem33/miguelmorera.com.git
   cd <cloned-folder>
   git checkout develop
   ```
2. Initialise submodules (see above):
   ```bash
   git submodule init
   git submodule update
   ```
3. Create the shared uploads directory (gitignored, not cloned):
   ```bash
   mkdir -p shared/content/uploads
   ```
4. Install dependencies:
   ```bash
   pnpm install
   ```
5. Configure your local environment in `private/config.php` (DB credentials, site URL, etc.)

## Gulp tasks

| Task | Description |
|------|-------------|
| `pnpm init` | One-off full compile into `content/themes/prometheus/`. Run this after cloning before starting `watch`. |
| `pnpm watch` | Runs an initial compile, then watches source files and recompiles on change. |
| `pnpm styles` | Compiles Stylus to `content/themes/prometheus/style.css` |
| `pnpm js` | Bundles and transpiles JS via Babel, outputs minified file |
| `pnpm exec gulp js-templates` | Minifies individual JS files |
| `pnpm exec gulp copy-images` | Copies images to theme |
| `pnpm exec gulp svgsprites` | Generates SVG sprite from `source/assets/images/_svg-sprites/` |
| `pnpm build` | Full production build — compiles everything to `dist/` |
| `pnpm exec gulp checktextdomain` | Checks all gettext calls use the correct text domain |

During development, `pnpm watch` is the main command. It compiles directly into `content/themes/prometheus/`, which is where the local web server reads the theme from.

`gulp watch` only works directly if `gulp-cli` is installed globally. Without a global install, use `pnpm watch` (or `pnpm exec gulp watch`).

The same applies to release commands: use `pnpm exec gulp release` by default, or `gulp release` if `gulp-cli` is installed globally.

## Releasing to master

`master` contains the compiled output. The `dist/` folder is a git worktree linked to `master`, so you can compile and commit directly from `develop`.

**One-time setup:**

```bash
git worktree add dist master
```

This creates `dist/` as a checkout of `master` inside the repo (no separate clone needed). It's gitignored on `develop` so it won't appear as untracked.

**Release workflow:**

```bash
# 1. Build everything into dist/
pnpm exec gulp release

# 2. Go into dist/, commit and push to master
cd dist
git add .
git commit -m "release: description of changes"
git push
cd ..
```

**Cleanup** (if you need to remove the worktree):

```bash
git worktree remove dist
```

## Custom post types

Registered in `content/mu-plugins/mm-custom-post-types.php`:

| Post type | Slug |
|-----------|------|
| `mm_work` | `/trabajos/` |
| `mm_comic` | `/comics/` |
| `mm_dev_post` | `/blog-desarrollo/` |
| `mm_diary` | *(diaries)* |

## Notes

- `content/uploads` is a symlink pointing to `../shared/content/uploads`. The `shared/` folder is gitignored and must be created manually after cloning.
- The `private/` submodule is not public. It contains the `private/config.php` file loaded by `wp-config.php` with the local database and environment settings.
- The compiled theme (`content/themes/prometheus/`) is gitignored in `develop` and only exists in `master`.

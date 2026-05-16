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
- npm
- A local web server (Apache or Nginx) with PHP and MySQL/MariaDB

## Setup

1. Clone the repo and checkout `develop`
2. Initialise submodules (see above)
3. Create the shared uploads directory (gitignored, not cloned):
   ```bash
   mkdir -p src/shared/content/uploads
   ```
4. Install dependencies:
   ```bash
   npm install
   ```
5. Configure your local environment in `private/config.php` (DB credentials, site URL, etc.)

## Gulp tasks

| Task | Description |
|------|-------------|
| `gulp watch` | Watches source files and compiles on change. Also starts Browser-sync. |
| `gulp styles` | Compiles Stylus to `content/themes/prometheus/style.css` |
| `gulp js-compiled` | Bundles and transpiles JS via Babel, outputs minified file |
| `gulp js-templates` | Minifies individual JS files |
| `gulp copy-images` | Copies images to theme |
| `gulp svgsprites` | Generates SVG sprite from `source/assets/images/_svg-sprites/` |
| `gulp release` | Full production build — compiles everything to `dist/` |
| `gulp checktextdomain` | Checks all gettext calls use the correct text domain |

During development, `gulp watch` is the main command. It compiles directly into `content/themes/prometheus/`, which is where the local web server reads the theme from.

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

# AGENTS.md

This file provides guidance to coding agents when working with code in this repository.

## What this is

`wporg-main-2022` is the block-based **child theme** for the main WordPress.org site, plus the local dev environment that runs it. Its parent is `wporg-parent-2021` (installed via Composer from GitHub). This repo replaces the older `wporg` (parent) / `wporg-main` (child) theme pair, which are still checked out alongside for the pages not yet migrated.

The theme lives at `source/wp-content/themes/wporg-main-2022/` and is the single Yarn workspace (`wporg-main-2022-theme`).

## Environment setup

Requires Docker, Node (see `.nvmrc`), Yarn, Composer, and SVN. Composer pulls parent/old themes and several plugins from GitHub + `meta.svn.wordpress.org`, so those must resolve.

```bash
yarn && composer install && yarn setup:tools   # dependencies + config generation
yarn wp-env start                               # Docker environment
yarn setup:wp                                   # provision WP, create starter pages
yarn build:theme                                # build the theme's JS/CSS
```

Site runs at http://localhost:8888 (admin / password). To run without Docker, use `yarn playground` (WordPress Playground) — run the dependency + `yarn build:theme` steps first or it will refuse to boot.

## Common commands

Run all of these from the repo root, not from theme/plugin subfolders.

- Build theme assets: `yarn build:theme` — watch mode: `yarn start:theme`
- Lint PHP: `yarn lint:php` (phpcs) — autofix: `composer run format` in root
- Lint front-end: `yarn lint:frontend` (stylelint + eslint via `@wordpress/scripts`)
- PHP tests: `yarn test:php` (PHPUnit, requires the running Docker env)
- Run one test: `yarn wp-env run tests-cli ./vendor/bin/phpunit -c ./wp-content/tests/phpunit/phpunit.xml --filter <TestName>`
- WP-CLI: `yarn wp-env run cli "post list --post_status=publish"` (keep the command quoted)
- Sync pattern content from page editor: `yarn build:patterns`
- Refresh local content from staging: `yarn setup:refresh` · reset clean: `yarn wp-env clean all && yarn setup:wp`
- Visual regression: `yarn backstop:reference` then `yarn backstop:test` · Lighthouse: `yarn lighthouse`

## Architecture

### Theme switching (`source/wp-content/mu-plugins/theme-switcher.php`)
The site is mid-migration. This mu-plugin decides per-request whether to serve the new block theme or fall back to the old `wporg`/`wporg-main` themes. New theme is the **default**; it downgrades for a hardcoded `$old_theme_pages` list and for non-front-page (Rosetta) sites. Note the different theme paths for `local` vs sandbox/production. When a page is migrated, remove it from that list.

### Pages are rendered from patterns, not stored content
Front-end pages on wordpress.org render through PHP **patterns** in the theme's `patterns/` directory, so page content is tracked in version control. The authoring flow:

1. An editor writes/edits the page in the WP admin (draft, then published).
2. `env/page-manifest.json` maps each page: `slug` → `template` (`page-<slug>.html` in `templates/`) → `pattern` (`.php` in `patterns/`).
3. `yarn build:patterns` (`env/build-patterns.sh` → `env/export-content/index.php`) pulls the live page content from wordpress.org and regenerates the pattern file + page template.
4. Commit the regenerated files; a meta-team member deploys via `bin/sync/main.sh` on the sandbox.

Adding a new page = create it in the editor, add an entry to `page-manifest.json`, run `yarn build:patterns`. See `readme.md` for the full publishing runbook, including header/footer style overrides (`wp:wporg/global-header` / `global-footer`).

### The content parser (`env/export-content/`)
The block/HTML parser that `build:patterns` uses to convert page content into pattern markup. Parsers live in `includes/parsers/`. **This is the only code covered by the PHPUnit suite** (`env/export-content/tests/`, wired up in `source/wp-content/tests/phpunit/phpunit.xml`).

### Custom blocks (`source/wp-content/themes/wporg-main-2022/src/`)
Each subdirectory is a block (`download-counter`, `release-tables`, `remembers-list`, `privacy-request-form`, `google-search-embed`, `random-heading`, plus `rosetta` and shared `style`). A block has `block.json`, `index.js` (editor), optional `view.js` (front-end), `style.scss`, and `index.php` (PHP `render_callback` / registration). Each block's `index.php` is `require`d from the theme's `functions.php`, which is also where theme-wide hooks and `inc/*.php` helpers are loaded. `wp-scripts` builds `src/` into `build/`.

## Coding standards

WordPress.org Meta Coding Standards, imported via `wporg-repo-tools` (`phpcs.xml` extends the generated `phpcs.xml.dist`). Notable local exemptions in `phpcs.xml`: files under `patterns/` skip output-escaping, embedded-PHP, and indentation rules; forked parser files under `env/export-content/includes/` skip comment-style rules. Do not "fix" those to satisfy phpcs.

Theme PHP is namespaced under `WordPressdotorg\Theme\Main_2022` (the mu-plugin uses `WordPressdotorg\MU_Plugins\...`); hooks are registered with `__NAMESPACE__ . '\callback'`. Composer targets **PHP 8.4** (`platform` in `composer.json`).

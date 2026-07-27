# AGENTS.md

This file provides guidance to coding agents when working with code in this repository.

## What this is

`wporg-main-2022` is the block-based **child theme** for the main WordPress.org site, plus the local dev environment that runs it. Its parent is `wporg-parent-2021` (installed via Composer from GitHub). This repo replaces the older `wporg` (parent) / `wporg-main` (child) theme pair, which are still checked out alongside for the pages not yet migrated.

The theme lives at `source/wp-content/themes/wporg-main-2022/` and is the single npm workspace (`wporg-main-2022-theme`).

## Environment setup

Requires Docker, Node (see `.nvmrc`), Composer, and SVN. Composer pulls parent/old themes and several plugins from GitHub + `meta.svn.wordpress.org`, so those must resolve.

```bash
npm install && composer install && npm run setup:tools   # dependencies + config generation
npx wp-env start                                         # Docker environment
npm run setup:wp                                         # provision WP, create starter pages
npm run build:theme                                      # build the theme's JS/CSS
```

Site runs at http://localhost:8888 (admin / password). To run without Docker, use `npm run playground` (WordPress Playground) — run the dependency + `npm run build:theme` steps first or it will refuse to boot.

## Common commands

Run all of these from the repo root, not from theme/plugin subfolders.

- Build theme assets: `npm run build:theme` — watch mode: `npm run start:theme`
- Lint PHP: `npm run lint:php` (phpcs) — autofix: `composer run format` in root
- Lint front-end: `npm run lint:frontend` (stylelint + eslint via `@wordpress/scripts`)
- PHP tests: `npm run test:php` (PHPUnit, requires the running Docker env)
- Run one test: `npx wp-env run tests-cli ./vendor/bin/phpunit -c ./wp-content/tests/phpunit/phpunit.xml --filter <TestName>`
- WP-CLI: `npx wp-env run cli wp post list --post_status=publish` (do NOT quote the command as one string — current wp-env exec's it as a single binary name and fails)
- Sync pattern content from page editor: `npm run build:patterns`
- Refresh local content from staging: `npm run setup:refresh` · reset clean: `npx wp-env clean all && npm run setup:wp`
- Visual regression: `npm run backstop:reference` then `npm run backstop:test` · Lighthouse: `npm run lighthouse`

## Architecture

### Theme switching (`source/wp-content/mu-plugins/theme-switcher.php`)
The site is mid-migration. This mu-plugin decides per-request whether to serve the new block theme or fall back to the old `wporg`/`wporg-main` themes. New theme is the **default**; it downgrades for a hardcoded `$old_theme_pages` list and for non-front-page (Rosetta) sites. Note the different theme paths for `local` vs sandbox/production. When a page is migrated, remove it from that list.

### Pages are rendered from patterns, not stored content
Front-end pages on wordpress.org render through PHP **patterns** in the theme's `patterns/` directory, so page content is tracked in version control. The authoring flow:

1. An editor writes/edits the page in the WP admin (draft, then published).
2. `env/page-manifest.json` maps each page: `slug` → `template` (`page-<slug>.html` in `templates/`) → `pattern` (`.php` in `patterns/`).
3. `npm run build:patterns` (`env/build-patterns.sh` → `env/export-content/index.php`) pulls the live page content from wordpress.org and regenerates the pattern file + page template.
4. Commit the regenerated files; a meta-team member deploys via `bin/sync/main.sh` on the sandbox.

Adding a new page = create it in the editor, add an entry to `page-manifest.json`, run `npm run build:patterns`. See `readme.md` for the full publishing runbook, including header/footer style overrides (`wp:wporg/global-header` / `global-footer`).

#### Gotchas

- **The data flow is one-way: page content in the wordpress.org DB → pattern file.** The pattern file is what visitors see; the DB page is only the authoring source. Never edit a `patterns/*.php` file's content without also getting the same change into the page in the wp-admin editor — otherwise the next content sync silently reverts it.
- **The "Update existing content" GitHub Action (`content-update.yml`, `workflow_dispatch`) runs the same export as `npm run build:patterns` in CI** and maintains a PR on the `automated/content-update` branch. For content updates it's usually easier than running wp-env locally. Local `build:patterns` also pulls content from the *live* wordpress.org REST API, not the local DB.
- **Merging to trunk deploys nothing.** `build.yml` pushes the compiled theme to the `build` branch; a meta-team member must then run `bin/sync/main.sh` on their sandbox (SVN commit + deploy) before wordpress.org serves the change. If the live site doesn't reflect merged trunk, the deploy is the missing step — check the `build` branch content first to rule out CI.
- **Templates reference patterns by the `Slug:` header in the pattern's file docblock** (e.g. `wporg-main-2022/campus-connect`), which often drops the parent-page prefix from the filename (`education-campus-connect.php`). Grep for the slug, not the filename, when tracing template → pattern links.
- **Corrupted page content can be rebuilt from the pattern.** If a page's `post_content` gets mangled (e.g. a failed editor save writes wpautop'd rendered template output into it — symptom: block comments wrapped in `<p>` tags, orphan `<!-- /wp:post-content -->`), render the trunk pattern back to plain block markup in wp-env (`include` the pattern file with output buffering via `wp eval-file`), validate with `parse_blocks()`/`serialize_blocks()` round-trip, and paste it into the page's code editor.

### The content parser (`env/export-content/`)
The block/HTML parser that `build:patterns` uses to convert page content into pattern markup. Parsers live in `includes/parsers/`. **This is the only code covered by the PHPUnit suite** (`env/export-content/tests/`, wired up in `source/wp-content/tests/phpunit/phpunit.xml`).

### Custom blocks (`source/wp-content/themes/wporg-main-2022/src/`)
Each subdirectory is a block (`download-counter`, `release-tables`, `remembers-list`, `privacy-request-form`, `google-search-embed`, `random-heading`, plus `rosetta` and shared `style`). A block has `block.json`, `index.js` (editor), optional `view.js` (front-end), `style.scss`, and `index.php` (PHP `render_callback` / registration). Each block's `index.php` is `require`d from the theme's `functions.php`, which is also where theme-wide hooks and `inc/*.php` helpers are loaded. `wp-scripts` builds `src/` into `build/`.

## Coding standards

WordPress.org Meta Coding Standards, imported via `wporg-repo-tools` (`phpcs.xml` extends the generated `phpcs.xml.dist`). Notable local exemptions in `phpcs.xml`: files under `patterns/` skip output-escaping, embedded-PHP, and indentation rules; forked parser files under `env/export-content/includes/` skip comment-style rules. Do not "fix" those to satisfy phpcs.

Theme PHP is namespaced under `WordPressdotorg\Theme\Main_2022` (the mu-plugin uses `WordPressdotorg\MU_Plugins\...`); hooks are registered with `__NAMESPACE__ . '\callback'`. Composer targets **PHP 8.4** (`platform` in `composer.json`).

# WordPress.org Block Theme

A block-based child theme for WordPress.org, plus local environment.

Once set up, this environment will contain some shared plugins (Jetpack, Gutenberg, etc), some `mu-plugins` ([wporg-mu-plugins](https://github.com/WordPress/wporg-mu-plugins/), [mu-plugins/pub](https://meta.trac.wordpress.org/browser/sites/trunk/wordpress.org/public_html/wp-content/mu-plugins/pub)), and both sets of parent and child themes. The current site uses `wporg` parent and `wporg-main` child; while the new design will be done with [`wporg-parent-2021`](https://github.com/WordPress/wporg-parent-2021) and `wporg-main-2022` (this repo). The "theme-switcher" in `mu-plugins` here should control which theme is used, based on the requested page.

## Development

### Prerequisites

* Docker
* Node/npm
* Yarn
* Composer

### Setup

1. Set up repo dependencies.

    ```bash
    yarn setup:tools
    ```

1. Start the local environment.

    ```bash
    yarn wp-env start
    ```

1. Run the setup script.

    ```bash
    yarn setup:wp
    ```

1. Visit site at [localhost:8888](http://localhost:8888).

1. Log in with username `admin` and password `password`.

### Environment management

These must be run in the project's root folder, _not_ in theme/plugin subfolders.

* Stop the environment.

    ```bash
    yarn wp-env stop
    ```

* Restart the environment.

    ```bash
    yarn wp-env start
    ```

* SSH into docker container.

    ```bash
    yarn wp-env run wordpress bash
    ```

* Run wp-cli commands. Keep the wp-cli command in quotes so that the flags are passed correctly.

    ```bash
    yarn wp-env run cli "post list --post_status=publish"
    ```

* Update composer dependencies and sync any `repo-tools` changes.

    ```bash
    yarn update:tools
    ```

* Run a lighthouse test.

    ```bash
    yarn lighthouse
    ```

* Check visual diffs.

Backstopjs can be manually run to create reference snapshots and then check for visual differences.

    ```bash
    yarn backstop:reference
    # change something in the code or content
    yarn backstop:test
    ```

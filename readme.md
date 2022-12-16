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

1. Build the theme.

    ```bash
    yarn workspaces run build
    ```

1. (optional) There may be times when you want to make changes to the Parent theme and test them with the Main them. To do that:
    1. Clone the Parent repo and follow the setup instructions in its `readme.md` file.
    1. Create a `.wp-env.override.json` file in this repo
    1. Copy the `themes` section from `.wp-env.json` and paste it into the override file. You must copy the entire section for it to work, because it won't be merged with `.wp-env.json`.
    1. Update the path to the Parent theme to the Parent theme folder inside the Parent repository you cloned above.

    ```json
    {
	    "themes": [
		    "./source/wp-content/themes/wporg",
		    "./source/wp-content/themes/wporg-main",
		    "./source/wp-content/themes/wporg-main-2022",
		    "../wporg-parent-2021/source/wp-content/themes/wporg-parent-2021"
	    ]
    }
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

* Build the theme's JavaScript

    ```bash
    yarn workspace wporg-main-2022-theme build
    ```

    or, automatically build on changes:

    ```bash
    yarn workspace wporg-main-2022-theme start
    ```


* Refresh local WordPress content with a current copy from the staging site.

    ```bash
    yarn setup:refresh
    ```

* Reset WordPress to a clean install, and reconfigure. This will nuke all local WordPress content!

    ```bash
    yarn wp-env clean all
    yarn setup:wp
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

## Building Patterns from Page Content

1. Run the generator script:
	1. If you're using the Docker environment, start Docker and run `yarn wp-env start`. Then run `yarn build:patterns`.
	1. If you're using a local environment, `cd env` and run `wp eval-file export-content/index.php page-manifest.json` directly.
1. Verify `git stat` and `git diff` look right
1. `git add` and `git commit`
1. Sync to SVN and deploy like you would any other commit

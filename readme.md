# WordPress.org Block Theme

A block-based child theme for WordPress.org, plus local environment.

Once set up, this environment will contain some shared plugins (Jetpack, Gutenberg, etc), some `mu-plugins` ([wporg-mu-plugins](https://github.com/WordPress/wporg-mu-plugins/), [mu-plugins/pub](https://meta.trac.wordpress.org/browser/sites/trunk/wordpress.org/public_html/wp-content/mu-plugins/pub)), and both sets of parent and child themes. The current site uses `wporg` parent and `wporg-main` child; while the new design will be done with [`wporg-parent-2021`](https://github.com/WordPress/wporg-parent-2021) and `wporg-main-2022` (this repo).

The "theme-switcher" in `mu-plugins` here should control which theme is used, based on the requested page. It defaults to this theme, so it only needs to be used so that old pages use the old theme.

## Development

### Prerequisites

* Docker
* Node/npm
* Yarn
* Composer

### Setup

1. Set up repo dependencies.

    ```bash
    yarn
    composer install
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

1. (Optional) There may be times when you want to make changes to the Parent theme and test them with the Main them. To do that:
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

## Working on non-English sites

If you want to test how the site looks with non-English content, you can do that by manually loading the translation file. This does not fully mimic a "Rosetta" site, but it works for checking the styles.

1. Create a folder `source/wp-content/languages`, with a `themes` folder inside.
1. Go to https://translate.wordpress.org/projects/meta/wordpress-org/
1. Select the language you want to apply to your local environment.
1. Scroll to the bottom of the page and export the translation file as a `.mo` file.
1. Rename the downloaded file to `wporg-{locale}.mo`
1. Move the file into the `source/wp-content/languages/themes` folder.
1. Create or open the file `.wp-env.override.json`
1. Update the `mappings` to include the new languages folder:
	```json
	{
	    "mappings": {
	        "wp-content/languages": "./source/wp-content/languages"
	    }
	}
	```
1. Restart the environment `yarn wp-env start --update`
1. Go to your site settings to update the language, if it's not set already http://localhost:8888/wp-admin/options-general.php
1. View the frontend, it should now use the locale you've selected.

## Publishing content on WordPress.org

The pages on the WordPress.org main site use patterns to render the page content, so that any changes are tracked [in version control](https://github.com/WordPress/wporg-main-2022/commits/trunk/source/wp-content/themes/wporg-main-2022/patterns). Each pattern is built from page content, so that authors can use the editor.

To add or update a page using the new redesign, you need someone with at least “editor” or “designer” access to the site, and someone from the meta team with commit access to dotorg. They don’t need to be the same person, one person can update the content, then the second can sync & deploy the change.

### Adding a new page

1. Write the content

Ask someone with at least "editor" access to create a new draft page.

Write your content, you can upload media and use blocks like any other site. Use the “Preview in new tab” to see your changes. When you're done, save the draft.

2. Deploy the new page

If you don't already have it, check out this repo. Follow the instructions above to set everything up.

Publish the requested page, if it's not already.

Add the new page to `./env/page-manifest.json`. Use the following format, where slug is the page slug, and pattern-name is a slug that also includes parent page info (for example, `download.php`, `download-releases.php`, etc). Look at the other entries in the file for examples.

```json
{
    "slug": "[slug]",
    "template": "page-[slug].html",
    "pattern": "[pattern-name].php"
},
```

If you're using the Docker environment, start it with `yarn wp-env start`.

Create the page in your local environment.

Run the script to sync the pattern content. This syncs from the remote page content on wordpress.org, and creates the page template which references the new pattern.
	If you're using Docker, the command is `yarn build:patterns`.
	In other environments the command is `wp eval-file env/export-content/index.php env/page-manifest.json`. Run that from the `public_html` directory.

View the new page, it should contain the synced content.

If necessary, update the header & footer style in the page template. You can pass custom styles like

`<!-- wp:wporg/global-header {"style":{"border":{"bottom":{"color":"var:preset|color|light-grey-1","style":"solid","width":"1px"},"top":{},"right":{},"left":{}}},"backgroundColor":"white","textColor":"charcoal-2"} /-->`

Or preset style variations:

- White on black: `<!-- wp:wporg/global-header /-->`
- Black on white: `<!-- wp:wporg/global-header {"style":"black-on-white"} /-->`
- White on blue: `<!-- wp:wporg/global-footer {"style":"white-on-blue"} /-->`

Verify that the changes look correct, and commit the changes to github. Wait for the actions to finish.

Use the sync script `bin/sync/main.sh` on your sandbox to sync the changes, and deploy wporg.

The new page should be live 🎉

### Updating an existing page

1. Make the change in the editor

Edit the page content, using the editor as on any other site.

You can use the “Preview in new tab” to see your changes. Update the page to save your change. **It will not be visible on the front end yet.**

2. Deploy the change to the site

If you don't already have it, check out this repo. Follow the instructions above to set everything up.

Start up the local environment using `yarn wp-env start`.

Run `yarn build:patterns`. This updates the pattern code with the latest page content. View the new page, it should use the new content.

Verify that the changes look correct, and commit the changes to github. Wait for the actions to finish.

Use the sync script `bin/sync/main.sh` on your sandbox to sync the changes, and deploy wporg.

The changes should be live 🎉

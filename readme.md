# WordPress.org Block Theme

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

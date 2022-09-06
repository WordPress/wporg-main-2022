#!/bin/bash

# Refresh the content from the server

npm run wp-env run cli "php env/import-content.php --url 'https://wordpress.org/wp-json/wp/v2/posts?context=wporg_export&per_page=50'"
npm run wp-env run cli "php env/import-content.php --url 'https://wordpress.org/wp-json/wp/v2/pages?context=wporg_export&per_page=50'"
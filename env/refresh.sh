#!/bin/bash

# Refresh the content from the server

yarn wp-env run cli php env/import-content.php --url 'https://wordpress.org/wp-json/wp/v2/posts?context=wporg_export&per_page=50'
yarn wp-env run cli php env/import-content.php --url 'https://wordpress.org/wp-json/wp/v2/pages?context=wporg_export&per_page=50'
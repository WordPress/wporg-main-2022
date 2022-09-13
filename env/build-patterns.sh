#!/bin/bash

# Refresh pattern files from the staging site

#php env/export-content.php --url 'http://wordpress.org/main-test/wp-json/wp/v2/pages?context=wporg_export&slug=front-page' --output 'source/wp-content/themes/wporg-main-2022/patterns/front-page.php'
#php env/export-content.php --url 'http://wordpress.org/main-test/wp-json/wp/v2/pages?context=wporg_export&slug=download' --output 'source/wp-content/themes/wporg-main-2022/patterns/download.php'

yarn wp-env run cli "eval-file env/export-content/index.php env/page-manifest.json"

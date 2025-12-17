#!/bin/bash

root=$( dirname $( wp config path ) )

wp theme activate wporg-main-2022

wp rewrite structure '/%year%/%monthnum%/%postname%/'
wp rewrite flush --hard

wp option update blogname "WordPress.org"
wp option update blogdescription "Blog Tool, Publishing Platform, and CMS"

# wp import "${root}/env/data.xml" --authors=create

wp option update show_on_front 'page'

# Import content from WordPress.org
php env/import-content.php --url 'https://wordpress.org/wp-json/wp/v2/posts?context=wporg_export&per_page=50'
php env/import-content.php --url 'https://wordpress.org/wp-json/wp/v2/pages?context=wporg_export&per_page=50'

# Set front page after content is imported
HOME_PAGE_ID=$(wp post list --post_type=page --name=home --posts_per_page=1 --field=ID --format=ids)
if [ -n "$HOME_PAGE_ID" ]; then
	wp option update page_on_front $HOME_PAGE_ID
	echo "Front page set to ID: $HOME_PAGE_ID"
fi

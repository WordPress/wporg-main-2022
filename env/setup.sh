#!/bin/bash

root=$( dirname $( wp config path ) )

wp theme activate wporg-main-2022

wp rewrite structure '/%year%/%monthnum%/%postname%/'
wp rewrite flush

wp option update blogname "WordPress.org"
wp option update blogdescription "Blog Tool, Publishing Platform, and CMS"

# wp import "${root}/env/data.xml" --authors=create

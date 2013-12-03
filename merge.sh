#!/bin/sh
# Use for Linux Bash & Windows Power Shell Script 1.0

# ASIKART Joomla! Extension Packager: merge script.
# Copyright (c) 2013 Asikart.com. All rights reserved.
# 
# When pulled, execute this script to copy files into your joomla site.

AMP_PATH="c:/wamp/www"

SITE="ext25"
COM="fbimporter"
MOD="flower"
PLG="flower"
GUP="system"

# admin
cp -f -r admin/* $AMP_PATH/$SITE/administrator/components/com_$COM
echo "Admin copied" ;

# site
# cp -f -r site/* $AMP_PATH/$SITE/components/com_$COM
# echo "Site copied" ;

# library
cp -f -r admin/windwalker/* $AMP_PATH/$SITE/libraries/windwalker
echo "Lib copied" ;

# modules site
# cp -f -r modules/mod_$MOD/* $AMP_PATH/$SITE/modules/mod_$MOD
# echo "Module copied" ;

# modules admin
# cp -f -r modules/mod_$MOD/* $AMP_PATH/$SITE/administrator/modules/mod_$MOD
# echo "Module copied" ;

# plugins
# cp -f -r plugins/plg_$GUP"_"$PLG/* $AMP_PATH/$SITE/plugins/$GUP/$PLG
# echo "Plugin copied" ;


exit 0

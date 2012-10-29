#!/bin/bash

# usage
# To change env
# ./change_env.sh -m $envname (e.g. tanaka)
# To change org
# ./change_env.sh -m org


cd $(cd $(dirname $0);pwd)/..
APPDIR=$(pwd)
BASEDIR=$(cd $APPDIR/../../; pwd)

while getopts "m:" flag; do
	case $flag in
		m) MODE="$OPTARG";;
    esac
done

cd $APPDIR/config/development

if [ "$MODE" = "org" ]
then
  mv db_org.php db.php
  rm config.php
  mv htaccess_org $BASEDIR/.htaccess
else
  mv db.php db_org.php
  cp "$MODE"/db.php db.php
  cp "$MODE"/config.php config.php
  cp $BASEDIR/.htaccess htaccess_org
  cp "$MODE"/htaccess $BASEDIR/.htaccess
fi



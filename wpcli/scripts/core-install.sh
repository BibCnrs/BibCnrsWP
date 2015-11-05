#!/bin/bash

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

source ${DIR}/shared
source ${DIR}/defaults

EXTRAS="$@"

f_open_logfile

cd $WORKDIR

$WPCMD core install --url=${SITENAME} --title=${TITLE} --admin_user=${ADMIN} \
	--admin_password=${ADMINPASS} --admin_email=${ADMINEMAIL} $EXTRAS | tee $LOGFILE

if [[ $INSTALL_DEFAULT_PLUGINS == false ]] ; then
  f_info "Skipping default plugins on user request"
else
  for PLUGIN in $DEFAULT_PLUGINS ; do
    $WPCMD plugin install $PLUGIN | tee $LOGFILE
  done
  for PLUGIN in $DEFAULT_ACTIVATED_PLUGINS ; do
    $WPCMD plugin install --activate $PLUGIN | tee $LOGFILE
  done
fi
if [[ $INSTALL_DEFAULT_THEMES == false ]] ; then
  f_info "Skipping default themes on user request"
else
  for THEME in $DEFAULT_THEMES ; do
    $WPCMD theme install $THEME | tee $LOGFILE
  done
  if [[ ! -z $DEFAULT_ACTIVATED_THEME ]] ; then
    $WPCMD theme activate $DEFAULT_ACTIVATED_THEME | tee $LOGFILE
  fi
fi

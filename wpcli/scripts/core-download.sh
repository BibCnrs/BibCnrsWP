#!/bin/bash

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

source ${DIR}/shared

EXTRAS="$@"

f_open_logfile 

cd $WORKDIR

f_check_cms | tee $LOGFILE

$WPCMD core download $EXTRAS | tee $LOGFILE

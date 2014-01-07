<?php
/* -----
** Load the notifier-trace initialization code.  Checkpoint 21 is right after the configuration information has been loaded from the database.
** If all (or no) admins or if an IP-address-based restriction is configured, the trace will begin here.
*/
$autoLoadConfig[21][] = array('autoType' => 'require',
                              'loadFile' => DIR_FS_CATALOG . 'includes/init_includes/init_notifier_trace.php');
                              
/* -----
** Load the notifier-trace initialization code ... AGAIN.  Checkpoint 61 is right after the sessions are initialized, so if the current
** configuration is to trace for a specific admin, the trace will begin here.
*/
$autoLoadConfig[61][] = array('autoType' => 'require',
                              'loadFile' => DIR_FS_CATALOG . 'includes/init_includes/init_notifier_trace.php');
<?php
/* -----
** Load the notifier-trace initialization code.  Checkpoint 41 is right after the configuration information has been loaded from the database.
** If all (or no) customers or if an IP-address-based restriction is configured, the trace will begin here.
*/
$autoLoadConfig[41][] = array('autoType'=>'init_script',
                              'loadFile'=>'init_notifier_trace.php');
                              
/* -----
** Load the notifier-trace initialization code ... AGAIN.  Checkpoint 71 is right after the sessions are initialized, so if the current
** configuration is to trace for a specific customer, the trace will begin here.
*/
$autoLoadConfig[71][] = array('autoType'=>'init_script',
                              'loadFile'=>'init_notifier_trace.php');
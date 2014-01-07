<?php
/* -----
** Notifier Trace v2.0.0 for Zen Cart.  Brought to you by Vinos de Frutas Tropicales (lat9): www.vinosdefrutastropicales.com
**
** Initialize the NOTIFIER_TRACE define, based on the database constants settings.  There is one setting that controls the admin-based
** traces and another that controls the store-side traces.  Each can be set to one of the following values:
**
** <blank>          Disables the notifier-trace in that environment
**    *             Enables the notifier-trace for ALL accesses in that environment
** An IP Address    Enables the notifier-trace *only* for accesses by that IP address in that environment
** An integer       Enables the notifier-trace *only* for accesses by the specified admin/customer ID.
**
** NOTE: This initialization file is (intentionally) run TWICE -- first, just after the database configuration is loaded and, secondly,
** just after the session is started.  If the notifier-trace is to be limited to a specified customer/admin ID, we have to wait until
** the session is started to see if the trace should be enabled!
*/
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
  
} elseif (!defined('NOTIFIER_TRACE')) {
  $notifier_trace_value = '';
  if (IS_ADMIN_FLAG && defined('NOTIFIER_TRACE_ADMIN')) {
    $notifier_trace_value = NOTIFIER_TRACE_ADMIN;
    
  } elseif (!IS_ADMIN_FLAG && defined('NOTIFIER_TRACE_STORE')) {
    $notifier_trace_value = NOTIFIER_TRACE_STORE;
    
  }
  
  // -----
  // Set a flag (used if the trace is to be limited to an admin/customer ID) so we know if we're being run the second time.
  //
  if (!isset($notifier_trace_wait_for_session)) {
    $notifier_trace_wait_for_session = false;
  }
  
  // -----
  // Now, determine what type of configuration is set for the trace function.
  //
  switch(true) {
    // -----
    // All accesses are traced.
    //
    case ($notifier_trace_value == '*'): {
      $notifier_trace = 'true';
      break;
    }
    // -----
    // Accesses are traced only for the specified admin/customer ID.  Need to wait for the second pass, when the session is
    // started, to determine the setting ...
    //
    case (filter_var($notifier_trace_value, FILTER_VALIDATE_INT) && $notifier_trace_value > 0): {
      if ($notifier_trace_wait_for_session) {
        $id_value = (IS_ADMIN_FLAG) ? (isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0) : (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0);
        $notifier_trace = ($notifier_trace_value == $id_value) ? 'true' : 'false';
        $notifier_trace_wait_for_session = false;
        
      } else {
        $notifier_trace_wait_for_session = true;
        
      }
      break;
    }
    // -----
    // Accesses are traced only for the specified IP address.
    //
    case (filter_var($notifier_trace_value, FILTER_VALIDATE_IP)): {
      $notifier_trace = ($notifier_trace_value == $_SERVER['REMOTE_ADDR']) ? 'true' : 'false';
      break;
    }
    // -----
    // Otherwise, no accesses are traced.
    //
    default: {
      $notifier_trace = 'false';
      break;
    }
  }
  
  // -----
  // If we're not waiting for a session-based value check, set the notifier-trace control.
  //
  if (!$notifier_trace_wait_for_session) {
    define('NOTIFIER_TRACE', $notifier_trace);
    
  }
  
  // -----
  // For Zen Cart versions prior to v1.5.1 (where the /logs directory was defined), set the logs directory to the cache directory.
  //
  if (!defined('DIR_FS_LOGS')) {
    define('DIR_FS_LOGS', DIR_FS_SQL_CACHE);
    
  }

}
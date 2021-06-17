<?php
/**
 * Designer welcome entrypoint
 */

$tmpSUID = ActAppDesigner::getSUID();
$tmpVersion = ActAppDesigner::getPluginSetupVersion();
echo ('Plugin Data Version: ' . $tmpVersion . '<br />  SUID: ' . $tmpSUID  );


?>

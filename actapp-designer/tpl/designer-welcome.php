<?php
/**
 * Designer welcome entrypoint
 */

$tmpSUID = ActAppDesigner::getSUID();
$tmpVersion = ActAppDesigner::getPluginSetupVersion();
$tmpRootPath = ActAppCommon::getRootPath();
echo ('Plugin Data Version: ' . $tmpVersion . '<br />  SUID: ' . $tmpSUID  );
echo ('<br/>Root: ' . $tmpRootPath );

$tmpSUID = ActAppDesigner::showUsers();


?>

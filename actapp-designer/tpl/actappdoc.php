<?php
/**
 * Designer created standard doc entry point
 */

$tmpSUID = ActAppDesigner::getSUID();
$tmpVersion = ActAppDesigner::getPluginSetupVersion();
$tmpRootPath = ActAppCommon::getRootPath();
echo ('Plugin Data Version: ' . $tmpVersion . '<br />  SUID: ' . $tmpSUID  );
echo ('<br/>Root: ' . $tmpRootPath );

the_post();
$tmpID = get_the_ID();
global $post;
$post_slug = $post->post_name;

$doctype = get_post_meta($tmpID, 'doctype', true);

echo ('<br/>slug: ' . $post_slug  );
echo ('<br/>GUID: ' . get_the_guid() );
echo ('<br/>Title: ' . get_the_title() );
echo ('<br/>doctype: ' . $doctype  );

$tmpDocJson = get_post_meta($tmpID);
$tmpDocJson = json_encode($tmpDocJson);
echo ('<br/>JSON: ' .$tmpDocJson );
$current_user = wp_get_current_user();
$tmpID = $current_user->ID;
$current_user = wp_get_current_user();
$tmpID = $current_user->ID;
$tmpLastPos = get_user_meta( $tmpID, 'mock_data_pos', true ); 
if( $tmpLastPos == ''){
    $pos = 1;
} else {
    $pos = intval(''.$tmpLastPos) + 1;
}

//   for ($x = 0; $x <= 10; $x++) {
//     echo "The number is: $x <br>";
//   }
//   for ($iPos = 0; $iPos <= 10; $x++) {
//     echo "The number is: $x <br>";
//   }

  //$json = json_encode($array);
  //echo($json);


?>

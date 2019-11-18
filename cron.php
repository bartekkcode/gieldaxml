<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/gieldaxml.php');

$module=new gieldaxml();
$module->generateFileList();
die ('OK');

?>

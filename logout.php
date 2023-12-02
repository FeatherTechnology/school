<?php
date_default_timezone_set('Asia/Calcutta');
@session_start();
include("api/iedit-config.php");

session_destroy();   
echo "<script>location.href='http://featherdemo-001-site6.dtempurl.com/'</script>"; 

?>
<?php
require($_POST['FromMap']);
$FromMeta = $Map;
require($_POST['ToMap']);
$ToMeta = $Map;
require("NewTermMakeMap.php");
var_dump(MakeMap($FromMeta, $ToMeta));
?>

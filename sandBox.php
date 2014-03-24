<?php
require_once 'API.php';
echo "<meta charset='utf-8'>";

$list=HupoAPI::getItemNews("cba",2);
print_r(HupoAPI::getNewsInfo($list));
?>
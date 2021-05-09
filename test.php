<?php

$file=fopen("welcome.txt","w");
fwrite($file,"Hello World. Testing!");
fclose($file);
?>
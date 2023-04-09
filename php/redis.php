<?php

$redis = new Predis\Client();

echo $redis->get( 'name' ) ;


?>
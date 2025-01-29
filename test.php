<?php

/*$test = [1, 2, 3, 4, 5];
$result = array_rand($test, 4);
echo ('<pre>');
var_dump($result);
echo ('</pre>');*/

$question = $options[array_rand($options, 1)];

echo ('<pre>');
var_dump($options);
echo ('</pre>');

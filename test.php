<?php
$dir    = '/home/pi/example/music';
$files1 = array_diff(scandir($dir), array('..', '.'));

print_r($files1);

$num = count($files1);
$rand = rand(0, $num - 1);
$index = $rand + 2;
print_r($files1[$index]);

exec("python example/afromb/afromb.py example/music/$files1[$index] out.wav remixedSound.wav 0.9");
?>

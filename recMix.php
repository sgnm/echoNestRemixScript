<?php
exec('arecord -t wav -f dat -d 3 out.wav > /dev/null &');
echo('record finish');
for ($i=0; $i < 3; $i++) {
  exec('echo 1 > /sys/class/gpio/gpio23/value');
  usleep(500000);
  exec('echo 0 > /sys/class/gpio/gpio23/value');
  usleep(500000);
}
exec('echo 1 > /sys/class/gpio/gpio23/value');
echo('remix now');

$dir    = '/home/pi/example/music';
$files1 = array_diff(scandir($dir), array('..', '.'));
$num = count($files1);
$rand = rand(0, $num - 1);
$index = $rand + 2;
print($files1[$index]);
exec("python example/afromb/afromb.py example/music/$files1[$index] out.wav remixedSound.wav 0.9");

exec('echo 0 > /sys/class/gpio/gpio23/value');
echo('remix finish');
//exec('php play.php');
//exec('aplay -D plughw:1,0 phpTest.wav > /dev/null &');

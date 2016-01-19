<?php
$interval_sec = 0.25;
$wait_sec = 60;
exec('echo 2 > /sys/class/gpio/export');
exec('echo in > /sys/class/gpio/gpio2/direction');
for($i=0; $i<($wait_sec / $interval_sec); $i++){
    if(exec('cat /sys/class/gpio/gpio2/value')==1){
     exec('aplay -D plughw:1,0 phpTest.wav > /dev/null &');
     break;
    }
    usleep($interval_sec * 1000000);
    echo $i.PHP_EOL;
}

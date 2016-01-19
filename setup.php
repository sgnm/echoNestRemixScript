<?php
//play sound
exec('echo 17 > /sys/class/gpio/export');
exec('echo in > /sys/class/gpio/gpio17/direction');

//record
exec('echo 22 > /sys/class/gpio/export');
exec('echo in > /sys/class/gpio/gpio22/direction');

//shutdown
exec('echo 11 > /sys/class/gpio/export');
exec('echo in > /sys/class/gpio/gpio11/direction');

//r
exec('echo 23 > /sys/class/gpio/export');
exec('echo out > /sys/class/gpio/gpio23/direction');

//g
exec('echo 9 > /sys/class/gpio/export');
exec('echo out > /sys/class/gpio/gpio9/direction');

//b
exec('echo 27 > /sys/class/gpio/export');
exec('echo out > /sys/class/gpio/gpio27/direction');

$mode = 0;

while (true) {
  //record
  if(exec('cat /sys/class/gpio/gpio22/value')==1){
    exec('php recMix.php');
    echo('lets play remixed sound');
  }

  //play
  if(exec('cat /sys/class/gpio/gpio17/value')==1){
    if($mode == 0){
        exec('aplay -D plughw:1,0 remixedSound.wav > /dev/null &');
        exec('echo 1 > /sys/class/gpio/gpio27/value');
        $mode++;
        $mode = $mode % 2;
      }else if($mode == 1){
        exec('killall aplay');
        exec('echo 0 > /sys/class/gpio/gpio27/value');
        $mode++;
        $mode = $mode % 2;
      }
  }
  usleep(250000);

  //shutdown
  if(exec('cat /sys/class/gpio/gpio11/value')==1){
    exec('echo 0 > /sys/class/gpio/gpio27/value');
    exec('killall aplay');
    exec('echo 1 > /sys/class/gpio/gpio9/value');
    usleep(500000);
    exec('echo 0 > /sys/class/gpio/gpio9/value');
    break;
  }
}

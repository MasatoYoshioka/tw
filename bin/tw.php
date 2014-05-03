<?php

require __DIR__ . '/../lib/tw.php';
require __DIR__ . '/../lib/tw_terminal.php';

$tw = new Tw();
$terminal = new Tw_Terminal($tw);
$terminal->home_timeline();
$terminal->loop_home_timeline(60);

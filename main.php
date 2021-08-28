<?php

require_once('./lib/Stats.php');

$stats = new Stats();
$stats->run('ju16a6m81mhid5ue1z3v2g0uh', 'sebastianos0121@gmail.com', 'Sebastian Ma');

$stats_result = json_encode($stats);
echo($stats_result);

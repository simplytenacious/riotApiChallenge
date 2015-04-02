<?php
global $root;

require_once dirname(dirname(__FILE__)).'/lib/common.inc.php';
require_once $root.'/lib/classes/database/DbMatches.php';
require_once $root.'/lib/controller/MatchFactory.php';

/**
 * test example
 */
$api = new API($apiKey);

//$allMatches = DbMatches::getAllMatches();

$allMatches = $api->getNewMatches('2015-04-02 08:00:00');

if (isset($allMatches['status'])) {
    echo $allMatches['status']['message'];

    return false;
}

$buildMatches = [];
foreach ($allMatches as $key => $matchID) {
    $matchData = $api->getMatchData($matchID);

    $matchFactory = new MatchFactory($matchData);

    $buildMatches[$matchData['matchId']] = $matchFactory->extractMatchInfos();
}

$h2o = new h2o($root.'/templates/main.html');

$templateData = ['matchInfos' => $buildMatches];

echo $h2o->render($templateData);

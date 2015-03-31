<?php
global $root;

require_once dirname(dirname(__FILE__)).'/lib/common.inc.php';
require_once $root.'/lib/classes/database/DbMatches.php';
require_once $root.'/lib/controller/MatchFactory.php';

/**
 * test example
 */
$api = new API($apiKey);

$allMatches = DbMatches::getAllMatches();
$buildMatches = [];

foreach ($allMatches as $match) {
    $matchData = $api->getMatchData($match->getId());

    if (!$matchData instanceof stdClass) {
        echo $matchData;
    }

    $matchFactory = new MatchFactory($matchData);

    $buildMatches[$matchData->matchId] = $matchFactory->extractMatchInfos();
}

$h2o = new h2o($root.'/templates/main.html');

$templateData = ['matchInfos' => $buildMatches];

echo $h2o->render($templateData);

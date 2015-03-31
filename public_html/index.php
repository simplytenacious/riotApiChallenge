<?php
global $root;

require_once dirname(dirname(__FILE__)).'/lib/common.inc.php';
require_once $root.'/lib/classes/database/DbMatches.php';

/**
 * test example
 */
$api = new API($apiKey);

$allMatches = DbMatches::getAllMatches();

foreach ($allMatches as $match) {
    $matchData = $api->getMatchData($match->getId());

    if (!$matchData instanceof stdClass) {
        echo $matchData;
    }

    $duration = round($matchData->matchDuration/60);

    echo "<ul>";
    echo "<li>".$matchData->matchMode."</li>";
    echo "<li>".$matchData->region."</li>";
    echo "<li>".$duration."</li>";
    echo "<li>".$matchData->queueType."</li>";
    echo "</ul>";
}

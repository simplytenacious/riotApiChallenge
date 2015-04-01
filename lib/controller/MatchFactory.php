<?php

global $root;
require_once $root.'/lib/classes/database/DbChampions.php';

class MatchFactory {
    /**
     * @var stdClass
     */
    protected $matchData = [];

    public function __construct ($matchData) {
        if (empty($matchData)) {
            return null;
        }

        $this->setMatchData($matchData);
    }

    /**
     * @return stdClass
     */
    public function getMatchData () {
        return $this->matchData;
    }

    /**
     * @param stdClass $matchData
     */
    public function setMatchData ($matchData) {
        $this->matchData = $matchData;
    }

    public function extractMatchInfos () {
        $matchData = $this->getMatchData();

        $duration = round($matchData['matchDuration']/60);

        $teams = [];
        foreach ($matchData['participants'] as $participant) {
            $champion = new DbChampions($participant['championId']);

            $teams[$participant['teamId']][$participant['participantId']] = ['champion' => $champion->getName()];

        }

        $return = ['mode' => $matchData['matchMode'],
                   'region' => $matchData['region'],
                   'duration' => $duration,
                   'queue' => $matchData['queueType'],
                   'teams' => $teams];

        return $return;
    }
}

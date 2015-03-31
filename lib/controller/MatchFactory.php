<?php

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

        $duration = round($matchData->matchDuration/60);

        $return = ['mode' => $matchData->matchMode,
                   'region' => $matchData->region,
                   'duration' => $duration,
                   'queue' => $matchData->queueType];

        return $return;
    }
}

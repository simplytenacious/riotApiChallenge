<?php

class API {
    /**
     * @var string
     */
    private static $apiKey;

    /**
     * @var string
     */
    protected $server;

    /**
     * @var string
     */
    protected $basicUrl;

    /**
     * @var string
     */
    protected $globalUrl;

    public function __construct ($apiKey = null, $server = 'euw') {
        if (!empty($apiKey)) {
            $this->setApiKey($apiKey);
            $this->setServer($server);
            $this->setBasicUrl('https://'.$this->server.'.api.pvp.net/api/lol/');
            $this->setGlobalUrl('https://global.api.pvp.net/api/lol/');
        }
    }

    /**
     * @return string
     */
    public function getApiKey () {
        return self::$apiKey;
    }

    /**
     * @param string $apiKey
     */
    public static function setApiKey ($apiKey) {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getServer () {
        return $this->server;
    }

    /**
     * @param string $server
     */
    public function setServer ($server) {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getBasicUrl () {
        return $this->basicUrl;
    }

    /**
     * @param string $basicUrl
     */
    public function setBasicUrl ($basicUrl) {
        $this->basicUrl = $basicUrl;
    }

    private function encodeParam ($param) {
        return strtolower(rawurlencode($param));
    }

    private function dateTimeToTimeString ($dateTime) {

        $date = new DateTime($dateTime);
        $hours = $date->format('H');
        $minutes = (integer) $date->format('i');

        // round down to the nearest multiple of 5
        $minutes = floor($minutes / 5 ) * 5;

        // if $minutes is 0 or 5 we add a trailing 0
        if($minutes < 10) {
            $minutes = '0' . $minutes;
        }

        try {
            $dateTime = new DateTime($date->format('d.m.Y').' '.$hours.':'.$minutes);
        } catch (Exception $e) {
            return false;
        }

        return $dateTime->format('U');
    }

    /**
     * @param $matchID
     *
     * @return bool|stdClass
     */
    public function getMatchData ($matchID) {

        $matchID = self::encodeParam($matchID);

        $curl = curl_init($this->getBasicUrl().$this->server.'/v2.2/match/'.$matchID.'?api_key='.$this->getApiKey());

        try {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $matchData = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $e) {
            return false;
        }

        return json_decode($matchData, true);
    }

    public function getChampionData ($championID) {
        $championID = self::encodeParam($championID);

        $curl = curl_init($this->getGlobalUrl().'static-data/'.$this->getServer().'/v1.2/champion/'.$championID.'?api_key='.$this->getApiKey());

        try {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $champData = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $e) {
            return false;
        }

        return json_decode($champData, true);
    }

    public function getNewMatches ($dateTime) {
        $dateTime = $this->dateTimeToTimeString($dateTime);

        if ($dateTime === false) {
            return false;
        }

        $curl = curl_init($this->getBasicUrl().$this->getServer().'/v4.1/game/ids?beginDate='.$dateTime.'&api_key='.$this->getApiKey());

        try {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $matches = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $e) {
            return false;
        }

        return json_decode($matches, true);
    }

    public static function getAPI ($server = 'euw') {
        return new self(self::$apiKey, $server);
    }

    /**
     * @return string
     */
    public function getGlobalUrl () {
        return $this->globalUrl;
    }

    /**
     * @param string $globalUrl
     */
    public function setGlobalUrl ($globalUrl) {
        $this->globalUrl = $globalUrl;
    }
}

<?php

class API {
    protected $apiKey;
    protected $server;
    protected $basicUrl;

    public function __construct ($apiKey = null, $server = 'euw') {
        if (!empty($apiKey)) {
            $this->setApiKey($apiKey);
            $this->setServer($server);
            $this->setBasicUrl('https://'.$this->server.'.api.pvp.net/api/lol/'.$this->server);
        }
    }

    /**
     * @return string
     */
    public function getApiKey () {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey ($apiKey) {
        $this->apiKey = $apiKey;
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

    public function encodeParam ($param) {
        return strtolower(rawurlencode($param));
    }

    /**
     * @param $matchID
     *
     * @return bool|stdClass
     */
    public function getMatchData ($matchID) {

        $matchID = self::encodeParam($matchID);

        $curl = curl_init($this->getBasicUrl().'/v2.2/match/'.$matchID.'?api_key='.$this->getApiKey());

        try {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $matchData = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $e) {
            return false;
        }

        return json_decode($matchData);
    }
}

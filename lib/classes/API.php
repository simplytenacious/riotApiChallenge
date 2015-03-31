<?php

class API {
    protected $apiKey;
    protected $server;

    public function __construct ($apiKey = null, $server = 'euw') {
        if (!empty($apiKey)) {
            $this->setApiKey($apiKey);
            $this->setServer($server);
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

    public function encodeParam ($param) {
        return strtolower(rawurlencode($param));
    }

    public function getMatchData ($matchID) {

        $matchID = self::encodeParam($matchID);

        $curl = curl_init('https://'.$this->server.'.api.pvp.net/api/lol/'.$this->server.
                          '/v2.2/match/'.$matchID.'?api_key='.$this->apiKey);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $matchData = curl_exec($curl);
        curl_close($curl);

        if (isset($matchData->message)) {
            return $matchData->message;
        }

        return json_decode($matchData);
    }
}

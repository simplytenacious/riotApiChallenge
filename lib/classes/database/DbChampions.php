<?php

global $root;

require_once $root.'/lib/classes/API.php';

class DbChampions {
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    public function __construct ($championID) {
        if ((int)$championID > 0) {
            $this->setId((int)$championID);

            $this->init();
        }
    }

    private function init () {
        $db = \connection\Connection::connect();

        $sql = 'SELECT name, title
                FROM champions
                WHERE id = '.(int)$this->getId().'
                LIMIT 1;';
        if (!$dbres = $db->prepare($sql)) {
            return false;
        }

        $dbres->execute();

        $dbres->bind_result($name, $title);

        if ($dbres->fetch()) {
            $this->setName($name);
            $this->setTitle($title);

            return true;
        }

        $this->getNewChampionInfo();

        return true;
    }

    private function getNewChampionInfo() {
        $api = API::getAPI();

        $champData = $api->getChampionData($this->getId());

        $this->setName($champData['name']);
        $this->setTitle($champData['title']);

        $this->save();
    }

    private function save () {
        $db = \connection\Connection::connect();

        $sql = 'INSERT INTO champions (id, name, title)
                VALUES (?, ?, ?)';

        $dbres = $db->prepare($sql);

        $dbres->bind_param('iss', $this->getId(), $this->getName(), $this->getTitle());

        $dbres->execute();
        $dbres->close();
    }

    /**
     * @return int
     */
    public function getId () {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId ($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName () {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTitle () {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle ($title) {
        $this->title = $title;
    }
}

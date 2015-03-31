<?php

use connection\Connection;
global $root;

require_once $root.'/lib/classes/mysql.php';

class DbMatches {
    /**
     * @var int
     */
    protected $id;

    public function __construct ($id = null) {
        if ((int)$id > 0) {
            $this->setId((int)$id);
        }
    }

    /**
     * @param int $id
     */
    public function setId ($id) {
        $this->id = (int)$id;
    }

    /**
     * @return int
     */
    public function getId () {
        return (int)$this->id;
    }

    /**
     * @return DbMatches[]|null
     */
    public static function getAllMatches () {
        $db = Connection::connect();

        $matches = [];

        $sql = 'SELECT id
                FROM matches
                GROUP BY id;';
        if (!$dbres = $db->prepare($sql)) {
            return false;
        }

        $dbres->execute();

        $dbres->bind_result($id);

        while ($dbres->fetch()) {
            $matches[] = new DbMatches($id);
        }

        return $matches;
    }
}

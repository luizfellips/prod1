<?php

namespace App\Model\Entity;

use App\DatabaseManager\Database;
use PDOStatement;

class Testimony
{
    public $id;

    public $name;

    public $testimony;

    public $date;

    public function getProperties($isRegister = false)
    {
        if (!$isRegister) {
            $this->processDate();
        }

        return get_object_vars($this);
    }
    
    private function processDate() {
        $this->date = date('d/m/Y H:i:s', strtotime($this->date));
    }
    public function construct($postVars = [])
    {
        $this->name = $postVars['name'] ?? '';
        $this->testimony = $postVars['testimony'] ?? '';
        $this->date = date('Y-m-d H:i:s');
    }

    public function register()
    {
        $this->id = (new Database('testimonies'))->insert($this->getProperties(true));

        return true;
    }

    public static function getTestimonies(
        $where = null,
        $order = null,
        $limit = null,
        $fields = '*'
    ) : PDOStatement {
        return (new Database('testimonies'))->select($where,$order,$limit,$fields);
    }
}

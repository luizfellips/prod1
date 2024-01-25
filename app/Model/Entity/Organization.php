<?php

namespace App\Model\Entity;

class Organization {
    public $id = 1;

    public $name = 'Protector';

    public $description = 'Lorem ipsum,
    dolor sit amet consectetur adipisicing elit. Numquam impedit sunt quos,
    nobis est in asperiores dicta rem porro alias nesciunt. Doloribus amet totam dignissimos aut molestiae temporibus odio quaerat.';

    public function getProperties() {
        return get_object_vars($this);
    }
}

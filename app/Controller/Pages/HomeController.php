<?php

namespace App\Controller\Pages;

use App\Utils\View;

use App\Model\Entity\Organization;

class HomeController extends PageController {
    public static function getHome() {
        $organization = new Organization;

        $content = View::render('pages/home', $organization->getProperties());

        return parent::getPage('Home', $content);
    }
}

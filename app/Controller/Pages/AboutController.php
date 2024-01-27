<?php

namespace App\Controller\Pages;

use App\Utils\View;

use App\Model\Entity\Organization;

class AboutController extends PageController {
    public static function getAbout() {
        $organization = new Organization;

        $content = View::render('pages/about', $organization->getProperties());

        return parent::getPage('ABOUT > PROTECTOR', $content);
    }
}

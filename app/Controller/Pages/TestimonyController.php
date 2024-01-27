<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Model\Entity\Testimony;
use App\Utils\View;
use App\DatabaseManager\Pagination;

class TestimonyController extends PageController
{

    private static function getTestimonyItems($request, &$pagination) {
        $items = '';
        
        $totalQuantity = Testimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;
        
        $pagination = new Pagination($totalQuantity, $currentPage, 3);
        
        $results = Testimony::getTestimonies(null, 'id DESC', $pagination->getLimit());

        while($testimony = $results->fetchObject(Testimony::class)) {
            $items .= View::render('pages/testimony/item', $testimony->getProperties());
        }
        return $items;
    }

    public static function getTestimonies($request)
    {
        $content = View::render('pages/testimonies', [
            'items' => self::getTestimonyItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination)
        ]);

        return parent::getPage('TESTIMONIES', $content);
    }

    public static function insertTestimony(Request $request)
    {
        $postVars = $request->getPostVars();

        $testimony = new Testimony;
        $testimony->construct($postVars);
        $testimony->register();

        return self::getTestimonies($request);
    }
}

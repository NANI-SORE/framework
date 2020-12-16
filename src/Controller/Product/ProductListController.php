<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\Product\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductListController
{
    use Render;

    /**
     * Список всех продуктов
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $sort = $request->query->get('sort', '');
        $direction = $request->query->get('dir', '');
        $productList = (new Product())->getAll($sort, $direction);

        return $this->render('product/list.html.php', ['productList' => $productList]);
    }
}

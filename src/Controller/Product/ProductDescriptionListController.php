<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\Product\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductDescriptionListController
{
    use Render;

    /**
     * Список всех продуктов с описаниями
     *
     * @param Request $request
     *
     * @return Response
     */
    public function descListAction(Request $request): Response
    {
        $productList = (new Product())->getAll($request->query->get('sort', ''));

        return $this->render('product/descList.html.php', ['productList' => $productList]);
    }
}

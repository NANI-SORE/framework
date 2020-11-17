<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    use Render;

    /**
     * Корзина
     *
     * @param Request $request
     * @return Response
     */
    public function infoAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $removeProduct = (int)$request->request->get('removeProduct');
            $basket = (new Basket($request->getSession()));
            if ($removeProduct) {
                $basket->removeProduct($removeProduct);
            } else {
                return $this->redirect('order_checkout');
            }
        }

        $user = new Security($request->getSession());
        $isLogged = $user->isLogged();
        if ($isLogged) {
            $basket = new Basket($request->getSession());
            $productList = $basket->getProductsInfo();
            list(
                'orderDiscount' => $orderDiscount,
                'orderPrice' => $orderPrice,
                'itemDiscounts' => $itemDiscounts
            ) = $basket->getOrderPrice();

            $orderDiscount = $orderDiscount->getDiscount();
        } else {
            $productList = [];
            $orderDiscount = 0;
            $itemDiscounts = [];
            $orderPrice = 0;
        }

        return $this->render('order/info.html.php', ['productList' => $productList, 'isLogged' => $isLogged, 'orderDiscount' => $orderDiscount, 'orderPrice' => $orderPrice, 'itemDiscounts' => $itemDiscounts]);
    }

    /**
     * Оформление заказа
     *
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Request $request): Response
    {
        $isLogged = (new Security($request->getSession()))->isLogged();
        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        $params = (new Basket($request->getSession()))->checkout();

        (new Security($request->getSession()))->setLastOrder($params['orderPrice']);

        (new Basket($request->getSession()))->clear();

        return $this->render('order/checkout.html.php', ['productList' => $params['productList'], 'discount' => $params['discount'], 'orderPrice' => $params['orderPrice']]);
    }
}

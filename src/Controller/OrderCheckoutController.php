<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\Order\FacadeCheckout;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderCheckoutController
{
    use Render;

    /**
     * Оформление заказа
     *
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Request $request): Response
    {
        $session = $request->getSession();
        $isLogged = (new Security($session))->isLogged();
        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        $params = (new FacadeCheckout($session))->checkout();

        (new Security($session))->setLastOrder($params['orderPrice']);

        (new Basket($session))->clear();

        return $this->render('order/checkout.html.php', ['productList' => $params['productList'], 'discount' => $params['discount'], 'orderPrice' => $params['orderPrice']]);
    }
}

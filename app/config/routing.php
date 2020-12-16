<?php

use Controller\MainController;
use Controller\Product\ProductListController;
use Controller\Product\ProductDescriptionListController;
use Controller\Product\ProductInfoController;
use Controller\Product\ProductSocialController;
use Controller\Order\OrderInfoController;
use Controller\Order\OrderCheckoutController;
use Controller\User\UserAuthenticationController;
use Controller\User\UserLogoutController;
use Controller\User\UserListController;
use Controller\User\UserAccountController;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => [MainController::class, 'indexAction']])
);

$routes->add(
    'product_list',
    new Route('/product/list', ['_controller' => [ProductListController::class, 'listAction']])
);
$routes->add(
    'product_desc_list',
    new Route('/product/desclist', ['_controller' => [ProductDescriptionListController::class, 'descListAction']])
);
$routes->add(
    'product_info',
    new Route('/product/info/{id}', ['_controller' => [ProductInfoController::class, 'infoAction']])
);
$routes->add(
    'product_into_social_network',
    new Route('/product/social/{network}', ['_controller' => [ProductSocialController::class, 'postAction']])
);

$routes->add(
    'order_info',
    new Route('/order/info', ['_controller' => [OrderInfoController::class, 'infoAction']])
);
$routes->add(
    'order_checkout',
    new Route('/order/checkout', ['_controller' => [OrderCheckoutController::class, 'checkoutAction']])
);

$routes->add(
    'user_authentication',
    new Route('/user/authentication', ['_controller' => [UserAuthenticationController::class, 'authenticationAction']])
);
$routes->add(
    'logout',
    new Route('/user/logout', ['_controller' => [UserLogoutController::class, 'logoutAction']])
);
$routes->add(
    'user_list',
    new Route('/user/list', ['_controller' => [UserListController::class, 'listAction']])
);
$routes->add(
    'account',
    new Route('/user/account', ['_controller' => [UserAccountController::class, 'accountAction']])
);

return $routes;

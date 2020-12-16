<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccountController
{
    use Render;

    /**
     * Личный кабинет
     *
     * @param Request $request
     * @return Response
     */
    public function accountAction(Request $request): Response
    {
        $session = new Security($request->getSession());
        return $this->render('user/account.html.php', ['user' => $session->getUser(), 'lastOrder' => $session->getLastOrder()]);
    }
}

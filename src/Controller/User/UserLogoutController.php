<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserLogoutController
{
    use Render;

    /**
     * Выходим из системы
     *
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request): Response
    {
        (new Security($request->getSession()))->logout();

        return $this->redirect('index');
    }
}

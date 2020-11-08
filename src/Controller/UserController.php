<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\User\User;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    use Render;

    /**
     * Производим аутентификацию и авторизацию
     *
     * @param Request $request
     * @return Response
     */
    public function authenticationAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $user = new Security($request->getSession());

            $isAuthenticationSuccess = $user->authentication(
                $request->request->get('login'),
                $request->request->get('password')
            );

            if ($isAuthenticationSuccess) {
                return $this->render('user/authentication_success.html.php', ['user' => $user->getUser()]);
            } else {
                $error = 'Неправильный логин и/или пароль';
            }
        }

        return $this->render('user/authentication.html.php', ['error' => $error ?? '']);
    }

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

    /**
     * Список всех пользователей
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $isAllowed = (new Security($request->getSession()))->isAdmin();
        if ($isAllowed) {
            $userList = (new User())->getAll();
            return $this->render('user/list.html.php', ['userList' => $userList]);
        } else {
            return $this->render('error404.html.php', []);
        }
    }
}

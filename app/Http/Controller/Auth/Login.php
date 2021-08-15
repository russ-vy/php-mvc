<?php

namespace App\Http\Controller\Auth;

use App\Core\Controller\AbstractController;
use App\Http\View\Auth;
use App\Http\Model\User as UserModel;

class Login extends AbstractController
{
    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->user = new UserModel();
    }

    public function indexAction()
    {
        if ($this->isLogined()) {
            if ( $this->isAdmin() ) {
                header("Location: /admin/");
            } else {
                header("Location: /");
            }
        } else {
            $loginView = new Auth();
            $loginView->setTemplate('login')->show();
        }
    }

    public function isLogined(): bool
    {
        if ( isset($_SESSION['userID']) ) {
            return true;
        } elseif ( isset($_POST['login']) && isset($_POST['passwd']) ) {
            return $this->authenticated($_POST['login'], $_POST['passwd']);
        }
        return false;
    }

    public function isAdmin(): bool
    {
        if ( isset($_SESSION['isAdmin'])
            || $this->user->getData('id_role') == 1
        ) {
            return true;
        }
        return false;
    }

    protected function authenticated($login, $passwd): bool
    {
        $user = $this->user->getByAttribute(['login' => $login]);

        if ( count($user->getData()) ) {
            $hash = $user->getData('passwd');

            if( password_verify($passwd, $hash) ) {
                $_SESSION['userID'] = $user->getData('id');
                if ($this->isAdmin()) {
                    $_SESSION['isAdmin'] = true;
                }

                return true;
            }
        }
        return false;
    }

    public function loguot()
    {
        unset($_SESSION['userID']);
        header("Location: /");
    }

}
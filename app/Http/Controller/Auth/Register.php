<?php

namespace App\Http\Controller\Auth;

use App\Core\Controller\AbstractController;
use App\Http\Model\User as UserModel;
use App\Http\View\Auth;

class Register extends AbstractController
{
    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->user = new UserModel();
    }

    public function indexAction()
    {
        if ( isset($_POST['email']) && isset($_POST['passwd']) ) {
            $this->createUser($_POST);
        } else {
            $registerView = new Auth();
            $registerView->setTemplate('register')->show();
        }
    }

    public function createUser(array $data)
    {
        $passwd = password_hash($data['passwd'], PASSWORD_BCRYPT);

        $this->user->setData([
            'login' => $data['email']
            , 'passwd' => $passwd
        ])->save();
    }
}
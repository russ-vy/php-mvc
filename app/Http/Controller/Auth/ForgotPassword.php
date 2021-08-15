<?php

namespace App\Http\Controller\Auth;

use App\Core\Controller\AbstractController;
use App\Http\Model\User as UserModel;
use App\Http\View\Auth;

class ForgotPassword extends AbstractController
{
    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->user = new UserModel();
    }

    public function indexAction()
    {
        $forgotPasswordView = new Auth();
        $forgotPasswordView->setTemplate('forgot-password')->show();
    }
}
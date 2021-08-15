<?php

namespace App\Http\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Http\View\Admin as AdminView;

class Admin extends AbstractController
{
    public function indexAction()
    {
        $adminView = new AdminView();
        $adminView->show();
    }
}
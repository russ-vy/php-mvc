<?php

namespace App\Http\Controller;

use App\Core\Controller\AbstractController;
use App\Http\View\Message;
use App\Http\View\User as UserView;
use App\Http\Model\User as UserModel;

class User extends AbstractController
{

    public function indexAction()
    {
        $userView = new UserView();
        $userView->show();
    }

    public function showNameAction()
    {
        if (!isset($_GET['id'])) {
            throw new \Exception("No id!");
        }
        $userId = (int) $_GET['id'];
        $view = new Message();

        if (!$userId) {
            $view->setData(['message' => 'Не получили ID'])->show();
            return;
        }
        $user = new UserModel();

        $view->setData(
            [
                'message' =>
                    $user->getUserExists($userId) ?
                    $user->getNameById($userId)
                    : 'Пользователь не найден'
            ]
        )->show();
    }

    public function showUserAction()
    {
        if (!isset($_GET['id'])) {
            throw new \Exception("No id!");
        }
        $userId = (int) $_GET['id'];
        if ($userId) {
            $user = new UserModel();
            echo new UserView(['user' => $user->getById($userId)->getData()]);
        }
    }

}
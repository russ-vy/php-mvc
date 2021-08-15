<?php

namespace App\Http\Model;

use App\Core\Model\AbstractModel;

class User extends AbstractModel
{
    public $tableName = 'user';
    protected $fillable = [
        'login'
        , 'passwd'
        , 'id_role'
    ];

    public function getLoginById(int $id) : string
    {
        return $this->getById($id)->getData('login');
    }

    public function getUserExists(int $id) : bool
    {
        return !empty($this->getById($id)->getData('id'));
    }

    public function getNameById(int $id) : string
    {
        return $this->getById($id)->getData('login');
    }
}
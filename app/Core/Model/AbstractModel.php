<?php

namespace App\Core\Model;

use DB;

abstract class AbstractModel
{
    protected $db;
    protected $tableName;
    protected $data;
    protected $fillable;

    public function __construct()
    {
        $this->db = DB::getDbConnection();
    }

    public function getById(int $id) : self
    {
        $stm = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stm->bindValue(1, $id);
        $stm->execute();
        $this->data = $stm->fetch();
        return $this;
    }

    public function getByAttribute(array $columnToValue) : self
    {
        if (count($columnToValue) < 1) {
            return $this;
        }
        $preparedQueryList = [];
        foreach (array_keys($columnToValue) as $column) {
            $preparedQueryList[] = "`{$column}` = :{$column}";
        }
        $preparedQuery = "SELECT * FROM {$this->tableName} WHERE " . implode(" AND ", $preparedQueryList) . " LIMIT 1";
        $stm = $this->db->prepare($preparedQuery);
        foreach ($columnToValue as $column => $value) {
            $stm->bindValue($column, $value);
        }
        $stm->execute();
        $this->data = $stm->fetch();
        return $this;
    }

    public function getData($key = null)
    {
        if ($key === null) {
            return $this->data;
        }
        return $this->data[$key] ?? null;
    }

    public function setData(array $data) : self
    {
        if ($this->checkFillable($data)) {
            $this->data = $data;
        }
        return $this;
    }

    public function checkFillable(array $data) : bool
    {
        foreach ($data as $key => $val) {
            if ( !in_array($key, $this->fillable) ) {
                throw new \Exception("Field $key is not fillable");
                die();
            }
        }
        return true;
    }

    public function save() : self
    {
        if (empty($this->data)) {
            return $this;
        }
        if (empty($this->data['id'])) {
            $this->create();
        } else {
            $this->update();
        }
        return $this;
    }

    protected function create() : self
    {
        $preparedQuery = "INSERT INTO {$this->tableName} (`"
            . implode("`, `", array_keys($this->data))
            . "`) VALUES (:"
            . implode(", :", array_keys($this->data))
            . ")";

        // (name, surname, email) values (:name, :surname...)
        $stm = $this->db->prepare($preparedQuery);
        foreach ($this->data as $column => $value) {
            $stm->bindValue($column, $value);
        }
        $stm->execute();
        return $this;
    }

    protected function update() : self
    {
        $preparedQueryList = [];
        foreach (array_keys($this->data) as $column) {
            $preparedQueryList[] = "`{$column}` = :{$column}";
        }
        // set name = :name, surname = :surname, ...
        $preparedQuery = "UPDATE {$this->tableName} SET " . implode(", ", $preparedQueryList) . " WHERE id = :id";
        $stm = $this->db->prepare($preparedQuery);
        foreach ($this->data as $column => $value) {
            $stm->bindValue($column, $value);
        }
        $stm->execute();
        return $this;
    }

    public function getId() : ?int
    {
        return $this->data['id'] ?? null;
    }
}

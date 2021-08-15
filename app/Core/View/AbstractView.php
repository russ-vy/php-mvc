<?php

namespace App\Core\View;

use Twig\Loader\FilesystemLoader;

abstract class AbstractView
{
    protected $data = [];
    protected $template;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function show()
    {
        try {
            $loader = new FilesystemLoader('templates', ROOT_DIR);
            $twig = new \Twig\Environment($loader);

            $template = $twig->load($this->template);
            $template->display($this->data);
        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage();
        }
    }

    public function setData(array $data = []) : self
    {
        $this->data = $data;
        return $this;
    }

    public function __toString()
    {
        $this->show();
        return '';
    }
}
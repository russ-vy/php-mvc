<?php

namespace App\Http\View;

use App\Core\View\AbstractView;

class Auth extends AbstractView
{
    public function setTemplate(string $template) : self {
        $this->template = "auth/$template.twig";
        return $this;
    }
}
<?php
namespace Ariana\FirstProject\Request;
use Core\Request;

class LoginRequest extends Request
{
    public function getLogin(): ?string
    {
        return $this->data['login'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->data['password'] ?? null;
    }

    public function validate(): array
    {
        $errors = [];
        if (isset($this->data['login'])) {
            $login = htmlspecialchars($this->data['login'], ENT_QUOTES, 'UTF-8');
        } else {
            $errors['login'] = 'Incorrect email or password';
        }

        if (isset($this->data['password'])) {
            $password = htmlspecialchars($this->data['password'], ENT_QUOTES, 'UTF-8');
        } else {
            $errors['login'] = 'Incorrect email or password';
        }

        return $errors;
    }
}
<?php

namespace Core\Authentication;

interface AuthServiceInterface
{
    public function login(string $login, string $password);

    public function getCurrentUser();

    public function checkSessionUser();

    public function logout();
}
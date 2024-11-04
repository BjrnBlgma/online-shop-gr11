<?php

namespace Service\Authentication;

interface AuthServiceInterface
{
    public function login(string $login, string $password);

    public function getCurrentUser();

    public function checkSessionUser();

    public function logout();
}
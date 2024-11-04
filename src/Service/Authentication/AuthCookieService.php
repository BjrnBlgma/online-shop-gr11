<?php

namespace Service\Authentication;

class AuthCookieService implements AuthServiceInterface
{
    public function login(string $login, string $password){}

    public function getCurrentUser(){}

    public function checkSessionUser(){}

    public function logout(){}

    private function sessionStart(){}
}
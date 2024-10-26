<?php
namespace Request;
use Model\User;

class RegistrateRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function  getPassword(): ?string
    {
        return $this->data['password'] ?? null;
    }

    public function validate(): array
    {
        $dataVal = $this->data;
        $errors = [];

        if (isset($dataVal['name'])) {
            $name = htmlspecialchars($dataVal['name'], ENT_QUOTES, 'UTF-8');
            if (empty($name)){
                $errors['name'] = "Имя не должно быть пустым";
            } elseif (strlen($name) < 3 || strlen($name) > 20) {
                $errors['name'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['name'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['name'] = "Поле name должно быть заполнено";
        }


        if (isset($dataVal['email'])) {
            $email = htmlspecialchars($dataVal['email'], ENT_QUOTES, 'UTF-8');

            $isCorrectEmail = User::getByEmail($email); //свободна ли почта или уже занята
            if (empty($email)) {
                $errors ['email'] = "Почта не должна быть пустой";
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors ['email'] = "Введите корректный email-адрес!";
            }elseif ( (strlen($email) < 3)||(strlen($email) > 60) ){
                $errors ['email'] = "email-адрес должен содержать не меньше 3 символов и не больше 60 символов";
            }elseif ($isCorrectEmail) {
                $errors['email'] = "email уже занят!";
            }
        }else{
            $errors ['email'] = "Поле email должно быть заполнено";
        }


        if (isset($dataVal['password'])) {
            $password = htmlspecialchars($dataVal['password'], ENT_QUOTES, 'UTF-8');
            if (empty($password)) {
                $errors ['password'] = "Пароль не должен быть пустым";
            }elseif (strlen($password) < 8 || strlen($password) > 20) {
                $errors ['password'] = "Пароль должен быть не менее 8 символов и не более 20 символов";
            }
        }else{
            $errors ['password'] = "Поле password должно быть заполнено";
        }


        if (isset($dataVal['psw-repeat'])) {
            $passRepeat = htmlspecialchars($dataVal['psw-repeat'], ENT_QUOTES, 'UTF-8');
            $password = $dataVal['password'];
            if (empty($passRepeat)) {
                $errors ['psw-repeat'] = "Поле не должно быть пустым";
            }elseif ($passRepeat != $password) {
                $errors ['psw-repeat'] = "Пароли не совпадают"; //Passwords do not match"
            }
        }else {
            $errors ['psw-repeat'] = "Поле repeat password должно быть заполнено";
        }

        return $errors;
    }
}
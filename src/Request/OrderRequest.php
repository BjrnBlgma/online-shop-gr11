<?php

namespace Request;

class OrderRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'];
    }

    public function getFamily(): ?string
    {
        return $this->data['family'];
    }

    public function getAddress(): ?string
    {
        return $this->data['address'];
    }

    public function getCity(): ?string
    {
        return $this->data['city'];
    }

    public function getPhone(): ?int
    {
        return $this->data['phone'];
    }

    public function getTotalSum(): ?int
    {
        return $this->data['all_sum'];
    }


    public function validate(): array //переделать валидацию, после создания таблицы в бд
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


        if (isset($dataVal['family'])) {
            $family = htmlspecialchars($dataVal['family'], ENT_QUOTES, 'UTF-8');
            if (empty($family)){
                $errors['family'] = "Поле Фамилия не должно быть пустым";
            } elseif (strlen($family) < 3 || strlen($family) > 20) {
                $errors['family'] = "Фамилия должна содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $family)) {
                $errors['family'] = "Фамилия может содержать только буквы";
            }
        }else {
            $errors ['family'] = "Поле family должно быть заполнено";
        }


        if (isset($dataVal['address'])) {
            $address = htmlspecialchars($dataVal['address'], ENT_QUOTES, 'UTF-8');
            if (empty($address)){
                $errors['address'] = "Поле Адресс не должно быть пустым";
            } elseif (strlen($address) < 3 || strlen($address) > 60) {
                $errors['address'] = "Адресс должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
            }
        }else {
            $errors ['address'] = "Поле family должно быть заполнено";
        }


        if (isset($dataVal['city'])) {
            $city = htmlspecialchars($dataVal['city'], ENT_QUOTES, 'UTF-8');
            if (empty($city)){
                $errors['city'] = "Поле Город не должно быть пустым";
            } elseif (strlen($city) < 3 || strlen($city) > 20) {
                $errors['city'] = "Поле Город должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я -]+$/u", $city)) {
                $errors['city'] = "Поле Город может содержать только буквы и цифры";
            }
        }else {
            $errors ['city'] = "Поле должно быть заполнено";
        }


        if (isset($dataVal['phone'])) {
            $phone = htmlspecialchars($dataVal['phone'], ENT_QUOTES, 'UTF-8');
            if (empty($phone)){
                $errors['phone'] = "Номер телефона не должен быть пустым";
            } elseif (!preg_match("/^[0-9]+$/u", $phone)) {
                $errors['phone'] = "Номер телефона может содержать только цифры";
            } elseif (strlen($phone) < 3 || strlen($phone) > 15) {
                $errors['phone'] = "Номер телефона должен содержать не меньше 3 символов и не больше 15 символов";
            }
        }else {
            $errors ['phone'] = "Поле Почтовый индекс должно быть заполнено";
        }


        return $errors;
    }
}
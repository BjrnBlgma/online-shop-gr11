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

    public function getPhone(): ?string
    {
        return $this->data['phone'];
    }

    public function getTotalSum(): int|float|null
    {
        return $this->data['all_sum'];
    }


    public function validate(): array //переделать валидацию, после создания таблицы в бд
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = htmlspecialchars($this->data['name'], ENT_QUOTES, 'UTF-8');
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


        if (isset($this->data['family'])) {
            $family = htmlspecialchars($this->data['family'], ENT_QUOTES, 'UTF-8');
            if (empty($family)){
                $errors['family'] = "Поле должно быть заполнено";
            } elseif (strlen($family) < 3 || strlen($family) > 20) {
                $errors['family'] = "Фамилия должна содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $family)) {
                $errors['family'] = "Фамилия может содержать только буквы";
            }
        }else {
            $errors ['family'] = "Поле должно быть заполнено";
        }


        if (isset($this->data['address'])) {
            $address = htmlspecialchars($this->data['address'], ENT_QUOTES, 'UTF-8');
            if (empty($address)){
                $errors['address'] = "Поле должно быть заполнено";
            } elseif (strlen($address) < 3 || strlen($address) > 60) {
                $errors['address'] = "Введите корректный адресс";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
            }
        }else {
            $errors ['address'] = "Поле должно быть заполнено";
        }


        if (isset($this->data['city'])) {
            $city = htmlspecialchars($this->data['city'], ENT_QUOTES, 'UTF-8');
            if (empty($city)){
                $errors['city'] = "Поле должно быть заполнено";
            } elseif (strlen($city) < 3 || strlen($city) > 20) {
                $errors['city'] = "Поле Город должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я -]+$/u", $city)) {
                $errors['city'] = "Поле Город может содержать только буквы и цифры";
            }
        }else {
            $errors ['city'] = "Поле должно быть заполнено";
        }


        if (isset($this->data['phone'])) {
            $phone = htmlspecialchars($this->data['phone'], ENT_QUOTES, 'UTF-8');
            if (empty($phone)){
                $errors['phone'] = "Поле должно быть заполнено";
                // "/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/"
                // не проходит проверку, когда ввожу номер телефона с пробелами, дефисами и скобками одновременно...
                //скорее всего, не сочетается одновременно с пробелами и дефисами...
                //из-за чего, приходитсяя выбирать или пробелы или дефисы м/у цифрами
            } elseif (!preg_match("/^(\+7|8)?[\s\-]?\(?\d{3}\)?[\s\-]?\d{3}[\s\-]?\d{2}[\s\-]?\d{2}$/", $phone)) {
                $errors['phone'] = "Введите корректный номер телефона";
            } elseif (strlen($phone) < 3 || strlen($phone) > 40) {
                $errors['phone'] = "Введите корректную длину номера телефона";
            }
        }else {
            $errors ['phone'] = "Поле должно быть заполнено";
        }


        if (isset($this->data['all_sum'])) {
            $totalSum = htmlspecialchars($this->data['all_sum'], ENT_QUOTES, 'UTF-8');
            $maxSum = 100000;

            if (empty($totalSum)){
                $errors['all_sum'] = "Поле должно быть заполнено";
            } elseif (is_int($totalSum) || is_float($totalSum)) {
                $errors['all_sum'] = "Сумма должна быть числом!";
            } elseif (is_null($totalSum)) {
                $errors['all_sum'] = "Сумма не может быть равна 0";
            }elseif ($totalSum <0) {
                $errors['all_sum'] = "Сумма не может быть отрицательной";
            } elseif ($totalSum > $maxSum) {
                $errors['all_sum'] = 'Сумма превышает максимальный лимит';
            }
        }else {
            $errors ['all_sum'] = "Поле должно быть заполнено";
        }


        return $errors;
    }
}
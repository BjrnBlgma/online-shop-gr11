<?php
namespace Request;

use Model\Product;

class ReviewRequest extends Request
{
    public function getReview(): ?string
    {
        return $this->data['review'];
    }

    public function getRating(): int|float|null
    {
        return $this->data['rating'];
    }

    public function getProductId(): ?int
    {
        return $this->data['product_id'];
    }


    public function validate(): array
    {
        $errors = [];

//        if (isset($this->data['user_name'])) {
//            $name = htmlspecialchars($this->data['user_name'], ENT_QUOTES, 'UTF-8');
//
//            if (empty($name)){
//                $errors['user_name'] = "Имя не должно быть пустым";
//            } elseif (strlen($name) < 3 || strlen($name) > 20) {
//                $errors['user_name'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
//            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
//                $errors['user_name'] = "Имя может содержать только буквы";
//            }
//        }else{
//            $errors ['user_name'] = "Поле name должно быть заполнено";
//        }

        if (isset($this->data['rating'])) {
            $rating = htmlspecialchars($this->data['rating'], ENT_QUOTES, 'UTF-8');

            if (empty($rating)){
                $errors['rating'] =  "Поле должно быть заполнено";
            } elseif (is_int($rating) || is_float($rating)) {
                $errors['all_sum'] = "Оценка должна быть числом!";
            } elseif (is_null($rating)) {
                $errors['all_sum'] = "Оценка не может быть равна 0";
            }elseif ($rating < 0) {
                $errors['all_sum'] = "Оценка не может быть отрицательной";
            }
        }else {
            $errors ['all_sum'] = "Поле должно быть заполнено";
        }


        if (isset($this->data['review'])) {
            $review = htmlspecialchars($this->data['review'], ENT_QUOTES, 'UTF-8');

            if (empty($review)){
                $errors['review'] = "Поле должно быть заполнено";
            } elseif (strlen($review) < 3) {
                $errors['review'] = "Отзыв слишком короткий";
            } elseif (strlen($review) > 1000) {
                $errors['review'] = "Отзыв превышает 1000 символов";
            }elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.!-]+$/u", $review)) {
                $errors['review'] = "Отзыв может содержать только буквы и цифры";
            }
        }else {
            $errors ['review'] = "Поле должно быть заполнено";
        }

        if (isset($this->data['product_id'])) {
            $productId = htmlspecialchars($this->data['product_id'], ENT_QUOTES, 'UTF-8');

            $product = Product::getByProductId($productId);  //есть ли такой товар к продуктах
            $isCorrectIdProduct = $product->getId();

            if (empty($productId)) {
                $errors['product'] = "ID товара не должно быть пустым";
            } elseif (!ctype_digit($productId)) {
                $errors['product'] = "Поле ID товара должно содержать только цифры!";
            } elseif ($productId <= 0) {
                $errors['product'] = "Поле ID товара не должно содержать отрицательные значения";
            } elseif (empty($isCorrectIdProduct)) {
                $errors['product'] = "Введите корректный ID товара";
            }
        } else {
            $errors['product'] = 'Выберите продукт';
        }


        return $errors;
    }
}
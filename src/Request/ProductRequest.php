<?php

namespace Request;

use Model\Product;

class ProductRequest extends Request
{
    public function getProductId(): ?int
    {
        return $this->data['product_id'];
    }

    public function getAmount(): ?int
    {
        return $this->data['amount'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productId = $this->data['product_id'];


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

        if (isset($this->data['amount'])){
            $amount = $this->data['amount'];
            if (empty($amount)) {
                $errors['amount'] = "Выберите количество товара";
            } elseif (!ctype_digit($amount)) {
                $errors['amount'] = "Поле количества товара должно содержать только цифры!";
            } elseif ($amount <= 0) {
                $errors['amount'] = "Количество товара не должно быть отрицательным";
            }
        } else {
            $errors['amount'] = 'Выберите количество товара';
        }

        return $errors;
    }
}
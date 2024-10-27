<?php
namespace Controller;
use Model\Product;
use Service\Authentication;

class ProductController
{
    public function getCatalog()
    {
        Authentication::start();
        Authentication::checkSessionUser();
        $catalog = Product::getProducts();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        Authentication::start();
        $userId = Authentication::getSessionUser();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }
}
<?php
namespace Controller;
use Model\Product;
use Session\Session;

class ProductController
{
    public function getCatalog()
    {
        Session::start();
        Session::checkSessionUser();
        $catalog = Product::getProducts();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        Session::start();
        $userId = Session::getSessionUser();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }
}
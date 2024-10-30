<?php
namespace Controller;
use Model\Product;
use Service\Authentication;

class ProductController
{
    private Authentication $authentication;
    public function __construct(){
        $this->authentication = new Authentication();
    }

    public function getCatalog()
    {
        $this->authentication->start();
        $this->authentication->checkSessionUser();
        $catalog = Product::getProducts();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        $this->authentication->start();
        $userId = $this->authentication->getSessionUser();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }
}
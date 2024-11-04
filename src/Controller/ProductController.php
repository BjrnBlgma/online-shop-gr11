<?php
namespace Controller;
use Model\Product;
use Service\Authentication\AuthSessionService;

class ProductController
{
    private AuthSessionService $authentication;
    public function __construct(){
        $this->authentication = new AuthSessionService();
    }

    public function getCatalog()
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $catalog = Product::getProducts();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        $userId = $this->authentication->getCurrentUser()->getId();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }
}
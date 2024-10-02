<?php
if (!isset($_COOKIE['user_id'])){
    header('Location: /get_login.php');
}
echo 'here is Catalog';

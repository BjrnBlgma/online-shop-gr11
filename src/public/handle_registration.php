<?php
require_once __DIR__ . "/classes/User.php";

$user = new User();
$user->register();

$err = $user->register();
if (!empty($err)) {
    print_r($err);
}
/*foreach ($err as $key => $el) {
    echo $key . "<br>" . "\n";
}*/
require_once "./get_registration.php";
?>
<?php
$res = $_POST;
function validate($res): array
{
    $errors = [];
    if (isset($_POST['name'])) {
        $name = $_POST['name'];

        if (empty($name)){
            $errors ['name'] = "Имя не должно быть пустым";
        }elseif (strlen($name) < 2){
            $errors ['name'] = "Имя должно быть не менее 2 символов";
        }elseif (gettype($name) != "string") {
            $errors ['name'] = "Имя должно состоять из букв";
        }
    }/*else{
        $errors ['name'] = "Поле name должно быть заполнено";
    }*/

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (empty($email)) {
            $errors ['email'] = "Почта не должна быть пустой";
        }/*elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors ['email'] = "Введите корректный email-адрес!";
        }*/
    }/*else{
        $errors ['email'] = "Поле email должно быть заполнено";
    }*/

    if (isset($_POST['password'])) {
        $password = $_POST['password'];

        if (empty($password)) {
            $errors ['password'] = "Пароль не должен быть пустым";
        }elseif (strlen($password) < 8 && strlen($password) > 20) {
            $errors ['password'] = "Пароль должен быть не менее 8 символов и не более 20 символов";
        }
    }/*else{
        $errors ['password'] = "Поле password должно быть заполнено";
    }*/

    if (isset($_POST['psw-repeat'])) {
        $passRepeat = $_POST['psw-repeat'];

        if (empty($passRepeat)) {
            $errors ['psw-repeat'] = "Пароль не должен быть пустым";
        }elseif ($passRepeat != $password) {
            $errors ['psw-repeat'] = "Пароли не совпадают"; //Passwords do not match"
        }
    }/*else {
        $errors ['psw-repeat'] = "Поле repeat password должно быть заполнено";
    }*/

    return $errors;
}

$errors = validate($res);

if (empty($errors)) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passRepeat = $_POST["psw-repeat"];

    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

//$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '{$email}', '{$password}')");

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email =  :email");
    $stmt->execute(['email' => $email]);
    //print_r($stmt->fetch());
    $result = 'Вы успешно зарегестрировались!';
}
?>

<div class="container">
    <div class="content">
        <img src="https://res.cloudinary.com/debbsefe/image/upload/f_auto,c_fill,dpr_auto,e_grayscale/image_fz7n7w.webp"
             alt="header-image" class="cld-responsive">
        <h1 class="form-title">Register Here</h1>
        <form action="handle_registration.php" method="POST">

            <input type="text" placeholder="Enter NAME" name="name" id="name">
            <label style="color: red"> <?php if(!empty($errors)){print_r($errors['name']);} /*else { echo "Введите ваше имя";}*/?> </label>
            <div class="beside">
                <!--<input type="number" placeholder="PHONE NUMBER">-->
                <select>
                    <option>GENDER</option>
                    <option>MALE</option>
                    <option>FEMALE</option>
                </select>
            </div>
            <!--<input type="email" placeholder="EMAIL ADDRESS">-->

            <input type="email" placeholder="Enter EMAIL" name="email" id="email">
            <label style="color: red"> <?php if (!empty($errors)){print_r($errors['email']);} /*else { echo "Введите ваш email";}*/ ?> </label>


            <input type="password" name="password" id="password" placeholder="Enter Password">
            <label style="color: red"> <?php if (!empty($errors)){print_r($errors['password']);} /*else { echo "Введите ваш пароль";}*/ ?> </label>

            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat">
            <label style="color: red"> <?php if (!empty($errors)){print_r($errors['psw-repeat']);} /*else { echo "Повторите ваш пароль";} */?> </label>
            <!--<input type="text" placeholder="CODE">-->
            <br>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg float-left">Register</button>
                <label style="color: green"> <?php print_r($result) ?> </label>
            </div>

            <!--<button type="button">Submit</button>-->
        </form>
    </div>
</div>



<style>
    /*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}*/
    html, body{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color:#008cba;
        height:100%;
    }
    .container{
        height:100%;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .content{
        background-color:white;
        width:500px;
        height:600px; //длина
    }
    img{
        width: 100%;
        height: 25%;
    }
    .form-title{
        padding:10px 40px 0px;
    }
    form{
        padding:0px 40px;
    }
    input[type=text], [type=email]{
        border: none;
        border-bottom: 1px solid black;
        outline:none;
        width:100%;
        margin: 8px 0;
        padding:10px 0;
    }
    input[type=password]{
        border: none;
        border-bottom: 1px solid black;
        outline:none;
        width:100%;
        margin: 8px 0;
        padding:10px 0;
    }
    input :hover {
        background-color: red;
    }
    select{
        border: none;
        border-bottom: 1px solid black;
        outline:none;
        margin: 8px 0;
        padding:5px 0;
        width:50%;
    }
    .beside{
        display:flex;
        justify-content: space-between;
    }
    button{
        color:#ffffff;
        background-color: #4caf50;
        height:40px;
        width:25%;
        margin-top:15px;
        cursor: pointer;
        border:none;
        border-radius:2%;
        outline:none;
        text-align:center;
        font-size:16px;
        text-decoration:none;
        -webkit-transition-duration:0.4s;
        transition-duration:0.4s;
    }
    button:hover{
        background-color:#333333;
    }
</style>

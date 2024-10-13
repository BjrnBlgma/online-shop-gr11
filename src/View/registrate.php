<div class="container">
    <div class="content">
        <br>
        <br>

        <h1 class="form-title">Register Here</h1>
        <form action="/register" method="POST">

            <input type="text" placeholder="Enter NAME" name="name" id="name">


            <label style="color: red">
                <?php if (isset($errors['name'])): ?>
                    <?php print_r($errors['name']);/* if(empty($_POST['name'])){ echo "Введите ваше имя";}*/?>
                <?php endif; ?>
            </label>


            <input type="email" placeholder="Enter EMAIL" name="email" id="email">
            <label style="color: red">
                <?php echo $errors['email'] ?? ''; /*if (empty($_POST['email'])) { echo "Введите ваш email";}*/ ?>
            </label>

            <input type="password" name="password" id="password" placeholder="Enter Password">
            <label style="color: red"> <?php echo $errors['password'] ?? '';?> </label>


            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat">
            <label style="color: red"> <?php echo $errors['psw-repeat'] ?? '';/*if (empty($_POST['psw-repeat'])) { echo "Повторите ваш пароль";}*/ ?> </label>
            <!--<input type="text" placeholder="CODE">-->
            <br>
            <br>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg float-left">Register</button>
                <label style="color: green" > <?php if (empty($errors)){if (!empty($result)){print_r($result);}} ?> </label>
            </div>
            <div class="links">
                <!--<a href="#">Forgot Password?</a>-->
                <a href="/login" >Sign Up</a>
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
        height:100%;
        /*font-family: "Arial", sans-serif;*/
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #3498db;
    }
    .container{
        height:100%;
        display:flex;
        align-items:center;
        justify-content:center;
        width: 100%;
    }
    .content{
        background-color:white;
        width:500px;
        height:500px; //длина
    padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: #1d5b12;
        /*color: #3498db; */
    }
    /*img{
        width: 100%;
        height: 25%;
    }*/
    .form-title{
        text-align: center;
        padding:10px 40px 0px;
    }
    form{
        padding:0px 40px;
    }
    input[type=text], [type=email], [type=password]{
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
    button{
        color:#ffffff;
        background-color: #4caf50;
        height:40px;
        width:100%;
        margin-top:15px;
        cursor: pointer;
        border:none;
        border-radius:0%;
        outline:none;
        text-align:center;
        font-size:16px;
        text-decoration:none;
        -webkit-transition-duration:0.4s;
        transition-duration:0.4s;

        padding: 10px;
        transition: background-color 0.3s ease-in-out;
    }
    button:hover{
        background-color:#333333;
    }
    .links{
        display: flex;
        /*justify-content: space-between;*/
        align-items: center;
        justify-content: right;
        padding:10px 20px 0px;
    }

    .links a{
        margin: 25px 0;
        font-size: 1em;
        color: #8f8f8f;
        text-decoration: none;
    }

    .links a:hover,
    .links a:nth-child(2){
        color: #45f3ff;
    }

    .links a:nth-child(2):hover{
        color: #d9138a;
    }
</style>
<div class="container">
    <div class="content">
        <br>
        <br>
        <!--<img src="https://res.cloudinary.com/debbsefe/image/upload/f_auto,c_fill,dpr_auto,e_grayscale/image_fz7n7w.webp"
             alt="header-image" class="cld-responsive">-->
        <h1 class="form-title">Register Here</h1>
        <form action="handle_registration.php" method="POST">
            <br>
            <input type="text" placeholder="Enter NAME" name="name" id="name">
            <br>
            <label style="color: red"> <?php if(!empty($errors)){print_r($errors['name']);} /*else { echo "Введите ваше имя";}*/?> </label>
            <div class="beside">
                <!--<input type="number" placeholder="PHONE NUMBER">-->
                <select>
                    <button type="submit" class="btn btn-success btn-lg float-left" name="gender" id="gender"><option>GENDER</option></button>
                    <option>MALE</option>
                    <option>FEMALE</option>
                </select>
            </div>
            <!--<input type="email" placeholder="EMAIL ADDRESS">-->

            <input type="email" placeholder="Enter EMAIL" name="email" id="email">
            <label style="color: red"> <?php if (!empty($errors)){print_r($errors['email']);} /*else { echo "Введите ваш email";}*/ ?> </label>
            <br>

            <input type="password" name="password" id="password" placeholder="Enter Password">
            <label style="color: red"> <?php if (!empty($errors)){print_r($errors['password']);} /*else { echo "Введите ваш пароль";}*/ ?> </label>
            <br>

            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat">
            <label style="color: red"> <?php if (!empty($errors)){print_r($errors['psw-repeat']);} /*else { echo "Повторите ваш пароль";} */?> </label>
            <!--<input type="text" placeholder="CODE">-->
            <br>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg float-left">Register</button>
                <label style="color: green"> <?php if (empty($errors)){print_r($result);} ?> </label>
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
        height:550px; //длина
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
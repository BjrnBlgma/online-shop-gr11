<div class="container">
    <div class="card" >
        <h2>Оформление заказа</h2>
        <form action="/order" method="POST">

            <input type="text" placeholder="Введите Имя" id="firstName" name="firstName" required>
            <label style="color: red"> <?php echo $errors['firstName'] ?? '';?> </label>

            <input type="text" placeholder="Введите Фамилию" id="family" name="family" required>
            <label style="color: red"> <?php echo $errors['family'] ?? '';?> </label>

            <input type="text" placeholder="Введите город/населенный пункт" id="city" name="city" required>
            <label style="color: red"> <?php echo $errors['city'] ?? '';?> </label>

            <input type="text" placeholder="Введите свой адрес" id="address" name="address" required>
            <label style="color: red"> <?php echo $errors['address'] ?? '';?> </label>

            <input type="text" placeholder="Введите номер телефона" id="phone" name="phone" required>
            <label style="color: red"> <?php echo $errors['phone'] ?? '';?> </label>

            <input type="text" placeholder="Введите email" id="email" name="email" required>
            <label style="color: red"> <?php echo $errors['email'] ?? '';?> </label>

                <tr>
                    <th colspan="2">Ваш заказ</th>
                </tr>
                <br>
                <tr>
                    <td>Кол-во товаров: <?php echo $countProducts ?? '';?> шт.</td>
                </tr>
                <br>
                <tr>
                    <td>Итого</td>
                    <td><?php echo $allSum ?? ''; ?></td>
                </tr>


            <button type="submit">Оформить заказ</button>
            <div class="links">
                <!--<a href="#">Forgot Password?</a>-->
                <!--<a href="/register" >Register</a>-->
            </div>
        </form>
    </div>
</div>


<style>
    body{
        /*background: url('http://all4desktop.com/data_images/original/4236532-background-images.jpg');*/
        font-family: 'Roboto Condensed', sans-serif;
        color: #262626;
        margin: 5% 0;
        background-color: #3498db;
    }

   /* body {
        font-family: "Arial", sans-serif;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #3498db; !* Warna latar belakang utama *!
    }*/

    .container{
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;

    }
    @media (min-width: 1200px)
    {
        .container{
            max-width: 1150px;
        }
    }


    /*.container {
        width: 100%;
        max-width: 400px;
    }
*/
    .card {
        background-color:white;
        width:100%;
        height: 100%; //длина
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: #1d5b12;
    }

    h2 {
        text-align: center;
        padding:50px 20px 20px;
    }

    form {
        /* display: flex;
         flex-direction: column;*/
        padding:20px 30px;
    }

    label {
        margin-bottom: 10px;
    }

    input {
        border: none;
        border-bottom: 1.2px solid black;
        outline:none;
        width:100%;
        margin: 10px 0;
        padding:15px 0;
    }

    input:focus {
        border-color: #2980b9; /* Warna border input saat focus */
    }

    button {
        color:#ffffff;
        background-color: #4caf50;
        height:40px;
        width:100%;
        margin-top:30px;
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

    button:hover {
        background-color: #2c3e50; /* Warna latar button saat hover */
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


    th{
        border-bottom: 1px solid #dadada;
        padding: 10px 0;
    }
    tr>td:nth-child(1){
        text-align: left;
        color: #2d2d2a;
    }
    tr>td:nth-child(2){
        text-align: right;
        color: #52ad9c;
    }
    td{
        border-bottom: 1px solid #dadada;
        padding: 25px 25px 25px 0;
    }

    p{
        display: block;
        color: #888;
        margin: 0;
        padding-left: 10px;
    }

</style>

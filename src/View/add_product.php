<div class="container">
    <div class="card" >
        <h2>ADD to cart</h2>
        <form action="/add" method="POST">
            <label for="Product-id">Product ID</label>
            <input placeholder="Enter Product-id" id="product_id" name="product_id" required>
            <label style="color: red"> <?php print_r($errors['product'] ?? '');?> </label>
            <br>

            <label for="Amount">Amount</label>
            <input type="text" placeholder="Enter Amount" id="amount" name="amount" required>
            <label style="color: red"> <?php print_r($errors['amount'] ?? '');?> </label>


            <button type="submit">ADD to cart</button>

            <div class="links">
                <a href="/catalog" >Go to Catalog</a>
                <a href="/cart" >Go to look cart</a>
                <!--<a href="#">Forgot Password?</a>-->
            </div>
        </form>
    </div>
</div>




<!--<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php /*foreach ($catalog as $product): */?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src="<?php /*echo $product['image']; */?>">
                <div class="card-body">
                    <p class="card-text text-muted"></p>
                    <a href="#"><h5 class="card-title"><?php /*echo $product['name']; */?></h5></a>
                    <div class="card-footer">
                        <?php /*echo "{$product['price']}$" */?>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>-->

<style>
    body {
        font-family: "Arial", sans-serif;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #3498db; /* Warna latar belakang utama */
    }

    .container {
        width: 100%;
        max-width: 400px;
    }

    .card {
        background-color:white;
        width:400px;
        height:400px; //длина
    padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: #1d5b12;
    }

    h2 {
        text-align: center;
        padding:30px 0px 0px;
    }

    form {
        /* display: flex;
         flex-direction: column;*/
        padding:0px 20px;
    }

    label {
        margin-bottom: 6px;
    }

    input {
        border: none;
        border-bottom: 1px solid black;
        outline:none;
        width:100%;
        margin: 8px 0;
        padding:10px 0;
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
        justify-content: space-between;
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
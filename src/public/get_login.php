<div class="container">
    <div class="card" >
        <h2>Login</h2>
        <form action="handle_login.php" method="POST">
            <!--<label for="username">Username</label>-->
            <input type="text" placeholder="Enter EMAIL or LOGIN" id="login" name="login" required>

            <!--<label for="password">Password</label>-->
            <input type="password" placeholder="Enter PASSWORD" id="password" name="password" required>
            <label style="color: red"> <?php echo $errors['login'] ?? '';?> </label>


            <button type="submit">Login</button>
        </form>
    </div>
</div>


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
        height:300px; //длина
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
</style>
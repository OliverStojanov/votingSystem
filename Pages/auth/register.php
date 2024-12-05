<?php
?>
<style>
    body {
        background-color: antiquewhite;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    form {
        border: 5px solid white;
        border-radius: 5px;
        width: 280px;
        padding: 15px;
        background-color: blanchedalmond;
    }
    label{
        font-family: Arial;
        font-size: 20px;
    }
    form div label, form div input {
        margin: 5px;
    }
    input {
        width: 100%;
    }
    a, button {
        margin: 5px;
        display: inline-block;
        padding: 10px 20px;
        background-color: black;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    a:hover, button:hover, input:hover {
        background-color: slategray;
    }
</style>
<body>
<form action="../../Actions/auth/register_handler.php" method="post">
    <h1>Register</h1>
    <hr>
    <div>
        <label for="name">Name:</label><br>
        <input name="name" type="text" id="name">
    </div>
    <div>
        <label for="surname">Surname:</label><br>
        <input name="surname" type="text" id="surname">
    </div>
    <div>
        <label for="username">Username:</label><br>
        <input name="username" type="text" id="username">
    </div>
    <div>
        <label for="password">Password:</label><br>
        <input name="password" type="password" id="password">
    </div>
    <div>
        <button type="submit">Register</button>
        <a href="login.php">Login</a>
    </div>
</form>
</body>
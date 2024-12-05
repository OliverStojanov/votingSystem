<?php

include "../jwt_helper.php";
include "../Database/db_connection.php";


$db = connectDatabase();

$query = "SELECT * FROM employees";
$result = $db->query($query);

session_start();

if(!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])){
    echo "You are not logged in. <a href='../Pages/auth/login.php'>Login here</a>";
    exit();
}
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
        width: 350px;
        padding: 15px;
        background-color: blanchedalmond;
    }
    label{
        font-family: Arial;
        font-size: 20px;
    }
    form div label, form div input, form div select {
        margin: 5px;
    }
    input, select {
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
<form action="../Actions/vote_handler.php" method="post">
    <h1>Vote</h1>
    <hr>
    <div>
        <label for="category">Choose a category:</label>
        <select name="category" id="category" required><br>
            <option value="Makes work fun">Makes work fun</option>
            <option value="Team player">Team player</option>
            <option value="Culture champion">Culture champion</option>
            <option value="Difference Maker">Difference Maker</option>
            <!-- Add more categories as needed -->
        </select>
    </div>
    <div>
        <label for="nominee">Choose a nominee:</label><br>
        <select name="nominee" id="nominee" required>
            <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)){ ?>
                <?php if ($_SESSION['emp_id'] != $row['id']){?>
                <option value="<?php echo htmlspecialchars($row['name'])?> <?php echo htmlspecialchars($row['surname']) ?>"><?php echo htmlspecialchars($row['name'])?> <?php echo htmlspecialchars($row['surname']) ?></option>
                <?php }?>
            <?php }?>
        </select>
    </div>
    <div>
        <?php if (isset($_SESSION['emp_id'])) { ?>
            <input type="hidden" name="emp_id" value="<?php echo htmlspecialchars($_SESSION['emp_id']);?>">
        <?php } else { echo "false";}?>
    </div>
    <div>
        <label for="comment">Comment:</label>
        <input name="comment" type="text" id="comment">
    </div>
    <button type="submit">Vote</button>
    <a href="../home.php">Back to home page</a>
</form>
</body>

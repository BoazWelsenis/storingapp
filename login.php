<?php
    //Session starten ophalen user_id of gebruiker herkennen
    session_start();

    //Kijken of er iemand is ingelogd --> zo niet wordt degene terug gestuurd login.php (pagina's beveiligen)
    if(isset($_SESSION['user_id']))
    {
        $msg = "Je bent al ingelogd!";
        header("Location: index.php?msg=$msg");
        exit;
    }
?>


<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp</title>
    <?php require_once 'head.php'; ?>
</head>

<body>

    <?php require_once 'header.php'; ?>
    
    <div class="container">

        <!-- Melding Login Pagina -->
        <?php
            if(isset($_GET['msg']))
            {
                echo "<div class='msg'>" . $_GET['msg'] . "</div>";
            }
        ?>

        <form action="backend/loginController.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>
            <input type="submit" value="Inloggen">
        </form>
    </div>
</body>

</html>

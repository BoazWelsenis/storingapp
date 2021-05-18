<?php 
    session_start();
    if(!isset($_SESSION['user_id']))
    {
        $msg = "Je moet eerst inloggen!";
        header("Location: ../login.php?msg=$msg");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    //Query om de gegevens van het account op te halen (/ te controleren of de username correct is)
    require_once 'conn.php';
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":username" => $username
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    //Er wordt gekeken of de query resultaat oplevert
    if($statement->rowCount() < 1){
        die("Error: acccount bestaat niet.");
    }

    //Controleren of het wachtwoord correct is
    if(!password_verify($password, $user['password']))
    {
        die("Error: Wachtwoord is onjuist.");
    }

    //Gebruiker opslaan d.m.v. de user_id van te gebruiker op te slaan in de sessie
    $_SESSION['user_id'] = $user['id'];

    header("Location: ../index.php");
?>
<!-- 
TODO (BIJ HET GEBRUIKEN VAN DIT REGISTER FORMULIER OP ANDERE COMPUTER):
- Zet in de database na username een kolom email, dan kan er namelijk een email insert worden.
-->

<?php

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_check = $_POST['password_check'];

if(isset($_SESSION['user_id'])){
    die("Kan niet registeren - je bent al ingelogd!");
}

//filter_var() bekijkt of de email bestaat - https://www.php.net/manual/en/filter.filters.validate.php
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
    die("Email is ongeldig!");
}

if($password != $password_check){
    die("Wachtwoorden zijn niet gelijk aan elkaar!");
}

require_once 'conn.php'; //eenmalig, omdat de volgende query dit ook herkent
$sql = "SELECT * FROM users WHERE username = :email";
$statement = $conn->prepare($sql);
$statement->execute([
    ":email" => $email
]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if($statement->rowCount() > 0){
    die("Error: Bepaalde gegevens zijn al in gebruik!");
}

if(empty($password)){
    die("Wachtwoord mag niet leeg zijn");
}
$hash = password_hash($password, PASSWORD_DEFAULT);


$query = "INSERT INTO users(username, email, password) VALUES(:username, :email, :hash)";
$statement = $conn->prepare($query);
$statement->execute([
    ":username" => $username,
    ":email" => $email,
    ":hash" => $hash
]);

//Stuur naar login:
header("Location: $base_url/login.php");
exit;
?>
<?php

//Variabelen vullen
$attractie = $_POST['attractie'];
if(empty($attractie))
{
	$errors[] = "Vul de attractie-naam in.";
}

$type = $_POST['type'];
if(empty($type))
{
	$errors[] = "Vul het type in.";
}

$capaciteit = $_POST['capaciteit']; 
if(!is_numeric($capaciteit))
{
	$errors[] = "Vul de capaciteit in.";
}

if(isset($_POST['prioriteit']))
{
	$prioriteit = true;
}
else{
	$prioriteit = false;
}

$melder = $_POST['melder'];
if(empty($melder))
{
	$errors[] = "Vul de naam van de melder in.";
}

$overig = $_POST['overig'];

//Wanneer er een error is
if(isset($errors))
{
	var_dump($errors);
	die();
}

//Niet meer nodig wanneer je een redirect hebt toegepast met de header() functie
//echo $attractie . " / " . $capaciteit . " / " . $melder;  

//1. Verbinding
require_once 'conn.php';

//2. Query
$query = "INSERT INTO meldingen (attractie, type, capaciteit, prioriteit, melder, overige_info) VALUES(:attractie, :type, :capaciteit, :prioriteit, :melder, :overige_info)";

//3. Prepare
$statement = $conn->prepare($query);

//4. Execute
$statement->execute([
	":attractie" => $attractie,
	":type" => $type,
	":capaciteit" => $capaciteit,
	":prioriteit" => $prioriteit,
	":melder" => $melder,
	":overige_info" => $overig,
]);

//Eigen response op POST request (ga terug naar index)
header("Location: ../meldingen/index.php?msg=Melding opgeslagen");
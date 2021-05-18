<?php
    //Session starten ophalen user_id of gebruiker herkennen
    session_start();

    //Kijken of er iemand is ingelogd --> zo niet wordt degene terug gestuurd login.php (pagina's beveiligen)
    if(!isset($_SESSION['user_id']))
    {
        $msg = "Je moet eerst inloggen!";
        header("Location: ../login.php?msg=$msg");
        exit;
    }
?>

<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp / Meldingen</title>
    <?php require_once '../head.php'; ?>
</head>

<body>

    <?php require_once '../header.php'; ?>
    
    <div class="container">
        <h1>Meldingen</h1>
        <a href="create.php">Nieuwe melding &gt;</a>


        <?php if(isset($_GET['msg']))
        {
            echo "<div class='msg'>" . $_GET['msg'] . "</div>";
        } ?>

        <?php
            require_once '../backend/conn.php';
            if(empty($_GET['type']))
            {
                $query = "SELECT * FROM meldingen";
                $stmt = $conn->prepare($query);
                $stmt->execute();
            }
            else
            {
                $query = "SELECT * FROM meldingen WHERE type = :type";
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    ":type" => $_GET['type'] 
                ]);
            }
            $meldingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- Aantal meldingen + Filter --> 
        <div class="flex">
            <p>Aantal meldingen: <strong><?php echo count($meldingen); ?></strong></p>

            <!-- Bonusopdracht - inline php gebruiken!! 
                 1. Waarbij je eerst met een if-statement kijkt of de type is gekozen/ingesteld - if(isset($_GET['type'])):
                 2. Daarna met $_GET het type ophaald en dan de geselecteerde optie laat zien d.m.v. de echo
                 3. Als laatste komt een else-statement waar je kijkt als je niks hebt gekozen in de dropdown door alleen de select en option met values 
                    te gebruiken.

                Link:
                - https://www.php.net/manual/en/language.basic-syntax.phpmode.php
             -->
             
            <?php if(isset($_GET['type'])): ?>
                <form action="" action="GET">
                    <select name="type">
                        <option value="">- kies een type - </option>
                        <option value="achtbaan" <?php if($_GET['type'] == 'achtbaan') echo 'selected="selected"';?>>Achtbaan</option>
                        <option value="draaiend" <?php if($_GET['type'] == 'draaiend') echo 'selected="selected"';?>>Draaiend</option>
                        <option value="kinder" <?php if($_GET['type'] == 'kinder') echo 'selected="selected"';?>>Kinder</option>
                        <option value="horeca" <?php if($_GET['type'] == 'horeca') echo 'selected="selected"';?>>Horeca</option>
                        <option value="show" <?php if($_GET['type'] == 'show') echo 'selected="selected"';?>>Show</option>
                        <option value="water" <?php if($_GET['type'] == 'water') echo 'selected="selected"';?>>Water</option>
                        <option value="overig" <?php if($_GET['type'] == 'overig') echo 'selected="selected"';?>>Overig</option>
                    </select>

                    <input type="submit" value="filter">
                </form>

            <?php else: ?>
            <form action="" action="GET">
                <select name="type">
                    <option value="">- kies een type - </option>
                    <option value="achtbaan">Achtbaan</option>
                    <option value="draaiend">Draaiend</option>
                    <option value="kinder">Kinder</option>
                    <option value="horeca">Horeca</option>
                    <option value="show">Show</option>
                    <option value="water">Water</option>
                    <option value="overig">Overig</option>
                </select>

                <input type="submit" value="filter">
            </form>
            <?php endif; ?>
        </div>

        <table>
            <tr>
                <th>Attractie</th>
                <th>Type</th>
                <th>Melder</th>
                <th>Overige info</th>
                <th>Aanpassen</th>
<!--                 <th>Prioriteit</th>
                <th>Capaciteit</th>
                <th>Gemeld op</th> -->
            </tr>
            <?php foreach($meldingen as $melding): ?>
                <tr>
                    <td><?php echo $melding['attractie'] ?></td>
                    <td><?php echo ucfirst($melding['type']) ?></td> <!-- Opdracht 6 - 2. -->
                    <td><?php echo $melding['melder'] ?></td>
                    <td><?php echo $melding['overige_info'] ?></td>
                    <td><?php echo "<a href='edit.php?id={$melding['id']}'>"; ?>aanpassen</a></td>

<!--                     <td>
                        <?php
                            if($melding['prioriteit'] == True){
                                echo "Ja";
                            }
                            else{
                               echo "Nee"; 
                            }
                        ?>   
                    </td>

                    <td><?php echo $melding['capaciteit'] ?></td>
                    <td><?php echo $melding['gemeld_op'] ?></td> -->
                </tr>
            <?php endforeach; ?>
        </table>
    </div>  

</body>

</html>

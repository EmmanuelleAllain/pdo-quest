<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
</head>

<body>
<?php
require_once ('src/_connec.php');

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($friends as $friend) {
    echo '<ul>';
    echo '<li>' . $friend['firstname'] . ' ' . $friend['lastname'] . '</li>';
    echo '</ul>';
}

if(isset($_POST['firstname']) && isset($_POST['lastname'])) {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    
    if(empty($_POST['firstname'])) {
        echo "Le prénom est obligatoire";
        die();
    }
    if(empty($_POST['lastname'])) {
        echo "Le nom est obligatoire";
        die();
    }

    $newquery = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
    $state = $pdo->prepare($newquery);
    $state->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $state->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    $state->execute();
    header("location:index.php");
    }
?>

<form method="post">
    <label for="firstname">Votre prénom : </label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Votre nom : </label>
    <input type="text" name="lastname" id="lastname">
    <button type="submit">Valider</button>
</form>

</body>
</html>

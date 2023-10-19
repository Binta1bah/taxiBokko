<?php

session_start();
foreach ($_SESSION['users'] as $user) {
    echo " Bienvenue sur E-TaxiBOKKO" . " " . $user['nom'] . " " . $user['prenom'];
}

if (isset($_POST['deconnect'])) {
    session_unset();
    session_destroy();
    header('location:inscription.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <br>
    <br>
    <br>
    <form action="" method="post">
        <input type="submit" name="deconnect" id="deconnect" value="Deconnexion">

    </form>

</body>

</html>
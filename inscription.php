<?php

session_start();
$_SESSION['users'] = array();
$_SESSION['liste'] = array();
// Connexion à la base de donnée 
try {
    $connexion = new PDO("mysql:host=localhost;dbname=taxiBokko", "root", "");
    // echo "La connexion a reussi";
} catch (PDOException $e) {
    echo "La connexion a echoué" . $e->getMessage();
}



// verification des entrée de connexion 
if (isset($_POST['connexion'])) {
    $email = $_POST['mail'];
    $passe = $_POST['pass'];
    $erreursConn = [];
    if (empty($email) || empty($passe)) {
        echo "Les champs email et mot de passe sont obligatoires";
        $erreursConn[] = ["Les champs email et mot de passe sont obligatoires"];
    } elseif (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/", $email)) {
        echo "Donner un email correct";
        $erreursConn[] = ["Donner un email correct"];
    } elseif (strlen($passe) !=  8) {
        echo "Le mot de passe doit contenir au moins 8 caracteres";
        $erreursConn[] = ["Le mot de passe doit contenir au moins 8 caracteres"];
    } else {

        //requette sql
        $query = (" SELECT * FROM `users` WHERE email = :email AND motdepasse = :passe; ");

        $affiche = $connexion->prepare($query);

        $affiche->bindParam(':email', $email);
        $affiche->bindParam(':passe', $passe);
        $affiche->execute();

        $resutat = $affiche->fetchAll();

        $_SESSION['users'] = $resutat;




        if ($resutat) {
            header('location:connexion.php');
        } else {
            echo "Ce compte n'existe pas";
        }


        // //requette sql
        // $query = (" SELECT `email`, `motdepasse` FROM `users`; ");

        // //execusion de la requette
        // $requette = $connexion->query($query);

        // //recuperation de la requette
        // $users = $requette->fetchAll();

        // foreach ($users as $user) {
        //     if ($user['email'] == $email && $user['motdepasse'] == $passe) {
        //         // echo "Bravo vous etes bien un user";
        //         header("location:connexion.php");
        //     } else {
        //         echo "Ce compte n'existe pas";
        //     }
        // }
    }
}


//Verifiacation des entrées d'incription et insertion dans la base de données

if (isset($_POST['inscription'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['tel'];
    $mail = $_POST['email'];
    $pass = $_POST['passe'];
    $erreursIns = [];

    if (empty($nom) || empty($prenom) || empty($telephone)) {
        echo "Tous les champs sont obligatoires";
        $erreursIns[] = ["Tous les champs sont obligatoires"];
    } elseif (!preg_match("/^[a-zA-Z]+$/", $nom) || !preg_match("/^[a-zA-Z]+$/", $prenom)) {
        echo "Donner un nom  ou un prenom correct";
        $erreursIns[] = ["Donner un nom  ou un prenom correct"];
    } elseif (!preg_match("/^[0-9]+$/", $telephone) || substr($telephone, 0, 1) != 7 || strlen($telephone) != 9) {
        echo "Donnez un numero de téléphone correct";
        $erreursIns[] = ["Donnez un numero de téléphone correct"];
    } elseif (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,5}$/", $mail)) {
        echo "Donner un email correct";
        $erreursIns[] = ["Donner un email correct"];
    } elseif (strlen($pass) !=  8) {
        echo "Le mot de passe doit contenir au moins 8 caracteres";
        $erreursIns[] = ["Le mot de passe doit contenir au moins 8 caracteres"];
    } else {

        $sql1 = ("SELECT * FROM users WHERE email = :mail ");

        $select = $connexion->prepare($sql1);

        $select->bindParam(':mail', $mail);

        $select->execute();

        $retour = $select->fetchAll();

        if ($retour) {
            echo "Cet email est déjà utilisé";
            $erreursIns[] = ["Cet email est déjà utilisé"];
        } else {

            $cryppass = md5($pass);

            $sql = ("INSERT INTO `users`( `nom`, `prenom`, `telephone`, `email`, `motdepasse`) VALUES (:nom, :prenom, :telephone, :email, :motdepasse)");

            $insertion = $connexion->prepare($sql);

            $insertion->bindParam(':nom', $nom);
            $insertion->bindParam(':prenom', $prenom);
            $insertion->bindParam(':telephone', $telephone);
            $insertion->bindParam(':email', $mail);
            $insertion->bindParam(':motdepasse', $cryppass);

            $insertion->execute();

            echo "Incription effectuée avec succès";
        }
    }
}

if (isset($_POST['user'])) {

    $sqlusers = ("SELECT * FROM users;");

    $exsqlusers = $connexion->query($sqlusers);

    $users = $exsqlusers->fetchAll();

    $_SESSION['liste'] = $users;

    header('location:users.php');
}




require('formulaires.php');
// session_destroy();

<?php
try {
    $connexion = new PDO("mysql:host=localhost;dbname=taxiBokko", "root", "");
    // echo "La connexion a reussi";
} catch (PDOException $e) {
    echo "La connexion a echoué" . $e->getMessage();
}



if (isset($_POST['connexion'])) {
    $mail = $_POST['email'];
    $pass = $_POST['passe'];
    if (empty($mail) || empty($pass)) {
        echo "Les champs email et mot de passe sont obligatoires";
    } elseif (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+.[a-zA-Z]{2,5}$/", $mail)) {
        echo "Donner un email correct";
    } elseif (strlen($pass) <  8) {
        echo "Le mot de passe doit contenir au moins 8 caracteres";
    } else {

        $query = (" SELECT `email`, `motdepasse` FROM `users`; ");

        $requette = $connexion->query($query);

        $users = $requette->fetchAll();

        foreach ($users as $user) {
            if ($user['email'] == $mail && $user['motdepasse'] == $pass) {

                echo "Bravo vous etes bien un user";
            }
        }
    }
}



if (isset($_POST['inscription'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['tel'];
    $mail = $_POST['email'];
    $pass = $_POST['passe'];


    if (empty($nom) || empty($prenom) || empty($telephone)) {
        echo "Tous les champs sont obligatoires";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $nom) || !preg_match("/^[a-zA-Z]+$/", $prenom)) {
        echo "Donner un nom  ou un prenom correct";
    } elseif (!is_numeric($telephone) || substr($telephone, 0, 1) != 7) {
        echo "Donnez un numero de téléphone correct";
    } elseif (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+.[a-zA-Z]{2,5}$/", $mail)) {
        echo "Donner un email correct";
    } elseif (strlen($pass) <  8) {
        echo "Le mot de passe doit contenir au moins 8 caracteres";
    } else {


        $sql = ("INSERT INTO `users`( `nom`, `prenom`, `telephone`, `email`, `motdepasse`) VALUES (:nom, :prenom, :telephone, :email, :motdepasse)");

        $insertion = $connexion->prepare($sql);

        $insertion->bindParam(':nom', $nom);
        $insertion->bindParam(':prenom', $prenom);
        $insertion->bindParam(':telephone', $telephone);
        $insertion->bindParam(':email', $mail);
        $insertion->bindParam(':motdepasse', $pass);

        $insertion->execute();

        echo "Incription effectuée avec succès";
    }
}






?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>

    <div id="general">




        <div id="niveau">
            <h1 id="ins">Connexion</h1>
            <p id="votre">Votre chauffeur en un clic</p>

            <div id="facebook">
                <p id="mess">Continuer avec Facebook</p><br>
            </div>
            <br>
            <hr>
            <br>

            <form action="" method="post">
                <div>
                    <label for="">Email</label>
                    <input class="tel" type="text" name="email" placeholder="Entrer votre email">
                </div>

                <div>

                    <br>

                    <label for="">Mot de Passe</label>
                    <input class="tel" type="text" name="passe" placeholder="********"><br>
                    <br>
                    <input id="ins1" type="submit" name="connexion" value="Se connecter ->"><br>
                    <br>
                </div>
            </form>
            <br>
            <!-- <button id="bt">S'incrire -></button><br><br> -->

            <a href="">J'ai pas encore de compte</a>
        </div>






        <div id="div1">
            <h1 id="bien">Bienvenue</h1>
            <p id="message">Finaliser votre inscription en renseignant les informations manquantes</p><br>

            <form action="" method="post">

                <div id="div2">

                    <div>

                        <label for="">PRENOM</label>
                        <input id="pre" type="text" name="prenom" placeholder="Entrez votre prénom">

                    </div>
                    <div>
                        <label for="">NOM</label>
                        <input id="nom" type="text" name="nom" placeholder="Entrez votre nom">

                    </div>

                </div>
                <br>


                <!-- <div id="div3"> -->

                <div>
                    <label for="">TELEPHONE</label>
                    <!-- <img src="C:\xampp\htdocs\taxiBokko\photo" alt="drapeau"> -->
                    <!-- <span class="indicatif">+221</span> -->
                    <input class="tel" type="text" name="tel" placeholder="+221 70 000 00 00">
                    <br>
                </div>

                <div>
                    <label for="">Email</label>
                    <input class="tel" type="text" name="email" placeholder="Entrer votre email">
                </div>

                <div>
                    <br>
                    <label for="">Mot de Passe</label>
                    <input class="tel" type="text" name="passe" placeholder="********"><br>
                    <br>
                    <!--                     
                </div> -->






                </div>



                <p id="promo">Ajouter un code promo</p><br>
                <input id="ins2" type="submit" name="inscription" value="S'inscrire ->">







            </form>



            <br>


            <!-- <button id="bouton">S'inscrire -></button><br> -->

            <a href="" id="lien">J'ai déjà un compte</a>

        </div>


    </div>

</body>

</html>
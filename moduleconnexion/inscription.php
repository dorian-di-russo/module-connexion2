<?php
session_start();

try {
    $pdo = new
        PDO("mysql:host=localhost;dbname=moduleconnexion", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}


@$nom = $_POST["nom"];        // création des variablees des inputs avec @ devant pour éviter erreur si champ laissé vide
@$prenom = $_POST["prenom"];
@$login = $_POST["login"];
@$password = $_POST["password"];
@$repassword = $_POST["repassword"];
@$valider = $_POST["valider"];
$erreur = "";
if (!empty($prenom) && !empty($nom) && !empty($password) && !empty($repassword)) {
    if (isset($valider)) {
        // gestion des erreurs 
        if (empty($nom)) $erreur = "Nom laissé vide !";
        if (empty($prenom)) $erreur = "Prénom laissé vide !";
        if (empty($login)) $erreur = "login laissé vide !";
        if (empty($password)) $erreur = "Mot de passe laissé vide !";
        if ($password != $repassword) $erreur = "Mots de passe non identiques !";
        else {

            $req = $pdo->prepare("SELECT id from utilisateurs WHERE login=? limit 1");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute(array($login));
            $tab = $req->fetchAll();
            if (count($tab) > 0)
                $erreur = "<li>Login existe</li>";


            else {
                $ins = $pdo->prepare("INSERT INTO utilisateurs(nom,prenom,login,password) VALUES (?,?,?,?)");
                $ins->execute(array($nom, $prenom, $login, md5($password)));
            }
        }
    }
}

// var_dump($login);

?>


<html id="html1">

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>


    <header class="flex">
        <div class="flexa">
            <p>  <a href="index.php"> Acceuil</a></p>
        </div>
        <div class="flexb">
            <p>  <a href="connexion.php"> Connexion</a></p>
        </div>
        

    </header>
    <div class="container">

        <form id="forminsc" name="fo" method="POST" action="">

            <label for="nom">nom : </label> <br>
            <input type="text" name="nom" placeholder="Nom" value="" /><br />
            <label for="prenom">prenom :</label> <br> 
            <input type="text" name="prenom" placeholder="Prénom" value="" /><br />
            <label for="login">login :</label> <br> 
            <input type="text" name="login" placeholder="Login" value="" /><br />
            <label for="mot de passe">mot de passe : </label> <br>  
            <input type="password" name="password" placeholder="Mot de passe" /><br />
            <label for="comfirmation mot de passe">confirmation mot de passe :</label> <br>
            <input type="password" name="repassword" placeholder="Confirmer Mot  de passe" /><br /> <br>
            <input type="submit" name="valider" value="S'authentifier" />
            <div class="erreur">
                <p> <?php echo $erreur ?></p>
            </div>
        </form>
    </div>
    <?php if (!empty($erreur)) { ?>
        <div id="message"><?php echo $erreur ?></div>
    <?php } ?>
    <h1><?php echo @$resultat['login'] ?></h1>


    <footer id="f">
        <p class="tfooter">Me contacter</p>
    </footer>


</body>

</html>
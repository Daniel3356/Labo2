<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labo-2</title>
    <link rel="stylesheet" href="./css/style.css">

</head>

<body>

    <form action="contacter.php" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom">
        <br>
        <label for="email">Adresse courriel:</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="message">Message:</label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea>
        <br>
        <!-- On préférerait la balise <button> pour faciliter l’accessibilité
             aux non-voyants, conformément aux normes WCAG/ADA.-->
        <input type="submit" class="submit" value="Envoyer">
        <p>Tous droits réservés © 2023</p>
    </form>
    <?php
    $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $message = isset($_POST['message']) ? $_POST['message'] : "";

    function valider($nom, $email, $message)
    {
        $nom = trim($nom);
        $email = trim($email);
        $message = trim($message);
        $isnom = preg_match("^[\p{L}]+$", $nom); // Ont a utiliser le RegEX pour valider le nom. Source: regular-expressions.info

        if ($nom == "" || $email == "" || $message == "") {
            return false;
        } else {
            // Vérifier si le courriel est valide via le mx record 
            $domaine = explode("@", $email)[1];
            if (checkdnsrr($domaine, "MX")) {
                echo "Le courriel est valide";
                return true;
            } else {
                echo "Le courriel n'est pas valide";
                return false;
            }
        }
    }

    if (isset($_POST['fruit'])) {
        // Lire et mettre à jour l'array du cookie
        $fruits = unserialize($_COOKIE['fruits']);
        $_POST['fruit'] = trim($_POST['fruit']);   // Pardonner les espaces au début ou à la fin
        if ($_POST['fruit'] != "") {               // Mais ne pas accepter les champs vides
            array_push($fruits, $_POST['fruit']);  // Accepter (même les doublons, temporairement)
            $fruits = array_unique($fruits);       // Mais au final, ne pas accepter les doublons
        }
    } else {
        // Initialiser l'array du cookie
        $fruits = array("Banane", "Pomme", "Orange", "Mangue", "Raisin");
    }
    // Créer ou mettre à jour le cookie avec une expiration dans une heure
    setcookie('fruits', serialize($fruits), time() + (60 * 60), "/");

    // Afficher la liste des fruits, à jour
    $chaine = "<ol>";
    foreach ($fruits as $fruit) {
        $chaine .= "<li>$fruit</li>";
    };
    $chaine .= "</ol>";
    echo $chaine;

    ?>

</body>
<script src="./js/script.js"></script>

</html>

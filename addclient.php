<?php
ob_start(); // Démarre la temporisation de sortie
// Onglet Clients actif car addclient = sous page de clients
$client = true;
include_once("header.php");
include_once("main.php");

if (!empty($_POST["inputnom"]) && !empty($_POST["inputprenom"]) && !empty($_POST["inputmail"]) && !empty(["inputville"])) {
    $query = "INSERT INTO clients(nom,prenom,email,ville) VALUES (:nom,:prenom,:email,:ville)";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "nom" => $_POST["inputnom"],
        "prenom" => $_POST["inputprenom"],
        "email" => $_POST["inputmail"],
        "ville" => $_POST["inputville"]
    ]);
    $pdostmt->closeCursor();
    header("Location: clients.php");
    ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
    exit(); // Assurez-vous de terminer le script après la redirection
}
ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
?>

<h1 class="mt-5">Ajouter un client</h1>

<form class="row g-3" method="POST">
    <div class="col-md-6">
        <label for="inputnom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="inputnom" placeholder="Nom de famille" name="inputnom" required>
    </div>
    <div class="col-md-6">
        <label for="inputprenom" class="form-label">Prenom</label>
        <input type="text" class="form-control" id="inputprenom" placeholder="Prénom" name="inputprenom" required>
    </div>
    <div class="col-12">
        <label for="inputmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="inputmail" placeholder="Adresse mail" name="inputmail" required>
    </div>
    <div class="col-12">
        <label for="inputville" class="form-label">Ville</label>
        <input type="text" class="form-control" id="inputville" placeholder="Ville de résidence" name="inputville" required>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>

</div>
</main>

<?php
include_once("footer.php");
?>
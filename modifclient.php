<?php
ob_start(); // Démarre la temporisation de sortie
// Onglet Clients actif car addclient = sous page de clients
$client = true;
include_once("header.php");
include_once("main.php");

if (!empty($_GET["id"])) {
    $query = "SELECT * FROM clients WHERE id=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "id"=>$_GET["id"]
    ]);
    while($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):
    ?>

    <h1 class="mt-5">Modifier un client</h1>

    <form class="row g-3" method="POST">
        <input type="hidden" name="mycmdid" value="<?php echo $row["id"]?>">
        <div class="col-md-6">
            <label for="inputnom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="inputnom" placeholder="Nom de famille" name="inputnom" value="<?php echo $row["nom"]?>" required>
        </div>
        <div class="col-md-6">
            <label for="inputprenom" class="form-label">Prenom</label>
            <input type="text" class="form-control" id="inputprenom" placeholder="Prénom" name="inputprenom" value="<?php echo $row["prenom"]?>" required>
        </div>
        <div class="col-12">
            <label for="inputmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputmail" placeholder="Adresse mail" name="inputmail" value="<?php echo $row["email"]?>" required>
        </div>
        <div class="col-12">
            <label for="inputville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="inputville" placeholder="Ville de résidence" name="inputville" value="<?php echo $row["ville"]?>" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>

    </div>
    </main>

<?php
    endwhile;
    $pdostmt->closeCursor();


    }

    if(!empty($_POST)){
        $query = "UPDATE clients SET nom=:nom, prenom=:prenom, email=:email, ville=:ville WHERE id=:id";
        $pdostmt = $pdo->prepare($query);
        $pdostmt->execute([
            "nom"=>$_POST["inputnom"],
            "prenom"=>$_POST["inputprenom"],
            "email"=>$_POST["inputmail"],
            "ville"=>$_POST["inputville"],
            "id"=>$_POST["mycmdid"]
        ]);    
        header("Location: clients.php");
        ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
        exit(); // Assurez-vous de terminer le script après la redirection
        ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
    }
?>

<?php
include_once("footer.php");
?>
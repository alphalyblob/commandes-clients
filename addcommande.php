<?php
ob_start(); // Démarre la temporisation de sortie

// Onglet Clients actif car addclient = sous page de clients
$commande = true;
include_once("header.php");
include_once("main.php");

$query="SELECT id FROM clients";
$objstmt= $pdo->prepare($query);
$objstmt->execute();

$query2="SELECT id FROM articles";
$objstmt2= $pdo->prepare($query2);
$objstmt2->execute();


if (!empty($_POST["inputclientid"]) && !empty($_POST["inputdate"])) {
    $query = "INSERT INTO commandes(client_id,date_commande) VALUES (:client_id,:date_commande)";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "client_id" => $_POST["inputclientid"],
        "date_commande" => $_POST["inputdate"]
    ]);
    $idcmd = $pdo->lastInsertId();
    $query2 = "INSERT INTO lignes_commande(commande_id,article_id,quantite) VALUES (:commande_id,:article_id,:quantite)";
    $pdostmt2 = $pdo->prepare($query2);
    $pdostmt2->execute([
        "commande_id" => $idcmd,
        "article_id" => $_POST["inputidarticle"],
        "quantite" => $_POST["inputquantite"]
    ]);
    $pdostmt->closeCursor();
    $pdostmt2->closeCursor();
    header("Location: commandes.php");
    ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
    exit(); // Assurez-vous de terminer le script après la redirection
}
ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
?>

<h1 class="mt-5">Ajouter une commande</h1>

<form class="row g-3" method="POST">
    <div class="col-md-6">
        <label for="inputclientid" class="form-label">Client Id</label>
        <select class="form-control" name="inputclientid" required>
            <?php
                foreach($objstmt->fetchAll(PDO::FETCH_NUM) as $tab){
                    foreach($tab as $elem){
                        echo "<option value=".$elem.">".$elem."</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputdate" class="form-label">Date Commande</label>
        <input type="date" class="form-control" id="inputdate" placeholder="Date de la commande" name="inputdate" required>
    </div>

    <div class="col-md-6">
        <label for="inputidarticle" class="form-label">Article</label>
        <select class="form-control" name="inputidarticle" required>
            <?php
                foreach($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab){
                    foreach($tab as $elem){
                        echo "<option value=".$elem.">".$elem."</option>";
                    }
                }
            ?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="inputquantite" class="form-label">Quantité</label>
        <input type="text" class="form-control" id="inputquantite" placeholder="Quantité" name="inputquantite" required>
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
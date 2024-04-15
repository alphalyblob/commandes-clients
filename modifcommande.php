<?php
ob_start(); // Démarre la temporisation de sortie
// Onglet Clients actif car addclient = sous page de clients
$commande = true;
include_once("header.php");
include_once("main.php");
$query = "SELECT id from clients";
$mon_objstmt = $pdo->prepare($query);
$mon_objstmt->execute();

$query2 = "SELECT id from articles";
$objstmt2 = $pdo->prepare($query2);
$objstmt2->execute();
if (!empty($_POST["inputquantite"]) && !empty($_POST["inputdate"])) {
    $query = "UPDATE commandes SET client_id=:client_id,date_commande=:date_commande WHERE id=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute(
        ["client_id" => $_POST["inputclientid"],
        "date_commande" => $_POST["inputdate"],
        "id" => $_POST["mycmdid"]
    ]);

    $query2 = "UPDATE lignes_commande SET article_id=:article_id,commande_id=:commande_id,quantite=:quantite WHERE commande_id=:commande_id";
    $pdostmt2 = $pdo->prepare($query2);
    $pdostmt2->execute([
        "article_id" => $_POST["inputidarticle"],
        "commande_id" => $_POST["mycmdid"],
        "quantite" => $_POST["inputquantite"]
    ]);
    $pdostmt2->closeCursor();
    header("Location:commandes.php");
    ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
    exit(); // Assurez-vous de terminer le script après la redirection
    ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
}

if (!empty($_GET["id"])) {
    $query = "SELECT * FROM commandes,lignes_commande WHERE lignes_commande.commande_id=commandes.id AND commandes.id=:id";
    $objstmt = $pdo->prepare($query);
    $objstmt->execute(["id" => $_GET["id"]]);
    $row = $objstmt->fetch(PDO::FETCH_ASSOC);


?>
    <h1 class="mt-5">Modifier une commande</h1>
    <form class="row g-3" method="POST">
        <input type="hidden" name="mycmdid" value="<?php echo $_GET["id"] ?>" />
        <div class="col-md-6">
            <label for="inputclientid" class="form-label">Client Id</label>
            <select class="form-control" name="inputclientid" required>
                <?php
                foreach ($mon_objstmt->fetchAll(PDO::FETCH_NUM) as $tab) {
                    foreach ($tab as $elmt) {
                        if ($elmt == $row["client_id"]) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value=" . $elmt . " " . $selected . ">" . $elmt . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputdate" class="form-label">Date de commande</label>
            <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row["date_commande"] ?>" required>
        </div>
        <div class="col-md-6">
            <label for="inputidarticle" class="form-label">Article</label>
            <select class="form-control" name="inputidarticle" required>
                <?php
                foreach ($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab) {
                    foreach ($tab as $elmt) {
                        if ($elmt == $row["article_id"]) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value=" . $elmt . " " . $selected . ">" . $elmt . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputquantite" class="form-label">Quantite</label>
            <input type="text" class="form-control" id="inputquantite" name="inputquantite" value="<?php echo $row["quantite"] ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>
    </div>
    </main>


<?php
}
include_once("footer.php");
?>
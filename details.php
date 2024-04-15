<?php
$index = true;
include_once("header.php");
include_once("main.php");
$query = "SELECT id from clients";
$mon_objstmt = $pdo->prepare($query);
$mon_objstmt->execute();

$query2 = "SELECT id from articles";
$objstmt2 = $pdo->prepare($query2);
$objstmt2->execute();

if (!empty($_GET["id"])) {
    $query = "SELECT * FROM commandes,lignes_commande,clients WHERE commandes.client_id=clients.id AND lignes_commande.commande_id=commandes.id AND commandes.id=:id";
    $objstmt = $pdo->prepare($query);
    $objstmt->execute(["id" => $_GET["id"]]);
    $row = $objstmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($row);

    $query_views="UPDATE commandes SET vues=:views WHERE id=:id";
    $objstmt_views=$pdo->prepare($query_views);
    $objstmt_views->execute([
        "id"=>$row["commande_id"],
        "views"=>$row["vues"]+1
    ]);

    $query_views_select="SELECT * FROM commandes WHERE id=:id";
    $objstmt_views_select=$pdo->prepare($query_views_select);
    $objstmt_views_select->execute([
        "id"=>$row["commande_id"]
    ]);
    $row_selected = $objstmt_views_select->fetch(PDO::FETCH_ASSOC);




?>
    <div style="float:right;color:blue;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
        </svg>
        <?php echo $row_selected["vues"] ?>
    </div>
    <h1 class="mt-5">Détail de la commande</h1>
    <form class="row g-3" method="POST">
        <div class="col-md-6">
            <label for="inputclientid" class="form-label">Client Id</label>
            <select class="form-control" name="inputclientid" disabled>
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
            <label for="inputnom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="inputnom" name="inputnom" value="<?php echo $row["nom"] ?>" disabled>
        </div>

        <div class="col-md-6">
            <label for="inputprenom" class="form-label">Prenom</label>
            <input type="text" class="form-control" id="inputprenom" name="inputprenom" value="<?php echo $row["prenom"] ?>" disabled>
        </div>

        <div class="col-md-6">
            <label for="inputmail" class="form-label">Email</label>
            <input type="text" class="form-control" id="inputmail" name="inputmail" value="<?php echo $row["email"] ?>" disabled>
        </div>

        <div class="col-md-6">
            <label for="inputville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="inputville" name="inputville" value="<?php echo $row["ville"] ?>" disabled>
        </div>


        <div class="col-md-6">
            <label for="inputdate" class="form-label">Date de commande</label>
            <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row["date_commande"] ?>" disabled>
        </div>
        <div class="col-md-6">
            <label for="inputidarticle" class="form-label">Article</label>
            <select class="form-control" name="inputidarticle" disabled>
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
            <input type="text" class="form-control" id="inputquantite" name="inputquantite" value="<?php echo $row["quantite"] ?>" disabled>
        </div>


        <div class="col-12">
            <a href="index.php" class="btn btn-primary">Fermer</a>
        </div>
    </form>
    </div>
    </main>


<?php
}
$objstmt->closeCursor();
$objstmt2->closeCursor();
$mon_objstmt->closeCursor();
$objstmt_views->closeCursor();
$objstmt_views_select->closeCursor();
include_once("footer.php");
?>
<?php
// Variable page active
$index = true;
// Header
include_once("header.php");
// Main
include_once("main.php");


$query = "SELECT
    clients.nom AS Nom,
    clients.prenom AS Prenom,
    clients.email AS Email,
    clients.ville AS Ville,
    commandes.date_commande AS DateCommande,
    commandes.id AS IdCmd,
    articles.designation AS Designation,
    articles.prix_unitaire AS PrixUnitaire,
    lignes_commande.quantite AS Quantite
    FROM clients
    JOIN commandes ON clients.id = commandes.client_id
    JOIN lignes_commande ON commandes.id = lignes_commande.commande_id
    JOIN articles ON lignes_commande.article_id = articles.id;";
$objstmt = $pdo->prepare($query);
$objstmt->execute();

?>



<h1 class="mt-5">Accueil</h1>
<table id="datatable" class="display">
    <thead>
        <tr>
            <th></th>
            <th>NOM</th>
            <th>PRENOM</th>
            <th>EMAIL</th>
            <th>VILLE</th>
            <th>DATE COMMANDE</th>
            <th>DESIGNATION</th>
            <th>PRIX UNITAIRE</th>
            <th>QUANTITE</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($ligne = $objstmt->fetch(PDO::FETCH_ASSOC)) :
        ?>
            <tr>
                <td>
                    <a href="details.php?id=<?php echo $ligne["IdCmd"] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </a>
                </td>
                <td><?php echo $ligne["Nom"]; ?></td>
                <td><?php echo $ligne["Prenom"]; ?></td>
                <td><?php echo $ligne["Email"]; ?></td>
                <td><?php echo $ligne["Ville"]; ?></td>
                <td><?php echo $ligne["DateCommande"]; ?></td>
                <td><?php echo $ligne["Designation"]; ?></td>
                <td><?php echo $ligne["PrixUnitaire"]; ?></td>
                <td><?php echo $ligne["Quantite"]; ?></td>
            </tr>

        <?php endwhile; ?>
    </tbody>
</table>
</div>
</main>

<?php
$objstmt->closeCursor();
include_once("footer.php");
?>
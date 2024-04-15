<?php
// Variable page active
$client = true;
include_once("header.php");
include_once("main.php");

$count = 0;

$list=[];

$query="SELECT id FROM clients WHERE id IN ( SELECT client_id FROM commandes WHERE client_id = clients.id)";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
foreach($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues){
    foreach($tabvalues as $tabelements){
       $list[] = $tabelements;

    }
}

?>

<h1 class="mt-5">Clients</h1>
<a href="addclient.php" class="btn btn-primary" style="float:right;margin-bottom:20px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
        <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4" />
    </svg>
</a>
<?php
$query = "select * from clients";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();
// var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
?>


<table id="datatable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOM</th>
            <th>PRENOM</th>
            <th>EMAIL</th>
            <th>VILLE</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($ligne = $pdostmt->fetch(PDO::FETCH_ASSOC)):
            $count++;
        ?>
            <tr>
                <td> <?php echo $ligne["id"]; ?> </td>
                <td> <?php echo $ligne["nom"]; ?> </td>
                <td> <?php echo $ligne["prenom"]; ?> </td>
                <td> <?php echo $ligne["email"]; ?> </td>
                <td> <?php echo $ligne["ville"]; ?> </td>
                <td>
                    <a href="modifclient.php?id=<?php echo $ligne["id"]?>" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                    <button type="button" class="btn btn-danger" <?php if(in_array($ligne["id"],$list)){echo "disabled";}?> data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $count?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </button>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="deleteModal<?php echo $count?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer ce client ? Cette action est définitive !
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <a href="deleteclient.php?id=<?php echo $ligne["id"] ?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </tbody>
</table>

</div>

</main>

<?php
include_once("footer.php");
?>
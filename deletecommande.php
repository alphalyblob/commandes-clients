<?php

include_once("main.php");
if(!empty($_GET["id"])){
    // var_dump($_GET["id"]);
    $query="DELETE FROM lignes_commande WHERE commande_id=:commande_id";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["commande_id"=>$_GET["id"]]);
    $objstmt->closeCursor();

    $query2="DELETE FROM commandes WHERE id=:id";
    $objstmt2=$pdo->prepare($query2);
    $objstmt2->execute(["id"=>$_GET["id"]]);
    $objstmt2->closeCursor();

    header("Location:commandes.php");
}

?>
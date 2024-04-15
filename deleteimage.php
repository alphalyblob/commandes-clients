<?php

include_once("main.php");

if(!empty($_GET["id"]) && !empty($_GET["idart"])){
    $query1="SELECT * FROM images WHERE id=:id";
    $objstmt1=$pdo->prepare($query1);
    $objstmt1->execute(["id"=>$_GET["id"]]);
    $row=$objstmt1->fetch(PDO::FETCH_ASSOC);
    unlink($row["chemin"]);
    $objstmt1->closeCursor();

    $query2="DELETE FROM images WHERE id=:id";
    $objstmt2=$pdo->prepare($query2);
    $objstmt2->execute(["id"=>$_GET["id"]]);
    $objstmt2->closeCursor();
    header("Location:modifarticle.php?id=".$_GET["idart"]);
}

?>
<?php
ob_start(); // Démarre la temporisation de sortie
// Onglet Clients actif car addclient = sous page de clients
$article = true;
include_once("header.php");
include_once("main.php");


    

if(!empty($_POST["inputdesignation"]) && !empty($_POST["inputprix"]) && !empty($_POST["inputstock"]) && $_FILES["inputimage"]["size"] < $_POST["MAX-FILE-SIZE"]){
    // var_dump($_FILES);
    if(!is_dir("img")){
        mkdir("img");
    }
    $extension = pathinfo($_FILES["inputimage"]["name"],PATHINFO_EXTENSION);
    if(!in_array($extension,["jpg","jpeg","png"])){
        echo "L'extension que vous avez choisie n'est pas autorisée ! Veillez à choisir un format .jpg, .jpeg ou .png !";
    }
    else{
        $path="img/".time()."_".$_FILES["inputimage"]["name"];
        $upload = move_uploaded_file($_FILES["inputimage"]["tmp_name"],$path);

        if($upload){
            $query1 = "INSERT INTO articles(designation,prix_unitaire,stock_disponible) VALUES (:designation,:prix_unitaire,:stock_disponible)";
            $pdostmt1 = $pdo->prepare($query1);
            $pdostmt1->execute([
                "designation" => $_POST["inputdesignation"],
                "prix_unitaire" => $_POST["inputprix"],
                "stock_disponible" => $_POST["inputstock"]
            ]);
            $id_article = $pdo->lastInsertId();

            $query2="INSERT INTO images(titre,chemin,taille,article_id) VALUES (:titre,:chemin,:taille,:article_id)";
            $pdostmt2 = $pdo->prepare($query2);
            $pdostmt2->execute([
                "titre" => $_FILES["inputimage"]["name"],
                "chemin" => $path,
                "taille" => $_FILES["inputimage"]["size"],
                "article_id" => $id_article
            ]);
            $pdostmt1->closeCursor();
            $pdostmt2->closeCursor();
            // echo "transfert OK";
            header("Location: articles.php");
            ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
            exit(); // Assurez-vous de terminer le script après la redirection
        }else{
            echo "transfert KO".$_FILES["inputimage"]["error"];
        }
        
    }
    
}
ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
?>

<h1 class="mt-5">Ajouter un article</h1>

<form class="row g-3" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX-FILE-SIZE" value="1000000">
    <div class="col-md-6">
        <label for="inputdesignation" class="form-label">Designation</label>
        <input type="text" class="form-control" id="inputdesignation" placeholder="Nom de l'article" name="inputdesignation" required>
    </div>
    <div class="col-md-6">
        <label for="inputprix" class="form-label">Prix unitaire</label>
        <input type="text" class="form-control" id="inputprix" placeholder="Prix de l'article" name="inputprix" required>
    </div>

    <div class="col-md-12">
        <label for="inputimage" class="form-label">Charger vos images</label>
        <input type="file" class="form-control" id="inputimage" placeholder="Image" name="inputimage" required>
        <p>PNG, JPEG, JPG</p>
    </div>


    <div class="col-12">
        <label for="inputstock" class="form-label">Stock Disponible</label>
        <input type="number" class="form-control" id="inputstock" placeholder="Stock disponible" name="inputstock" required>
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
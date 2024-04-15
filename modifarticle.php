<?php
// ob_start(); // Démarre la temporisation de sortie
// Onglet Clients actif car addclient = sous page de clients
$article = true;
include_once("header.php");
include_once("main.php");


// var_dump($_GET["id"]);

if(!empty($_POST)){
    $query1 = "UPDATE articles SET designation=:designation, prix_unitaire=:prix_unitaire, stock_disponible=:stock_disponible WHERE id=:id";
    $pdostmt1 = $pdo->prepare($query1);
    $pdostmt1->execute([
        "designation"=>$_POST["inputdesignation"],
        "prix_unitaire"=>$_POST["inputprix"],
        "stock_disponible"=>$_POST["inputstock"],
        "id"=>$_POST["myartid"]
    ]);
    // images
    if(!empty($_FILES)){
        if(!is_dir("img")){
            mkdir("img");
        }
        // var_dump($_FILES["inputimage"]);
        // die("stop");
        $total_files =count($_FILES["inputimage"]["name"]);

        for($i=0; $i<$total_files; $i++):
                $extension = pathinfo($_FILES["inputimage"]["name"][$i],PATHINFO_EXTENSION);
                if(!in_array($extension,["jpg","jpeg","png"])){
                    echo "L'extension que vous avez choisie n'est pas autorisée ! Veillez à choisir un format .jpg, .jpeg ou .png !";
                }
                else{
                    $path="img/".time()."_".$_FILES["inputimage"]["name"][$i];
                    $upload = move_uploaded_file($_FILES["inputimage"]["tmp_name"][$i],$path);
            
                    if($upload){
                        $query2="INSERT INTO images (titre,chemin,taille,article_id) VALUES (:titre,:chemin,:taille,:article_id)";
                        $pdostmt2 = $pdo->prepare($query2);
                        $pdostmt2->execute([
                            "titre" => $_FILES["inputimage"]["name"][$i],
                            "chemin" => $path,
                            "taille" => $_FILES["inputimage"]["size"][$i],
                            "article_id" => $_POST["myartid"]
                        ]);
                        $pdostmt1->closeCursor();
                        $pdostmt2->closeCursor();
                        // echo "transfert OK";
                        
                        // header("Location: articles.php");
                        // ob_end_flush(); // Envoie le tampon de sortie et éteint la temporisation de sortie
                        // exit(); // Assurez-vous de terminer le script après la redirection
                    }
                    else{
                        echo "transfert KO".$_FILES["inputimage"]["error"][$i];
                    }
                    
                }
        endfor;
        
    }

}

if (!empty($_GET["id"])) {
    $query1 = "SELECT * FROM articles WHERE id=:id";
    $pdostmt1 = $pdo->prepare($query1);
    $pdostmt1->execute([
        "id"=>$_GET["id"]
    ]);
    $row1=$pdostmt1->fetch(PDO::FETCH_ASSOC);

    $query2 = "SELECT * FROM images WHERE article_id=:article_id";
    $pdostmt2 = $pdo->prepare($query2);
    $pdostmt2->execute([
        "article_id"=>$_GET["id"]
    ]);
    
    ?>

    <h1 class="mt-5">Modifier un article</h1>

    <form class="row g-3" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX-FILE-SIZE" value="1000000">
        <input type="hidden" name="myartid" value="<?php echo $row1["id"]?>">
        <div class="col-md-6">
            <label for="inputdesignation" class="form-label">Designation</label>
            <input type="text" class="form-control" id="inputnom" placeholder="Nom de l'article" name="inputdesignation" value="<?php echo $row1["designation"]?>" required>
        </div>
        <div class="col-md-6">
            <label for="inputprix" class="form-label">Prix unitaire</label>
            <input type="text" class="form-control" id="inputprix" placeholder="Prix de l'article" name="inputprix" value="<?php echo $row1["prix_unitaire"]?>" required>
        </div>

        <div class="col-md-7">
            <label for="inputimage" class="form-label">Charger vos images</label>
            <input type="file" class="form-control" id="inputimage" placeholder="Image" name="inputimage[]" multiple>
            <p>PNG, JPEG, JPG</p>
        </div>
        <div class="col-md-5">
            <?php while($row2=$pdostmt2->fetch(PDO::FETCH_ASSOC)): ?>
                <a href="deleteimage.php?idart=<?php echo $row2["article_id"]?>&id=<?php echo $row2["id"]?>" class="btn btn-outline-danger" style="position:absolute;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                    </svg>
                </a>
                <img src="<?php echo $row2["chemin"] ?>" width="100" height="100" alt="image <?php echo $row2["titre"] ?>">
            <?php endwhile; ?>
        </div>


        <div class="col-12">
            <label for="inputstock" class="form-label">Stock disponible</label>
            <input type="number" class="form-control" id="inputstock" placeholder="Stock disponible" name="inputstock" value="<?php echo $row1["stock_disponible"]?>" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>

    </div>
    </main>

<?php
    $pdostmt1->closeCursor();
    $pdostmt2->closeCursor();

    }
?>

<?php
include_once("footer.php");
?>
<?php 
    require_once("main.php");

    $query = "CREATE TABLE IF NOT EXISTS clients (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        ville VARCHAR(20) NOT NULL
    )";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();

    $query = "CREATE TABLE IF NOT EXISTS articles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        designation VARCHAR(100) NOT NULL,
        prix_unitaire DECIMAL(10, 2) NOT NULL,
        stock_disponible INT NOT NULL
    )";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();

    $query = "CREATE TABLE IF NOT EXISTS commandes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        client_id INT NOT NULL,
        date_commande DATE,
        FOREIGN KEY (client_id) REFERENCES clients(id)
    )";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();

    $query = "CREATE TABLE IF NOT EXISTS lignes_commande (
        id INT PRIMARY KEY AUTO_INCREMENT,
        commande_id INT NOT NULL,
        article_id INT NOT NULL,
        quantite INT NOT NULL,
        FOREIGN KEY (commande_id) REFERENCES commandes(id),
        FOREIGN KEY (article_id) REFERENCES articles(id)
    )";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();

    $query = "CREATE TABLE IF NOT EXISTS images (
        id INT PRIMARY KEY AUTO_INCREMENT,
        titre VARCHAR(200) NOT NULL,
        chemin VARCHAR(200) NOT NULL,
        taille INT NOT NULL,
        article_id INT NOT NULL,
        FOREIGN KEY (article_id) REFERENCES articles(id)
    )";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();
?>
<?php
include 'db1.php';

// AJOUTER UNE TACHE
if (isset($_POST['ajouter'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];

    $sql = "INSERT INTO taches (titre, description, statut) VALUES (:titre, :description, :statut)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':statut' => $statut
    ]);

    header("Location: index2.php");
    exit;
}

// MODIFIER UNE TACHE
if (isset($_POST['modifier'])) {
    $id = intval($_POST['id']);
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];

    $sql = "UPDATE taches SET titre=:titre, description=:description, statut=:statut WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':statut' => $statut,
        ':id' => $id
    ]);

    header("Location: index2.php");
    exit;
}

// SUPPRIMER UNE TACHE
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);

    $sql = "DELETE FROM taches WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: index2.php");
    exit;
}
?>
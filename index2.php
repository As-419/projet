<?php
include 'db1.php';

// Vérifier si on est en mode modification
$edit = false;
$tache = ['id'=>'','titre'=>'','description'=>'','statut'=>'En cours'];

if (isset($_GET['modifier'])) {
    $edit = true;
    $id_mod = intval($_GET['modifier']);
    $stmt = $conn->prepare("SELECT * FROM taches WHERE id=:id");
    $stmt->execute([':id' => $id_mod]);
    $tache = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Gestion des Tâches</h1>

    <!-- Formulaire -->
    <form action="traitement2.php" method="POST" class="mb-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($tache['id']) ?>">
        <div class="mb-3">
            <input type="text" name="titre" class="form-control" placeholder="Titre" required value="<?= htmlspecialchars($tache['titre']) ?>">
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control" placeholder="Description"><?= htmlspecialchars($tache['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <select name="statut" class="form-select">
                <option value="En cours" <?= $tache['statut']=='En cours' ? 'selected' : '' ?>>En cours</option>
                <option value="Terminé" <?= $tache['statut']=='Terminé' ? 'selected' : '' ?>>Terminé</option>
            </select>
        </div>
        <button type="submit" name="<?= $edit ? 'modifier' : 'ajouter' ?>" class="btn btn-primary">
            <?= $edit ? 'Modifier la tâche' : 'Ajouter la tâche' ?>
        </button>
        <?php if($edit): ?>
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        <?php endif; ?>
    </form>

    <!-- Liste des tâches -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $conn->query("SELECT * FROM taches ORDER BY id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['titre']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['statut']) ?></td>
                <td>
                    <a href="index2.php?modifier=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="traitement2.php?supprimer=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette tâche ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
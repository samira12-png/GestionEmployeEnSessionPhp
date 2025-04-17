<?php
session_start();


if (!isset($_SESSION['employes'])) {
    $_SESSION['employes'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body>
<div class="container my-5">
        <h1 class="text-center mb-4">Liste des Employés</h1>
        <div class="text-end mb-3">
            <a href="AddEmpsess.php" class="btn btn-success">Ajouter un Employé</a>
        </div>
        <div class="card-list">
            <?php foreach ($_SESSION['employes'] as $employee): ?>
                <div class="card">
                    <img src="<?php echo $employee['image']; ?>" alt="Image de <?php echo $employee['nom']; ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $employee['nom']; ?></h5>
                        <p class="card-text">Email: <?php echo $employee['email']; ?></p>
                        <a href="updateEmpsess.php?matricule=<?php echo $employee['matricule']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="deleteEmpsess.php?matricule=<?php echo $employee['matricule']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>
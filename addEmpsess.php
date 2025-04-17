<?php
session_start();
$errors=[];
$validExt = ['png', 'jpeg', 'gif', 'jpg'];



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $matricule = htmlspecialchars(trim($_POST['matricule']));
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $linkedin = $_POST['linkedin'];
    $image = $_FILES['image'];
    $cv = $_FILES['cv'];

    // Validation du matricule
    if (empty($matricule)) {
        $errors['errorMatricule'] = "Le matricule est vide.";
    } elseif ($matricule < 1000 || $matricule > 5000) {
        $errors['errorMatricule'] = "Le matricule doit être compris entre 1000 et 5000.";
    }

    // Validation du nom
    if (empty($nom)) {
        $errors['errorNom'] = "Le nom est vide.";
    } elseif (strlen($nom) < 3) {
        $errors['errorNom'] = "Le nom doit contenir au moins 3 caractères alphabétiques.";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors['errorEmail'] = "L'email est vide.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['errorEmail'] = "L'email n'est pas valide.";
    }

    // Validation du profil LinkedIn
    if (empty($linkedin)) {
        $errors['errorLinkedIn'] = "Le lien LinkedIn est vide.";
    } elseif (!filter_var($linkedin, FILTER_VALIDATE_URL)) {
        $errors['errorLinkedIn'] = "Le profil LinkedIn doit être une URL valide.";
    }

    // Validation de l'image
    if (empty($image['name'])) {
        $errors['errorImage'] = "L'image est obligatoire.";
    } elseif ($image['error'] != 0) {
        $errors['errorImage'] = "Erreur de chargement de l'image.";
    } else {
        $tempDir = $image['tmp_name'];
        $fileName = $image['name'];
        $size = $image['size'];
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array($extension, $validExt)) {
            $errors['errorImage'] = "L'image choisie est invalide (format autorisé: png, jpeg, gif, jpg).";
        }
    }

    // Validation du CV
    if ($cv['error'] == 0) {
        $cvType = mime_content_type($cv['tmp_name']);
        if ($cvType != 'application/pdf') {
            $errors['errorCV'] = "Le CV doit être un fichier PDF.";
        }
    } elseif ($cv['error'] != 0) {
        $errors['errorCV'] = "Erreur de chargement du CV.";
    }



    if (empty($errors)) {
        $newImageName = "images/" . uniqid() . "." . $extension;
        move_uploaded_file($tempDir, $newImageName);

        $cvPath = 'cv/' . uniqid() . ".pdf";
        move_uploaded_file($cv['tmp_name'], $cvPath);

        $newEmployee = [
            "matricule" => $matricule,
            "nom" => $nom,
            "email" => $email,
            "linkedin" => $linkedin,
            "image" => $newImageName,
            "cv" => $cvPath
        ];


        $_SESSION['employes'][] = $newEmployee;

        

        header('Location: indexEmpsess.php');
        exit;
    }

}
?>



















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
    <div class="container p-4 w-75 my-5">
    <h1 class="text-center">Gérer une liste des employés</h1>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="border border-5 p-3 border-secandary" method="post" style="background-color:rgb(201, 186, 186);
" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="matricule">Matricule:</label>
                <input type="number" class="form-control" name="matricule" />
                <div class="text-danger"><?= isset($errors['errorMatricule']) ? $errors['errorMatricule'] : '' ?></div>
            </div>
            <div class="mb-2">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" name="nom" />
                <div class="text-danger"><?= isset($errors['errorNom']) ? $errors['errorNom'] : '' ?></div>
            </div>
            <div class="mb-2">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" />
                <div class="text-danger"><?= isset($errors['errorEmail']) ? $errors['errorEmail'] : '' ?></div>
            </div>
            <div class="mb-2">
                <label for="image">Image:</label>
                <input type="file" class="form-control" name="image" />
                <div class="text-danger"><?= isset($errors['errorImage']) ? $errors['errorImage'] : '' ?></div>
            </div>
            <div class="mb-2">
                <label for="cv">CV (PDF):</label>
                <input type="file" class="form-control" name="cv" accept="application/pdf"/>
                <div class="text-danger"><?= isset($errors['errorCV']) ? $errors['errorCV'] : '' ?></div>
            </div>
            <div class="mb-2">
                <label for="linkedin">LinkedIn URL:</label>
                <input type="url" class="form-control" name="linkedin" />
                <div class="text-danger"><?= isset($errors['errorLinkedIn']) ? $errors['errorLinkedIn'] : '' ?></div>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-sm btn-info">Ajouter</button>
                <a href="indexEmpsess.php" class="btn btn-secondary">Cancel</a>

            </div>
        </form>
    </div>
</body>
</html>
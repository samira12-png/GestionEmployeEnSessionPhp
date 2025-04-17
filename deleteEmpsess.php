<?php
session_start();


if (!isset($_SESSION['employes'])) {
    $_SESSION['employes'] = [];
}

 if(isset($_GET['matricule'])){
    $matricule = $_GET['matricule'];
    array_splice($_SESSION['employes'],$matricule);
    header("Location: indexEmpsess.php");
    exit;
 }
<?php
require 'includes/db.php';
require 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = sanitizeInput($_POST['nom']);
    $prenom = sanitizeInput($_POST['prenom']);
    $telephone = sanitizeInput($_POST['telephone']);
    $email = sanitizeInput($_POST['email']);
    $mdp = password_hash(sanitizeInput($_POST['mdp']), PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO client (nom, prenom, telephone, email, mdp) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nom, $prenom, $telephone, $email, $mdp])) {
        header('Location: index.php?signup=success');
        exit();
    } else {
        echo "Une erreur est survenue lors de l'inscription.";
    }
}
?>
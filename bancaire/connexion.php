<?php
require 'includes/db.php';
require 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST['email']);
    $mdp = sanitizeInput($_POST['mdp']);

    $stmt = $pdo->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->execute([$email]);
    $client = $stmt->fetch();

    if ($client && password_verify($mdp, $client['mdp'])) {
        session_start();
        $_SESSION['client_id'] = $client['clientId'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Erreur de connexion. Veuillez vérifier vos identifiants.";
    }
}
?>

<link rel="stylesheet" href="style.css">

<form method="POST" action="connexion.php">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="mdp">Mot de passe</label>
        <input type="password" class="form-control" id="mdp" name="mdp" required>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
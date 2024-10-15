<?php
session_start();


if (isset($_SESSION['client_id'])) {
    $clientId = $_SESSION['client_id'];
    $message = "Bienvenue, votre ID client est : " . $clientId;
} else {
    $message = "Bienvenue sur votre espace bancaire. Veuillez vous connecter ou vous inscrire.";
}


if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
    $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil bancaire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $message; ?></h1>

        <?php if (!isset($_SESSION['client_id'])): ?>
            <a href="inscriptions.php" class="btn btn-primary">S'inscrire</a>
            <a href="connexion.php" class="btn btn-secondary">Se connecter</a>
        <?php else: ?>
            <a href="dashboard.php" class="btn btn-success">Accéder à votre tableau de bord</a>
        <?php endif; ?>
    </div>
</body>
</html>
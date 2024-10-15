<?php
require 'includes/db.php';
require 'includes/functions.php';
checkSession();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroCompte = sanitizeInput($_POST['numeroCompte']);
    $solde = sanitizeInput($_POST['solde']);
    $typeDeCompte = sanitizeInput($_POST['typeDeCompte']);
    $clientId = $_SESSION['client_id'];

    if ($solde >= 10 && $solde <= 2000) {
        $stmt = $pdo->prepare("INSERT INTO comptebancaire (numeroCompte, solde, typeDeCompte, clientId) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$numeroCompte, $solde, $typeDeCompte, $clientId])) {
            header('Location: dashboard.php');
        }
    }
}
?>

<link rel="stylesheet" href="style.css">

<form method="POST" action="ajouter_compte.php" class="form-container">
    <div class="form-group">
        <label for="numeroCompte">Numéro de compte</label>
        <input type="text" class="form-control" id="numeroCompte" name="numeroCompte" required>
    </div>
    <div class="form-group">
        <label for="solde">Solde</label>
        <input type="number" class="form-control" id="solde" name="solde" min="10" max="2000" required>
    </div>
    <div class="form-group">
        <label for="typeDeCompte">Type de compte</label>
        <select class="form-control" id="typeDeCompte" name="typeDeCompte" required>
            <option value="courant">Courant</option>
            <option value="epargne">Épargne</option>
            <option value="entreprise">Entreprise</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Créer compte</button>
</form>
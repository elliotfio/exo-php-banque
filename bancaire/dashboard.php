<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

checkSession(); 


$clientId = $_SESSION['client_id'];
$stmt = $pdo->prepare("SELECT * FROM comptebancaire WHERE clientId = ?");
$stmt->execute([$clientId]);
$compte = $stmt->fetch();

if (!$compte) {
    echo "Aucun compte trouvé.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $montant = sanitizeInput($_POST['montant']);
    
    if (isset($_POST['action']) && $_POST['action'] == 'depot') {
        if ($montant > 0) {
            $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde + ? WHERE clientId = ?");
            $stmt->execute([$montant, $clientId]);
            echo "<p style='color:green;'>Dépôt réussi.</p>";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'retrait') {
        if ($montant > 0 && $compte['solde'] >= $montant) {
            $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde - ? WHERE clientId = ?");
            $stmt->execute([$montant, $clientId]);
            echo "<p style='color:green;'>Retrait réussi.</p>";
        } else {
            echo "<p style='color:red;'>Solde insuffisant pour le retrait.</p>";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'virement') {
        $compteDestinataire = sanitizeInput($_POST['compte_destinataire']);
        if ($montant > 0 && $compte['solde'] >= $montant) {
            $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde - ? WHERE clientId = ?");
            $stmt->execute([$montant, $clientId]);

            $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde + ? WHERE numeroCompte = ?");
            $stmt->execute([$montant, $compteDestinataire]);

            echo "<p style='color:green;'>Virement réussi.</p>";
        } else {
            echo "<p style='color:red;'>Solde insuffisant ou compte destinataire invalide.</p>";
        }
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="dashboard-container">
    <div class="account-info">
        <h1>Tableau de bord</h1>
        <h3>Bienvenue, voici votre compte</h3>
        <p>Numéro de compte : <?php echo $compte['numeroCompte']; ?></p>
        <p>Solde : <?php echo number_format($compte['solde'], 2); ?> €</p>
    </div>


    <div class="action-cards">
        <div class="card">
            <h3>Montant du dépôt</h3>
            <form method="POST" action="dashboard.php">
                <input type="hidden" name="action" value="depot">
                <input type="number" id="montant" name="montant" required placeholder="Montant">
                <button type="submit">Déposer</button>
            </form>
        </div>

        <div class="card">
            <h3>Montant du retrait</h3>
            <form method="POST" action="dashboard.php">
                <input type="hidden" name="action" value="retrait">
                <input type="number" id="montant" name="montant" required placeholder="Montant">
                <button type="submit">Retirer</button>
            </form>
        </div>


        <div class="card">
            <h3>Montant du virement</h3>
            <form method="POST" action="dashboard.php">
                <input type="hidden" name="action" value="virement">
                <input type="number" id="montant" name="montant" required placeholder="Montant">
                <input type="text" id="compte_destinataire" name="compte_destinataire" required placeholder="Numéro du compte destinataire">
                <button type="submit">Virer</button>
            </form>
        </div>
    </div>
</div>
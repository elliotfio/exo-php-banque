<?php
require 'includes/db.php';
require 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = sanitizeInput($_POST['nom']);
    $prenom = sanitizeInput($_POST['prenom']);
    $telephone = sanitizeInput($_POST['telephone']);
    $email = sanitizeInput($_POST['email']);
    $mdp = hashPassword($_POST['mdp']);

    $stmt = $pdo->prepare("INSERT INTO client (nom, prenom, telephone, email, mdp) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nom, $prenom, $telephone, $email, $mdp])) {
        header('Location: index.php?signup=success');
        exit();
    }
}
?>

<link rel="stylesheet" href="style.css">

<form method="POST" action="ajouter_client.php">
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" required>
    </div>
    <div class="form-group">
        <label for="telephone">Téléphone</label>
        <input type="tel" class="form-control" id="telephone" name="telephone">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="mdp">Mot de passe</label>
        <input type="password" class="form-control" id="mdp" name="mdp" required>
    </div>
    <button type="submit" class="btn btn-primary">S’inscrire</button>
</form>


<script>
document.querySelector('form').addEventListener('submit', function(event) {
    var numeroCompte = document.getElementById('numeroCompte') ? document.getElementById('numeroCompte').value : '';
    var solde = document.getElementById('solde') ? document.getElementById('solde').value : '';
    var typeDeCompte = document.getElementById('typeDeCompte') ? document.getElementById('typeDeCompte').value : '';
    var mdp = document.getElementById('mdp').value;

    if (numeroCompte && (numeroCompte.length < 5 || numeroCompte.length > 15)) {
        alert('Le numéro de compte doit contenir entre 5 et 15 caractères.');
        event.preventDefault();
    }

    if (solde && (solde < 10 || solde > 2000)) {
        alert('Le solde doit être compris entre 10 et 2000.');
        event.preventDefault();
    }

    if (typeDeCompte && ['courant', 'epargne', 'entreprise'].indexOf(typeDeCompte) === -1) {
        alert('Le type de compte est invalide.');
        event.preventDefault();
    }

    if (mdp.indexOf(' ') >= 0) {
        alert('Le mot de passe ne doit pas contenir d\'espaces.');
        event.preventDefault();
    }
});
</script>
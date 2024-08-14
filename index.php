<?php
// local
// $dbname = "test";
// $servername = "localhost";
// $username = "root";
// $password = "root";

$servername = ""; // Remplacez par le nom de votre serveur MySQL
$username = ""; // Remplacez par votre nom d'utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$dbname = ""; // Remplacez par le nom de votre base de données

// Créez une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Dossier contenant les fichiers .sql
$directory = 'Meteo/'; // Remplacez par le chemin vers votre dossier

// Parcourir tous les fichiers .sql dans le dossier
$files = glob($directory . "*.sql");

foreach ($files as $file) {
    // Lire le contenu du fichier SQL
    $sql = file_get_contents($file);

    // Exécuter les requêtes SQL
    if ($conn->multi_query($sql)) {
        do {
            // Stocker les résultats
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());

        echo "Le fichier " . basename($file) . " a été importé avec succès.\n";
    } else {
        echo "Erreur lors de l'importation de " . basename($file) . ": " . $conn->error . "\n";
    }
}

// Fermer la connexion
$conn->close();

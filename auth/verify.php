<?php

if (!isset($_POST['user']) || !isset($_POST['password'])) {
    echo "ERROR V1: Alla fält inte satta!";
    exit;
}

$user;

// Notera att prestanda minskar med antalet användare i json filen,
// men det fungerar som en exempel-databas
$json = file_get_contents("users.json");
if ($json === false) {
    echo "ERROR V2: Kan inte komma åt databas!";
    exit;
} else {
    // Sätt in innehållet av users arrayen i users
    // Om användare finns, sätt $user till den arrayen
    $user = isset(json_decode($json)[$_POST['user']]) ? json_decode($json)[$_POST['user']] : false;
    if ($user == false) {
        // Ge samma fel vid fel användarnamn eller lösenord
        echo "ERROR V3: Fel namn eller lösenord!";
        exit;
    }
}

$salt = "!@^-.4"; // Varning, detta är inte en säker lösning, följ kryptografiska
                  // hjälpsidor för att säkrare kryptera lösenord
if (strtolower(hash("sha256", $salt+$_POST['password'])) != strtolower($user['password'])) {
    // Ge samma fel vid fel användarnamn eller lösenord
    echo "ERROR V3: Fel namn eller lösenord!";
    exit;
} else {
    // Användare är inloggad
    // I ett verkligt scenario, ge tillbaka en token och spara samma token i en relationsdatabas till users,
    // för att öka säkerheten och skapa en potentiell automatisk inloggning
    echo "LOGGED IN";
}

?>
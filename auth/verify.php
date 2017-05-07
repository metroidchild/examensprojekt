<?php

// Försäkra oss att både användarnamn och lösenord är tillgängliga
if (!isset($_GET['user']) || !isset($_GET['password'])) {
    echo "ERROR V1: Alla fält inte satta!\r\n";
    exit;
}

$user;

// Notera att prestanda minskar med antalet användare i json filen,
// men det fungerar som en exempel-databas
$json = file_get_contents('users.json');
if ($json === false) {
    echo "ERROR V2: Kan inte komma åt databas!\r\n";
    exit;
} else {
    // Sätt in innehållet av users arrayen i users
    // Om användare finns, sätt $user till den arrayen
    $decode = json_decode($json);
    $user = property_exists($decode->{'users'},$_GET['user']) ? $decode->{'users'}->{$_GET['user']} : false;
    if ($user == false) {
        // Ge samma fel vid fel användarnamn eller lösenord
        echo "ERROR V3: Fel namn eller lösenord!\r\n";
        exit;
    }
}

// Salt för lösenord
$salt = "!@^-.4"; // Varning, detta är inte en säker lösning, följ kryptografiska
                  // hjälpsidor för att säkrare kryptera lösenord
if (!hash_equals(hash("sha256", $_GET['password']+$salt), strtolower($user->{'password'}))) {
    // Ge samma fel vid fel användarnamn eller lösenord
    echo "ERROR V4: Fel namn eller lösenord!\r\n";
    exit;
} else {
    // Användare är inloggad
    // I ett verkligt scenario, ge tillbaka en token och spara samma token i en relationsdatabas till users,
    // för att öka säkerheten och skapa en potentiell automatisk inloggning
    echo "LOGGED IN";
}

?>
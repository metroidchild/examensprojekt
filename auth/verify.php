<?php

echo "<pre>\r\n";

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
    echo "Hittade databas!\r\n";
    // Sätt in innehållet av users arrayen i users
    // Om användare finns, sätt $user till den arrayen
    $decode = json_decode($json);
    var_dump($decode);
    var_dump($decode['users']);
    var_dump($decode['users'][$_GET['user']]);
    $user = (isset($decode['users'][$_GET['user']]) ? $decode['users'][$_GET['user']] : false);
    if ($user == false) {
        // Ge samma fel vid fel användarnamn eller lösenord
        echo "ERROR V3: Fel namn eller lösenord!\r\n";
        exit;
    } else {
        echo "Hittade användare!\r\n";
    }
}

$salt = "!@^-.4"; // Varning, detta är inte en säker lösning, följ kryptografiska
                  // hjälpsidor för att säkrare kryptera lösenord
if (strtolower(hash("sha256", $salt+$_GET['password'])) != strtolower($user['password'])) {
    // Ge samma fel vid fel användarnamn eller lösenord
    echo "ERROR V3: Fel namn eller lösenord!\r\n";
    exit;
} else {
    echo "Rätt lösenord!\r\n";
    // Användare är inloggad
    // I ett verkligt scenario, ge tillbaka en token och spara samma token i en relationsdatabas till users,
    // för att öka säkerheten och skapa en potentiell automatisk inloggning
    echo "LOGGED IN";
}

?>
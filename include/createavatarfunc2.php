<?php
// Avatar eintragen 
// $statement = $pdo->prepare("INSERT INTO UserAccounts (email, vorname, nachname) VALUES (:email, :vorname, :nachname)");
$statement = $pdo->prepare("INSERT INTO UserAccounts (PrincipalID, ScopeID, FirstName, LastName, Email, ServiceURLs, Created, UserLevel, UserFlags, UserTitle, active) VALUES (:PrincipalID, :ScopeID, :FirstName, :LastName, :Email, :ServiceURLs, :Created, :UserLevel, :UserFlags, :UserTitle, :active)");
$statement->execute($neuer_user); 

function AvatarEintragen($pdo, $benutzeruuid, $osVorname, $osNachname, $osEMail, $osDatum) {
    $neuer_user = [
        'PrincipalID' => $benutzeruuid,
        'ScopeID' => '00000000-0000-0000-0000-000000000000',
        'FirstName' => $osVorname,
        'LastName' => $osNachname,
        'Email' => $osEMail,
        'ServiceURLs' => 'HomeURI= InventoryServerURI= AssetServerURI=',
        'Created' => $osDatum,
        'UserLevel' => '0',
        'UserFlags' => '0',
        'UserTitle' => '',
        'active' => '1'
    ];
    
    $statement = $pdo->prepare("
        INSERT INTO UserAccounts 
        (PrincipalID, ScopeID, FirstName, LastName, Email, ServiceURLs, Created, UserLevel, UserFlags, UserTitle, active) 
        VALUES 
        (:PrincipalID, :ScopeID, :FirstName, :LastName, :Email, :ServiceURLs, :Created, :UserLevel, :UserFlags, :UserTitle, :active)
    ");
    
    return $statement->execute($neuer_user);
} 

// UUID, passwordHash, passwordSalt, webLoginKey, accountType
function passwortEintragen($pdo, $benutzeruuid, $osHash, $osSalt) {
    $neues_passwd = [
        'UUID' => $benutzeruuid,
        'passwordHash' => $osHash,
        'passwordSalt' => $osSalt,
        'webLoginKey' => '00000000-0000-0000-0000-000000000000',
        'accountType' => 'UserAccount'
    ];

    $statement = $pdo->prepare("
        INSERT INTO auth (UUID, passwordHash, passwordSalt, webLoginKey, accountType) 
        VALUES (:UUID, :passwordHash, :passwordSalt, :webLoginKey, :accountType)
    ");
    
    return $statement->execute($neues_passwd);
}

// Inventarverzeichnisse erstellen

// Ordner Textures
function texturenOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Texturesuuid = uuidv4();

    $verzeichnistextur = [
        'folderName' => 'Textures',
        'type' => '0',
        'version' => '1',
        'folderID' => $Texturesuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnistextur);
}

// Ordner Sounds
function soundsOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Soundsuuid = uuidv4();

    $verzeichnisSounds = [
        'folderName' => 'Sounds',
        'type' => '1',
        'version' => '1',
        'folderID' => $Soundsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisSounds);
}

// Ordner Calling Cards
function callingCardsOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $CallingCardsuuid = uuidv4();

    $verzeichnisCallingCards = [
        'folderName' => 'Calling Cards',
        'type' => '2',
        'version' => '2',
        'folderID' => $CallingCardsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisCallingCards);
}

// Ordner Landmarks
function landmarksOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Landmarksuuid = uuidv4();

    $verzeichnisLandmarks = [
        'folderName' => 'Landmarks',
        'type' => '3',
        'version' => '1',
        'folderID' => $Landmarksuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisLandmarks);
}

function myInventoryEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $verzeichnisMyInventory = [
        'folderName' => 'My Inventory',
        'type' => '8',
        'version' => '17',
        'folderID' => $neuHauptFolderID,
        'agentID' => $benutzeruuid,
        'parentFolderID' => '00000000-0000-0000-0000-000000000000'
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisMyInventory);
}

function photoAlbumEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $PhotoAlbumuuid = uuidv4();

    $verzeichnisPhotoAlbum = [
        'folderName' => 'Photo Album',
        'type' => '15',
        'version' => '1',
        'folderID' => $PhotoAlbumuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisPhotoAlbum);
}

function clothingEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Clothinguuid = uuidv4();

    $verzeichnisClothing = [
        'folderName' => 'Clothing',
        'type' => '5',
        'version' => '3',
        'folderID' => $Clothinguuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisClothing);
}

function objectsEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Objectsuuid = uuidv4();

    $verzeichnisObjects = [
        'folderName' => 'Objects',
        'type' => '6',
        'version' => '1',
        'folderID' => $Objectsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisObjects);
}

function notecardsEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Notecardsuuid = uuidv4();

    $verzeichnisNotecards = [
        'folderName' => 'Notecards',
        'type' => '7',
        'version' => '1',
        'folderID' => $Notecardsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisNotecards);
}

function scriptsEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Scriptsuuid = uuidv4();

    $verzeichnisScripts = [
        'folderName' => 'Scripts',
        'type' => '10',
        'version' => '1',
        'folderID' => $Scriptsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisScripts);
}

function bodyPartsEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $BodyPartsuuid = uuidv4();

    $verzeichnisBodyParts = [
        'folderName' => 'Body Parts',
        'type' => '13',
        'version' => '5',
        'folderID' => $BodyPartsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisBodyParts);
}

function trashEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Trashuuid = uuidv4();

    $verzeichnisTrash = [
        'folderName' => 'Trash',
        'type' => '14',
        'version' => '1',
        'folderID' => $Trashuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisTrash);
}

function lostAndFoundEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $LostAndFounduuid = uuidv4();

    $verzeichnisLostAndFound = [
        'folderName' => 'Lost And Found',
        'type' => '16',
        'version' => '1',
        'folderID' => $LostAndFounduuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisLostAndFound);
}

function animationsEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Animationsuuid = uuidv4();

    $verzeichnisAnimations = [
        'folderName' => 'Animations',
        'type' => '20',
        'version' => '1',
        'folderID' => $Animationsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisAnimations);
}

function gesturesEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Gesturesuuid = uuidv4();

    $verzeichnisGestures = [
        'folderName' => 'Gestures',
        'type' => '21',
        'version' => '1',
        'folderID' => $Gesturesuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisGestures);
}

function friendsEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Friendsuuid = uuidv4();

    $verzeichnisFriends = [
        'folderName' => 'Friends',
        'type' => '2',
        'version' => '2',
        'folderID' => $Friendsuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisFriends);
}

function favoritesEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Favoritesuuid = uuidv4();

    $verzeichnisFavorites = [
        'folderName' => 'Favorites',
        'type' => '23',
        'version' => '1',
        'folderID' => $Favoritesuuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisFavorites);
}

function currentOutfitEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $CurrentOutfituuid = uuidv4();

    $verzeichnisCurrentOutfit = [
        'folderName' => 'Current Outfit',
        'type' => '46',
        'version' => '1',
        'folderID' => $CurrentOutfituuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisCurrentOutfit);
}

function allEintragen($pdo, $benutzeruuid, $neuHauptFolderID) {
    $Alluuid = uuidv4();

    $verzeichnisAll = [
        'folderName' => 'All',
        'type' => '2',
        'version' => '1',
        'folderID' => $Alluuid,
        'agentID' => $benutzeruuid,
        'parentFolderID' => $neuHauptFolderID
    ];

    $statement = $pdo->prepare("
        INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) 
        VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)
    ");
    
    return $statement->execute($verzeichnisAll);
}

// Benutzung der Funktionen:
$resultbenutzer = benutzerEintragen($pdo, $benutzeruuid, $osVorname, $osNachname, $osEMail, $osDatum);
$resultpasswort = passwortEintragen($pdo, $benutzeruuid, $osHash, $osSalt);
$resulttexturenOrdner = texturenOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultsoundsOrdner = soundsOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultcallingCardsOrdner = callingCardsOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultlandmarksOrdner = landmarksOrdnerErstellen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultMyInventory = myInventoryEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultPhotoAlbum = photoAlbumEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultClothing = clothingEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultObjects = objectsEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultNotecards = notecardsEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultScripts = scriptsEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultBodyParts = bodyPartsEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultTrash = trashEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultLostAndFound = lostAndFoundEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultAnimations = animationsEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultGestures = gesturesEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultFriends = friendsEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultFavorites = favoritesEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultCurrentOutfit = currentOutfitEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
$resultAll = allEintragen($pdo, $benutzeruuid, $neuHauptFolderID);
?>

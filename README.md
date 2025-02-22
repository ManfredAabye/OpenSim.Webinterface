# OpenSim.Webinterface
Webinterface/Webseiten für den OpenSimulator in PHP 8.3

Hier entsteht ein Webinterface für den OpenSimulator dieser ist noch nicht voll funktionsfähig.

Das Webinterface hat die Aufgabe, die in der Robust.ini aufgeführten Seiten zu unterstützen.

Eine Unterstützung für Economy ist nicht mehr erforderlich, ich möchte aber eine kleine Übersicht des Kontos der Nutzer bereitstellen.

---

A web interface for the OpenSimulator is being created here. It is not yet fully functional.

The web interface is designed to support the pages listed in Robust.ini.

Economy support is no longer required, but I would like to provide a small overview of the user's account.

---

## Informationen

### Seiten
* aboutinformation.php - Informationen und Besitzerdaten.  **Funktioniert**
* avatarpicker.php - Einen Avatar auswählen.
* destinations - Besondere Zielorte des Grids.  **Funktioniert**
* economycashbook.php - Ein kleines Kassenbuch um einnahmen ausgaben anzuzeigen für den MoneyServer. **Funktioniert**
* gridstatus.php - Der Gridstatus des Grids.  **Funktioniert**
* gridstatusrss.php - RSS feeds über den Gridstatus des Grids. **Funktioniert**
* guide.php - Besondere Zielorte des Grids der über den Viewer abgerufen wird.  **Funktioniert**
* help.php - Hilfestellung wie man ins Grid kommt etc.  **Funktioniert**
* index.php - Eine Hilfsseite mit der man die einzelnen Seiten aufrufen kann.  **Funktioniert**
* maptile.php - Eine Karte aufrufen.  **Funktioniert**
* partner.php - Partnerschaften mit anderen Usern eingehen oder beenden.
* passwordreset.php - Ein neues Passwort einstellen. **Funktioniert**
* createavatar.php - Eine Benutzerregistration. **Funktioniert**
* searchservice.php - Suchfunktion für Orte oder mehr.
* welcomesplashpage.php - Die Welcome Splash Seite mit Informationen zum Grid.  **Funktioniert**
* listinventar.php - Listet das Inventar auf.  **Funktioniert**
* iarservice.php - Inventar Sichern oder IAR hochladen.  **Funktioniert**

### destinations - Bilder für die Guide/Destinations.
* destinations/Infopunkt1.png
* destinations/Infopunkt2.png
* destinations/Infopunkt3.png
* destinations/Infopunkt4.png
* destinations/Infopunkt5.png
* destinations/Infopunkt6.png
* destinations/Infopunkt7.png
* destinations/Infopunkt8.png
* destinations/Infopunkt9.png

### images - welcomesplashpage Hintergrundbilder.
* images/1_001.png
* images/2_001.png
* images/3_001.png
* images/4_001.png
* images/5_001.png
* images/6_001.png
* images/7_001.png
* images/8_001.png
* images/9_001.png

### include - Diverse Einstellungen für das Grid und das Webinterface.
* include/config.php
* include/destinations.json
* include/favicon.ico
* include/favicon.png
* include/footer.php
* include/header.php
* include/index.html
* include/Metavers150.png

### pics - Diverse Bilder und Icons
* pics/background.jpg
* pics/index.html
* pics/logo.png
* pics/mhpann.png
* pics/transparent.png

---

## TODO

22.02.2025

3 Templates sind verfügbar, Bootstrap5 und W3.css wurden hinzugefügt, es ist einstellbar in der config.php.

createavatar.php - sendet eine Registrierungs-UUID per E-Mail an die angegebene Adresse des neuen Benutzers. Der Prozess wartet auf die korrekte Eingabe der UUID, bevor der Benutzer registriert wird. Dabei muss die E-Mail-Adresse eindeutig sein.

passwordreset.php - sendet eine Bestätigungs-UUID per E-Mail an die Adresse des Benutzers. Der Prozess wartet auf die korrekte Eingabe der UUID, bevor das Passwort des Benutzers zurückgesetzt wird.


21.02.2025 Avatar Registration funktioniert jetzt soweit und neues Passwort setzen funktioniert teilweise.

14.02.2025 Mit der neuen guide.php lassen sich ausgesuchte Regionen präsentieren, alle Regionen im Grid anwählen, bis zu 293 Grids direkt hin teleportieren.

14.02.2025 With the new guide.php you can present selected regions, select all regions in the grid, and teleport directly to up to 293 grids.

09.02.2025 Farbspielerei eingefügt.

10.02.2025 Alles überarbeitet, Passwortgenerator hinzugefügt, über 700 Fehler beseitigt.

* MapTileURL = "${Const|BaseURL}:${Const|PublicPort}/webinterface/maptile.php" ; **Funktioniert**
* SearchURL = "${Const|BaseURL}:${Const|PublicPort}/webinterface/searchservice.php" ; **Funktioniert**
* DestinationGuide = "${Const|BaseURL}/webinterface/guide.php" ; **Funktioniert**
* AvatarPicker = "${Const|BaseURL}/webinterface/avatarpicker.php" ; **Funktioniert noch nicht es gibt eine Platzhalter Datei.**
* welcome = ${Const|BaseURL}/webinterface/welcomesplashpage.php ; **Funktioniert**
* economy = ${Const|BaseURL}:8008/ ; **Funktioniert ist aber im neuen dotnet MoneyServer von mir.**
* about = ${Const|BaseURL}/webinterface/aboutinformation.php ; **Funktioniert**
* register = ${Const|BaseURL}/webinterface/registeruser.php ; **Funktioniert**
* help = ${Const|BaseURL}/webinterface/help.php ; **Funktioniert**
* password = ${Const|BaseURL}/webinterface/passwordreset.php ; **Funktioniert**
* partner = ${Const|BaseURL}/webinterface/partner.php ; **Funktioniert**
* GridStatus = ${Const|BaseURL}:${Const|PublicPort}/webinterface/gridstatus.php ; **Funktioniert**

---

# OpenSim.Webinterface
Webinterface PHP 8.3

Hier entsteht ein Webinterface für den OpenSimulator dieser ist noch nicht voll funktionsfähig.

Das Webinterface hat die Aufgabe, die in der Robust.ini aufgeführten Seiten zu unterstützen.

Eine Unterstützung für Economy ist nicht mehr erforderlich, ich möchte aber eine kleine Übersicht des Kontos der Nutzer bereitstellen.

---

A web interface for the OpenSimulator is being created here. It is not yet fully functional.

The web interface is designed to support the pages listed in Robust.ini.

Economy support is no longer required, but I would like to provide a small overview of the user's account.

---

## Informationen

* aboutinformation.php	
* avatarpicker.php	
* economycashbook.php	
* gridlist.php	
* gridstatus.php	
* gridstatusrss.php	
* guide.php	
* help.php	
* iarservice.php	
* icecast.php	
* index.html	
* index.php	
* inventory.php	
* listinventar.php	
* maptile.php	
* message.php	
* mute.php	
* mutelist.php	
* OpenSimExample.ini	
* partner.php	
* passwordreset.php	
* picreader.php	
* registeruser.php	
* RobustExample.ini	
* searchservice.php	
* tabledata.php	
* welcomesplashpage.php	
	
* cache	00000000-0000-0000-0000-000000000001.jpg
* cache	00000000-0000-0000-0000-000000000002.jpg
* cache	index.html
	
* destinations	index.html
* destinations	Infopunkt1.png
* destinations	Infopunkt2.png
* destinations	Infopunkt3.png
* destinations	Infopunkt4.png
* destinations	Infopunkt5.png
* destinations	Infopunkt6.png
* destinations	Infopunkt7.png
* destinations	Infopunkt8.png
* destinations	Infopunkt9.png

* images	1_001.png
* images	2_001.png
* images	3_001.png
* images	4_001.png
* images	5_001.png
* images	6_001.png
* images	7_001.png
* images	8_001.png
* images	9_001.png
* images	index.html

* include	config.example.php
* include	configurator.php.offline
* include	destinations.json
* include	dmca.php
* include	favicon.ico
* include	favicon.png
* include	footer.php
* include	gridlist.csv
* include	header.php
* include	image.php
* include	index.html
* include	Metavers150.png
* include	paswd_generator.php
* include	tos.php
* include	webseite.jpg
	
* outfits	default.jpg

* pics	00000000-0000-0000-0000-000000000001.jpg
* pics	00000000-0000-0000-0000-000000000002.jpg
* pics	background.jpg
* pics	default.jpg
* pics	index.html
* pics	logo.png
* pics	mhpann.png
* pics	transparent.png
* pics	webinterface1.jpg
* pics	webinterface1.png
* pics	webinterface2.jpg
* pics	webinterface3.jpg
* pics	webseite.jpg

## 12 Seiten die im OpenSimulator konfigurierbar sind	

* Login Service:	
* MapTileURL = "${Const|BaseURL}:${Const|PublicPort}/webinterface/maptile.php";	
* SearchURL = "${Const|BaseURL}:${Const|PublicPort}/webinterface/searchservice.php";	
* DestinationGuide = "${Const|BaseURL}/webinterface/guide.php"	
* Grid Info Service:	
* AvatarPicker = "${Const|BaseURL}/webinterface/avatarpicker.php"	
* welcome = ${Const|BaseURL}/webinterface/welcomesplashpage.php	
* about = ${Const|BaseURL}/webinterface/aboutinformation.php	
* register = ${Const|BaseURL}/webinterface/registeruser.php	
* help = ${Const|BaseURL}/webinterface/help.php	
* password = ${Const|BaseURL}/webinterface/passwordreset.php	
* partner = ${Const|BaseURL}/webinterface/partner.php	
* GridStatus = ${Const|BaseURL}:${Const|PublicPort}/webinterface/gridstatus.php	
* GridStatusRSS = ${Const|BaseURL}:${Const|PublicPort}/webinterface/gridstatusrss.php	

## Webseiten Adressen die im Firestorm Viewer angezeigt werden:	
* Grid name	
* Grid URI	
* Login page	
* Helper URI	
* Grid Website	
* Grid Support	
* Grid Registration	
* Grid Password URI	
* Grid Search	
* Grid Message URI	

## Benötigte Dateien:	
* maptile.php	
* searchservice.php	
* guide.php	
* avatarpicker.php	
* welcomesplashpage.php	
* aboutinformation.php	
* registeruser.php	
* help.php	
* passwordreset.php	
* partner.php	
* gridstatus.php	
* gridstatusrss.php	

## Dazu werden folgende Resourcen benötigt	
* include	config.example.php umbenennen in config.php
* include	favicon.ico oder eigenes Icon
* include	header.php oder eigenen header
* include	footer.php oder eigenen footer
* include	gridlist.csv
* include	destinations.json

* Und die Verzeichnisse:	
* images - Die Bilder für eure Login Page bitte macht alle Bilder gleichgroß.	
* destinations - Eure eigenen Regionsbilder.	
* pics - Diverse Bilder die sonst niergens reinpassen wie Logo und Wallpaper.	

Alle anderen Dateien oder Verzeichnisse können auch gelöscht werden.	
---

## TODO

15.02.2025 MuteList Service ist hinzugekommen hiermit kann man sehen und einstellungen vornehmen. Passwörter sind erweitert worden bitte die config.php anpassen.

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

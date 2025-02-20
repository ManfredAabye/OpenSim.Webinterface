# TODO

Webseiten Adressen die im Firestorm Viewer angezeigt werden:

    Grid name
    Grid URI
    Login page - Das wird alles von der ${Const|BaseURL}/webinterface/welcomesplashpage.php; bedient.

    Helper URI - Das wird von der ${Const|BaseURL}/webinterface/help.php; bedient.

    Grid Website - Das wird von der ${Const|BaseURL}/webinterface/welcomesplashpage.php; bedient.

    Grid Support - Das wird von der ${Const|BaseURL}/webinterface/help.php; bedient.

    Grid Registration
    Grid Password URI

    Grid Search
    Grid Message URI

Benötigte Dateien:

    maptile.php
    searchservice.php
    guide.php
    avatarpicker.php
    welcomesplashpage.php
    aboutinformation.php
    registeruser.php
    help.php
    passwordreset.php
    partner.php
    gridstatus.php
    gridstatusrss.php



    MapTileURL = "${Const|BaseURL}:${Const|PublicPort}/webinterface/maptile.php";

    SearchURL = "${Const|BaseURL}:${Const|PublicPort}/webinterface/searchservice.php";

    DestinationGuide = "${Const|BaseURL}/webinterface/guide.php"; Fertig
    AvatarPicker = "${Const|BaseURL}/webinterface/avatarpicker.php";
    welcome = ${Const|BaseURL}/webinterface/welcomesplashpage.php;

    about = ${Const|BaseURL}/webinterface/aboutinformation.php;
    register = ${Const|BaseURL}/webinterface/registeruser.php;
    help = ${Const|BaseURL}/webinterface/help.php;
    password = ${Const|BaseURL}/webinterface/passwordreset.php;
    partner = ${Const|BaseURL}/webinterface/partner.php;
    GridStatus = ${Const|BaseURL}:${Const|PublicPort}/webinterface/gridstatus.php;


Minimal Eintragungen:


    Grid name
    Grid URI
    Login page - Das wird alles von der ${Const|BaseURL}/webinterface/welcomesplashpage.php; bedient.

    Helper URI - Das wird von der ${Const|BaseURL}/webinterface/help.php; bedient.

    Grid Website - Das wird von der ${Const|BaseURL}/webinterface/welcomesplashpage.php; bedient.

    Grid Support - Das wird von der ${Const|BaseURL}/webinterface/help.php; bedient.

    Grid Registration - Das wird von der ${Const|BaseURL}/webinterface/registeruser.php; bedient.
    Grid Password URI - Das wird von der ${Const|BaseURL}/webinterface/passwordreset.php; bedient.

    Grid Search
    Grid Message URI



    Das sollte ins Verzeichnis /viewer
    welcome = ${Const|BaseURL}/webinterface/welcomesplashpage.php;
    DestinationGuide = "${Const|BaseURL}/webinterface/guide.php";
    help = ${Const|BaseURL}/webinterface/help.php;
    register = ${Const|BaseURL}/webinterface/registeruser.php;
    password = ${Const|BaseURL}/webinterface/passwordreset.php;

    Alles andere sollte ins Verzischnis /helper


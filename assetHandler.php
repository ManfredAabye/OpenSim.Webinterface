<?php

define('JP2000_CACHE', 'cache/jp2/');
define('ASSETS_CACHE_BILD_PFAD', 'cache/jp2/');
define('NULL_SCHLUESSEL', '00000000-0000-0000-0000-000000000000');
define('NULL_SCHLUESSEL_BILD', 'cache/jp2/00000000-0000-0000-0000-000000000002');
define('ASSETS_SERVER_TIMEOUT', 10);
define('ASSETS_STANDARD_FORMAT', 'jpg');

defined('ASSETS_DO_RESIZE') or define('ASSETS_DO_RESIZE', false);
defined('ASSETS_RESIZE_FIXED_WIDTH') or define('ASSETS_RESIZE_FIXED_WIDTH', 500);
defined('ASSETS_CACHE_TTL') or define('ASSETS_CACHE_TTL', 3600);
defined('GRID_ASSETS_SERVER') or define('GRID_ASSETS_SERVER', 'http://example.com/assets/');

function keinAsset($format): string {
    $bild = NULL_SCHLUESSEL_BILD . '.png';
    if (!is_file($bild)) {
        $bild = NULL_SCHLUESSEL_BILD . '.' . $format;
    }
    if (!is_file($bild)) {
        exit();
    }
    return file_get_contents($bild) ?: '';
}

function getAsset(string $asset_uuid, string $format = ASSETS_STANDARD_FORMAT): string {
    if (empty($asset_uuid) || $asset_uuid === NULL_SCHLUESSEL) {
        return keinAsset($format);
    }
    
    $cachePfad = ASSETS_CACHE_BILD_PFAD . $asset_uuid . '.' . $format;
    if (checkCache($cachePfad)) {
        return file_get_contents($cachePfad) ?: '';
    }
    
    if (!checkCache(JP2000_CACHE . $asset_uuid)) {
        $asset_url = GRID_ASSETS_SERVER . $asset_uuid;
        $dateiInhalt = @file_get_contents($asset_url, false, stream_context_create(['http' => ['timeout' => ASSETS_SERVER_TIMEOUT]]));
        
        if ($dateiInhalt === false) {
            return keinAsset($format);
        }
        
        try {
            $xml = new SimpleXMLElement($dateiInhalt);
        } catch (Exception) {
            return keinAsset($format);
        }
        
        $daten = base64_decode((string) $xml->Data, true);
        if ($daten === false) {
            error_log("Base64-Dekodierung fehlgeschlagen für Asset UUID: $asset_uuid");
            return keinAsset($format);
        }
        
        schreibeCache($asset_uuid, $daten, JP2000_CACHE);
    } else {
        $daten = file_get_contents(JP2000_CACHE . $asset_uuid) ?: '';
    }
    
    try {
        $_img = new Imagick();
        $_img->readImageBlob($daten);
        $_img->setImageFormat($format);
        
        if (ASSETS_DO_RESIZE) {
            $originalBreite = $_img->getImageWidth();
            $originalHoehe = $_img->getImageHeight();
            $neueHoehe = (int) (ASSETS_RESIZE_FIXED_WIDTH * ($originalHoehe / $originalBreite));
            $_img->resizeImage(ASSETS_RESIZE_FIXED_WIDTH, $neueHoehe, Imagick::FILTER_CUBIC, 1);
        }
        
        $ausgabe = $_img->getImageBlob();
    } catch (ImagickException $e) {
        error_log("Imagick Fehler: {$e->getMessage()}");
        return keinAsset($format);
    }
    
    schreibeCache($cachePfad, $ausgabe, ASSETS_CACHE_BILD_PFAD);
    return $ausgabe;
}

function checkCache(string $dateiPfad): bool {
    if (!file_exists($dateiPfad) || filesize($dateiPfad) === 0) {
        @unlink($dateiPfad);
        return false;
    }
    if (filemtime($dateiPfad) < (time() - ASSETS_CACHE_TTL)) {
        @unlink($dateiPfad);
        return false;
    }
    return true;
}

function schreibeCache(string $dateiname, string $inhalt, string $cacheVerzeichnis): bool {
    $cacheDatei = $cacheVerzeichnis . $dateiname;
    return file_put_contents($cacheDatei, $inhalt) !== false;
}

?>

<style>
   .markdown-content {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      Color:rgb(176, 174, 174);
      background-color:rgb(27, 27, 27);
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
   }
</style>

<?php
function replacePlaceholders($text, $variables = []) {
    foreach ($variables as $key => $value) {
        $text = str_replace("[$key]", $value, $text);
    }
    return $text;
}

function simpleMarkdownToHTML($text) {
    // Zeilenumbrüche umwandeln
    $text = nl2br($text);

    // Fettdruck **text** -> <strong>text</strong>
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);

    // Kursiv *text* -> <em>text</em>
    $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);

    // Überschriften # -> <h1>, ## -> <h2> usw.
    for ($i = 6; $i >= 1; $i--) {
        $text = preg_replace('/^' . str_repeat('#', $i) . '\s*(.*?)$/m', "<h$i>$1</h$i>", $text);
    }

    // Links [Text](URL) -> <a href="URL">Text</a>
    $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $text);

    // Inline-Code `text` -> <code>text</code>
    $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $text);

    return $text;
}

// Deine Markdown-TOS mit Platzhaltern
$tosText = "
# Nutzungsbedingungen für [DEIN GRID-NAME]

**Letzte Aktualisierung:** [DATUM]

Willkommen bei **[DEIN GRID-NAME]**!  
Durch die Nutzung dieses Dienstes stimmst du unseren Nutzungsbedingungen zu.

## Kontakt  
Falls du Fragen hast, kannst du uns hier erreichen:  
📧 **[DEINE EMAIL]**  
🏠 **[DEINE POSTADRESSE]**  
📞 **[OPTIONAL]**  

Alternativ kannst du uns unter **[DEINE KONTAKT-EMAIL]** kontaktieren.
";

// Platzhalter-Werte setzen
$variables = [
    "DEIN GRID-NAME" => "Virtual World Grid",
    "DATUM" => date("d.m.Y"),
    "DEINE EMAIL" => "support@example.com",
    "DEINE POSTADRESSE" => "Musterstraße 123, 12345 Musterstadt",
    "OPTIONAL" => "Discord: GridSupport#1234",
    "DEINE KONTAKT-EMAIL" => "kontakt@example.com"
];

// 1️⃣ Platzhalter ersetzen
$tosText = replacePlaceholders($tosText, $variables);

// 2️⃣ Markdown in HTML umwandeln
$finalHTML = simpleMarkdownToHTML($tosText);

// 3️⃣ HTML ausgeben
echo "<div class='markdown-content'>$finalHTML</div>";
?>

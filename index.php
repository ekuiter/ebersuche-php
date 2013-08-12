<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Ebersuche</title>
<style type="text/css">
body {
    text-align: center;
    font-family: Arial, sans-serif;
}
table {
    border: none;
}
a:link {
    color: 
}
form.suche {
    margin: 0px;
    margin-top: 30px;
}
form.kunde {
    margin: 0px;
    margin-top: 10px;
}
</style>
</head>
<body>
<form action="?" method="post" class="suche">
<label for="ebername">Nach Eber suchen:</label> <input type="text" name="ebername" id="ebername" /> <input type="submit" value="Suche" />
</form>
<form action="?" method="post" class="kunde">
<label for="kundennr">Kundeneberzuordnung:</label> <input type="text" name="kundennr" id="kundennr" size="15" /> <input type="text" name="pnr" size="4" maxlength="4" /> <input type="submit" value="Anzeigen" />
</form>
<?php

error_reporting(0);

if ((isset($_POST['ebername']) && isset($_POST['kundennr'])) || (isset($_POST['ebername']) && isset($_POST['pnr']))) {
    echo "<h4>Bitte nur ein Formular ausfüllen.</h4>";
} elseif (isset($_POST['ebername'])) {
    $file = @file_get_contents("http://www.schweinebesamung.de/eb_angeb/we-ebersu2.php?ebername=$_POST[ebername]");
    if (!$file) {
        echo '<h4>Ebersuche nicht verfügbar. Versuchen Sie es zu einem späteren Zeitpunkt erneut.</h4>';
    } else {
        if (strstr($file, 'Keinen Eber mit dem Namen')) {
            echo "<h4>Die Suche ergab keine Ergebnisse.</h4>";
        } else {       
            echo "<h4>Die Suche ergab folgende Ergebnisse:</h4>";
            $file = str_replace('href=katalog/', 'target=_blank href=http://www.schweinebesamung.de/eb_angeb/katalog/', $file);      
            $file = str_replace('border="1" ', '', $file);      
            $file = str_replace("</BODY>\n", '', $file);      
            $file = str_replace("</HTML>\n", '', $file);
            echo $file;
        }
    }
} elseif (isset($_POST['kundennr']) || isset($_POST['pnr'])) {
    if (isset($_POST['kundennr']) && isset($_POST['pnr']) && !empty($_POST['kundennr']) && !empty($_POST['pnr'])) {
        if (is_numeric($_POST['kundennr']) && is_numeric($_POST['pnr'])) {
            $file = @file_get_contents("http://www.schweinebesamung.de/eb_angeb/we-kdebersu.php?kdnr=$_POST[kundennr]&p_nr=$_POST[pnr]");
            if (!$file) {
                echo '<h4>Kundeneberzuordnung nicht verfügbar. Versuchen Sie es zu einem späteren Zeitpunkt erneut.</h4>';
            } else {
                if (strstr($file, 'Keine passenden Daten')) {
                    echo "<h4>Die Kundeneberzuordnung ergab keine Ergebnisse.</h4>";
                } else {       
                    echo "<h4>Kundeneberzuordnung:</h4>";
                    echo $file;
                }
            }
            
        } else {
        echo "<h4>Kundennummer und Prüfziffer müssen korrekt angegeben werden!</h4>";
        }        
    } else {
        echo "<h4>Kundennummer und Prüfziffer müssen angegeben werden!</h4>";
    }
}

?>
</body>
</html>
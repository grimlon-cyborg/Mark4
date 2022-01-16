<Mark4>  

<br> 
 
<h1>Das smarte Feld<h1/> 




<?php
//phpinfo();
// Fehlermeldungen anzeigen
error_reporting(E_ALL);
ini_set('display_errors', true);
//Sorgt dafür das die FEhler Meldungen im Browser angezeigt werden 
// falls nicht, im Terminal mit "tail -f /var/log/apache2/error.log" nachsehem, mit Ctrl-C beenden





// Pfad zur Datenbank
$datenbank = "db-23579482574958234759824357932/values.db3"; 

//ersetzt db:... duch datenbank 



// sudo apt install php7.4-sqlite3


// wenn die datei nich exiestiert 
if (!file_exists($datenbank)) 
{
   // Datei existiert nicht
    
    // Daten bank objekt erzeugen
   // https://www.php.net/manual/de/pdo.construct.php 
   $db = new PDO('sqlite:' . $datenbank);
  
   /* Datenbank-Datei erstellen  https://www.sqlite.org/datatype3.html */
    $db->exec("CREATE TABLE someValues( 
  id INTEGER PRIMARY KEY,
  theKey text,
  theValue text,
  theAddress text)"); 
  // erzeugt die Tabelle some someValues
  //https://www.php.net/manual/de/pdo.exec.php 
}
else
{
    // Datei existiert, verbindung zur Datenbank aufbauen 
    $db = new PDO('sqlite:' . $datenbank);
}

    // Variable mit lehreer zeichenkette füllen 
$key = "";
    // wenn array key exiestiert dann ersetze Zeichen mit leerzeichen 
if (array_key_exists('key', $_GET)) // es wird über ob in der Url der Schlüssel Key steht 
{
    $key = preg_replace('/[^a-zA-Z0-9._]+/i', ' ', $_GET['key']);  //ersetzte diese Zeichen nicht und ersetze alle anderen mit leerzeichen und lese dies aus dem Key
}
$key = trim(preg_replace('/\s+/', ' ', $key)); // ersetzt mehrere leerzeichen zu einem und  kürze Leerzeichen vorne und hinten weg 

//entsprechend das selbe für value, nur das noch ein paar andere zeichen zugelasen sind 
$value = "";
if (array_key_exists('value', $_GET))
{
    $value = preg_replace('/[^a-zA-Z0-9.;:#-ß]+/i', ' ', $_GET['value']);
    //$value =  $_GET['value'];
}
$value = trim(preg_replace('/\s+/', ' ', $value));


$modusair = false;
if (array_key_exists('modus', $_GET))
{
	if ($_GET['modus'] == "air")
	{
		$modusair = true;
	}
}




// hollt die ip adresse vom client, schlüssel muss nicht überprüft werden, weil er immer da ist 

$ra = $_SERVER['REMOTE_ADDR'];




if ($key != "")
{
//ween die variable key nicht leer ist, dann 
    if ($key == "loeschen" && $value == "wirklich")
    {
    //spezial aufruf um alle daten aus der Datenbank zu löschen
        $sqlc = "DELETE FROM someValues "; //löscht alles aus some values 
       

        $db->exec($sqlc); // fphrt das vorheriege aus 

// sagt was statdesseb eingefügt werden soll 
        $key = "zuletzt geloescht"; 
        $value = date(DATE_ATOM); 
    }

    $sqlc = "DELETE FROM someValues WHERE theKey='$key' AND theAddress='$ra'"; //löscht eventuelle duplikate 

    $db->exec($sqlc);  //führt es aus 

    $sql = "INSERT INTO someValues (theKey,theValue,theAddress) VALUES ('$key','$value','$ra')"; //fügt es ein 
    $db->exec($sql); //führt es wieder aus 
    
}

function endsWith($haystack, $needle) //eigene funktion um zu überprüfen ob eine Zeichekette ($haystack)  mit einer Zeichenkette($needle)  endet 
{
    $length = strlen($needle);
    if (!$length)
    {
        return true;
    }   
     //wenn needle leer ist, dann immer true zurück geben <tr><th style=''>tristan1<td  style='?'><td  style='?'>3.14159265<td  style='?'>

    return substr($haystack, -$length) === $needle; // vergleicht einen Teilzeichenkette ob sie gleich mit needle ist 
    // Teilstring sind letzten 6 zeichen von hinten 
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    if (!$length)
    {
        return true;
    }   

    return substr($haystack, 0, $length) === $needle;

}



unset($vvv); //sagt das die beiden varieblen leer sind, eigentlich unnötig, weil sie sowieso leer sind 
unset($vvvair);
unset($styles);
$styles["xxx"] = ""; //funktion um sicher zu stellen da styles ein array ist 
$vvvair["xxx"] = ""; //funktion um sicher zu stellen da styles ein array ist 


$stmt = $db->query("SELECT * FROM someValues");  
while ($row = $stmt->fetch())
//kommando wird gestartet und ausgeführt, (while) holt werte zeilenweis) 

{
    $k = $row['theKey'];
    $v = $row['theValue'];
    $a = $row['theAddress'];
// kopiert die namen von den Spalten um 

    if (endsWith($k, "_style")) //wenn variable mit style ändert 
    {
        $k = substr($k, 0, -6); //kürzt das _style weg 
        $styles[$k] = $v; // füllt die styles tabelle mit den Farbinformationen 

    }
    else if (endsWith($k, "_air"))
    {
        $k = substr($k, 0, -4);

	$vvvair[$a][$k] = $v;  // füllt die vvvair tabelle mit den Texten 
        $keysair[$k] = $k; //aufsammeln aller air keys 
        $addrsair[$a] = $a; // aufsammlen aller air adressen 
    }
    else
    {

        $keys[$k] = $k; //aufsammeln alle keys 
        $addrs[$a] = $a; // aufsammlen aller adressen 
        $vvv[$a][$k] = $v; // Speichern einer 2D tabelle im aray vvv 
    }

}


/*

echo "<hr><pre>";

print_r($vvv);

echo "<hr>";

print_r($keys);

echo "<hr>";

print_r($styles);
echo "<hr>";

print_r($addrs);

echo "<hr>";

exit;

*/ 

//können die Vorherigen sachen ausgeben( kommentarzeichen entfernen um die vorheraufgesamleten werte anzuzeigen) 

echo "<table>"; 

echo "\n<tr><th>";

if ($modusair)
{
  // wenn modus=air, dann nur die fuer air gesammelten Werte benutzen
  $addrs = $addrsair;
  $keys = $keysair;
}


asort($addrs); //sortiere adressen (alphabetisch) 
foreach ($addrs as $ka => $va) //alle eintrege aus adrrs durchlaufen(ka und va sind gleich) 
{
    echo "<th> $va"; 
}

asort($keys); //sortiert Keys(alphabtetisch) 

foreach ($keys as $kk => $vk) //alle eintrege aus keys durchlaufen(kk und vk sind gleich) 
{

    $style = "";
    if (array_key_exists($kk, $styles)) //überprüft ob Styles vorhanden ist 
    {
        $style = $styles[$kk]; // koppirt styles in style 
    }

    echo "\n<tr><th style='$style'>$vk";

    foreach ($addrs as $ka => $va) 
    {

       $data = ""; //data wird leer gesetzt 


	if ($modusair)
	{
		if (array_key_exists($va, $vvvair)) // überprüfe ob in vvv die zeile va existiert 
		{
		    if (array_key_exists($vk, $vvvair[$va])) //überprüft ob vk in vvv(va) existiert 
		    {
		        $data = $vvvair[$va][$vk]; // kopiert die daten nach data 
		    }
		}
	}
	else
	{
		if (array_key_exists($va, $vvv)) // überprüfe ob in vvv die zeile va existiert 
		{
		    if (array_key_exists($vk, $vvv[$va])) //überprüft ob vk in vvv(va) existiert 
		    {
		        $data = $vvv[$va][$vk]; // kopiert die daten nach data 
		    }
		}
	}

        echo "<td  style='";
        echo $style;
        echo "'>";
       
        
        
        
        echo $data;
      
      
      //echo $style.";font-size:".(intval($data)%10+10)*5;
        
      
      
        /*
        if ($data == "333")
        {
        echo "Tiana";
        }
        else
        {
	   echo  $data;
	 }
	 */
	 
	 /*
	 if (startsWith($kk,"if") && ($data < 4) && ($data != ""))
	 {
	 	echo " oh weh! ";
	 } else	 if (startsWith($kk,"if") && ($data >= 4) && ($data != ""))
	 {
	 	echo " gut ";
	 }
	 else
	 {
	 echo $data;
	 } 
	 */ 
	 
	 
	  
	
	 
    }

}

echo "\n</table>";  

?> 

<form action="https://tristan.sander.is/kom.php" method=get>


<?php
if ($modusair)
{
	echo "<input name=modus value=pro type=hidden>\n";
	echo "<button>Pro Modus </button>\n";
}
else
{
	echo "<input name=modus value=air type=hidden>\n";
		echo "<button>Air Modus </button>\n";
}
?>



</form> 

<form action="https://tristan.sander.is/kom.php" method=get>
<input name=key value=loeschen type=hidden>
<input name=value value=wirklich type=hidden>
<input name=modus value=air type=hidden>
  <button>Bei Anzeige Fehlern Drücken </button>
</form>





<br> 
<br> 
<br> 
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>





---------------------------------------------------------------
<form action="https://fckaf.de/eis"> 
  <button name="b" value="Find!!!">Nicht drücken </button>
</form> 




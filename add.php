<?php
ini_set('display_errors', 1); // ini_set - ustawia wartosci opcji konfiguracyjnej. CO ONZACZA 1?
ini_set('max_execution_time', 50);
$time1 = microtime(true); //microtime podaje dokladny czas, dzieki true zwara float zamiast string
require_once('database.php'); //dziala jak Require poza tym, że sprawdza czy dany plik by już dolaczony, jesli tak to go nie dolacza znowu

$xml = new DOMDocument(); //DOMDocument - reprezentuje caly dokmunet HTMl lub XML; serves as a root of a document tree
$xml->load('philosophers.xml'); //wywolujemy

$db = Database::getInstance(); //returns the Datatbase object instance (Chyba)
$itemsList = $xml->getElementsByTagName('result'); 
$count = $itemsList->length;

$item = $xml->getElementsByTagName('binding');
$el = $item->length;


for($i = 0; $i < $el; $i++) 
{
    if($item->item($i)->getAttribute('name') === 'filozof') //getAttribute - zwraca wartosci atrybutu
    {
        $filnum[] = $i; 
    }
}

$a = 0;
//$urlfile = fopen("urls.txt", "w");
foreach($filnum as $key => $num) // CO ROBI  => 
{
   $db = Database::getInstance(); //returns the Datatbase object instance (Chyba)
   if(isset($filnum[$key +1])) // zwiekszamy key o 1; isset - determine if variable is set and is not null
   {
       $numb = $filnum[$key +1];
   } else $numb = $el;
   
   for($i = $a; $i < $numb; $i++)
   {
       $a = $i + 1;
       switch($item->item($i)->getAttribute('name')) // wywolujemy; getAttribute zwarca wartosc atrybutu
       {
           case 'filozof':
                $url = $item->item($i)->nodeValue; 
                $regex = '/http:\/\/dbpedia.org\/resource\/(.*)/';
                preg_match($regex, $url, $match); //
                $url = "https://en.wikipedia.org/wiki/" . $match[1];
                //fwrite($urlfile, $url);
                $philarray['url'] = $url;
                break;
           case 'label':
                $philarray['name'] = $item->item($i)->nodeValue;
                break;
           case 'deathplace':
                $philarray['deathplace'] = $item->item($i)->nodeValue;
                break;
           case 'era':
                    $era = $item->item($i)->nodeValue;
                    $regex = '/http:\/\/dbpedia.org\/resource\/(.*)/';
                    preg_match($regex, $era, $match);
                    if(isset($match[1]))
                    {
                        $philarray['era'] = $match[1];
                    } else $philarray['era'] = $item->item($i)->nodeValue;
                break;
           case 'religion':
                $philarray['religion'] = $item->item($i)->nodeValue;
                break;
           case 'birthDate':
                $philarray['birthdate'] = $item->item($i)->nodeValue;
                break;
       }
   } 
   $results[] = $philarray;
   echo "<pre>";
   //$db->insert('philosophers', $philarray);                                 //dodaje rekordy do bazy
   echo "</pre>";
}
//fclose($urlfile);
echo "<pre>";
print_r($results);

echo "</pre>";
$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo $time;

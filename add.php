<?php
ini_set('display_errors', 1);
ini_set('max_execution_time', 50);
$time1 = microtime(true);
require_once('database.php');

$xml = new DOMDocument();
$xml->load('philosophers.xml');

$db = Database::getInstance();
$itemsList = $xml->getElementsByTagName('result');
$count = $itemsList->length;

$item = $xml->getElementsByTagName('binding');
$el = $item->length;


for($i = 0; $i < $el; $i++)
{
    if($item->item($i)->getAttribute('name') === 'filozof')
    {
        $filnum[] = $i;
    }
}

$a = 0;
//$urlfile = fopen("urls.txt", "w");
foreach($filnum as $key => $num)
{
   $db = Database::getInstance();
   if(isset($filnum[$key +1]))
   {
       $numb = $filnum[$key +1];
   } else $numb = $el;
   
   for($i = $a; $i < $numb; $i++)
   {
       $a = $i + 1;
       switch($item->item($i)->getAttribute('name'))
       {
           case 'filozof':
                $url = $item->item($i)->nodeValue;
                $regex = '/http:\/\/dbpedia.org\/resource\/(.*)/';
                preg_match($regex, $url, $match);
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

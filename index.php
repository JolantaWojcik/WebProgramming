<!DOCTYPE html>
<?php
require_once "database.php";
$db = Database::getInstance();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset=utf-8" />
        <title>Filozofowie</title>
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
            <link href='http://fonts.googleapis.com/css?family=Irish+Grover' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Hammersmith+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <link href="style.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        <div class="wrapper">
            <div class="philchoice">Philosophers</div>
            <div class="religion">
            <div class="religioncontent">
            Choose religion:
            <?php 
                $db->getDistinct('religion', 'philosophers');
                $results = $db->results(); //czy $results to array?
            ?>
            <form action="" id="religion" method="post">
                <select name="religion" form="religion">
                <option selected="selected">Unknown</option>
                    <?php
                        foreach($results as $result) //ananlizujemy RESULTS, a aktualnie przetwarzany element ma być zapisany w zmiennej RESULT (Chyba)
                        {
                            if(!($result->religion === "Unknown")) //jesli nie wywola religion z result to jest identyczne z Unknown (chyba)
                            {
                                echo "<option value=\"" . $result->religion . "\">" . $result->religion . "</option>"; // NIE WIEM CO TU SIE DZIEJE, CO ROBI "\"?
                            }
                        }
                    ?>
                </select>
                </br>
                <input type="submit" value="go!"> //define a submit button
            </form>
            <p>Philosophers that belongs to this religion are:</p>
            <?php
            if(isset($_POST['religion'])) // isset - determine if variable is set and is not null; $_POST - gormadzenie wartosci formularza, dane sa niewidoczne w adresie
            {
                $db->get('name, url', 'philosophers', array('religion', '=', $_POST['religion'])); // znak = oznacza przypisanie
                $results = $db->results();
                foreach($results as $result)
                {
                    echo "<div class='name'><a target='_blank' href='" . $result->url . "'>" . $result->name . "</a></div>"; // kropa pelni role lacznika
                }
            }
            ?>
            </div>
            </div>
        </div>
    </body>

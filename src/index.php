<!DOCTYPE html>

<head>
    <!-- Settings -->
    <meta charset="UTF-8">
    <meta name="Absenzverwaltung" content="">
    <meta name="keywords" content="">
    <meta name="Author" content="Mica">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenzverwaltung</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/<?php echo (basename($_SERVER['SCRIPT_NAME'], ".php")) ?>.css">

    <!-- libraries -->


    <!-- Favicons -->

    <!-- Database -->
    <?php
    $db = new SQLite3("DB/AbsenzverwaltungDB.db");

    $StudQuery = $db->query("SELECT * FROM TStudenten");
    $LehrQuery = $db->query("SELECT * FROM TLehrer");

    $dataColumns = array();
    $dataRows = array();

    while($row = $StudQuery->fetchArray(SQLITE3_ASSOC))
{


   //add columns to array, checking if value exists
   foreach($row as $key => $value)
   {

       if(in_array(''.$key.'', $dataColumns)){

          //column already in array, dont add again.

       }else{

            //column not in array, add it.
            $dataColumns[]=array(
                'column'=>$key
            );  

        }
    }
}

    ?>



</head>

<body>
    <!-- Header -->
    <header>
        <h1>Absenzverwaltung</h1>
    </header>

    <!-- The flexible grid (content) -->
    <main>
        <div class="main">
            <h2>Absenzverwaltung</h2>

            <label for="teacher">Choose a Teacher:</label>
            <select name="teacher" id="teacher">
            <?php
            //add TLehrer, TFächer to Dropdown
            while ($dsatz = $LehrQuery->fetchArray(SQLITE3_ASSOC)) {
                echo '<option value="teacher">' . $dsatz["Vorname"] . " " . $dsatz["Nachname"] . '</option>"';
              }
            ?>
            </select>
            <br>
            <label for="subject">Choose a Subject:</label>
            <select name="subject" id="subject">
                <?php
            while ($dsatz = $LehrQuery->fetchArray(SQLITE3_ASSOC)) {
                echo '<option value="subject">' . $dsatz["FachKuerz"] . '</option>"';
              }
            ?>
            </select>

        </div>
        <div class="side">
            <h2>Tabelle</h2>
            <input type="date" name="date" placeholder="select date">
            <div class="box" style="height:450px;">
                <?php
                //build html table
               $firstRow = true;
               echo '<div class="table-responsive"><table class="table">';
               $i = 0;
               while ($row = $StudQuery->fetchArray(SQLITE3_ASSOC)) {
                   
                   if ($firstRow) {
                       echo '<thead><tr>';
                       foreach ($row as $key => $value) {
                           echo '<th>'.$key.'</th>';
                           
                       }
                       echo '<th>' . 'Anwesend' . '</th>';
                       echo '<th>' . 'Entschuldigt' . '</th>';
                       echo '<th>' . 'Unentschuldigt' . '</th>';
                       echo '<th>' . 'verspaetet' . '</th>';
                       echo '</tr></thead>';
                       echo '<tbody>';
                       $firstRow = false;
                   }
               
                   echo '<tr>';
                   foreach ($row as $value) {
                       echo '<td>'.$value.'</td>';
                       
                       
                   }
                   echo '<td>' . '<input type="radio" id="0"
                   name="absence' . $i . '"' . ' value="anwesend">' . '</td>' ;
                   echo '<td>' . '<input type="radio" id="1"
                   name="absence' . $i . '"' . ' value="entschuldigt">' . '</td>' ;
                   echo '<td>' . '<input type="radio" id="2"
                   name="absence' . $i . '"' . ' value="unentschuldigt">' . '</td>' ;
                   echo '<td>' . '<input type="radio" id="3"
                   name="absence' . $i . '"' . ' value="verspaetet">' . '</td>' ;
                   echo '</tr>';
                   
                   $i++;
               }
               echo '</tbody>';
               echo '</table></div>';          
                ?>
            </div>
            <button type="button" onclick="myFunction()">Add Absence</button> 
        </div>
    </main>

    <!-- Footer -->
    <div class="footer">
        <h2><a href="mailto:luca.hanimann@stud.kftg.ch">Kontakt</a></h2>
    </div>

    <?php
    if (extension_loaded("sqlite3")) {
        echo "SQLite3-Bibliothek geladen";
    } else {
        echo "SQLite3-Bibliothek nicht geladen";
    }
    ?>

    <!-- Script -->
    <script src="js/index.js"></script>

</body>
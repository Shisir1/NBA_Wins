<?php
$onload = $_GET["onload"] ?? "";
$key = $_GET["key"] ?? "";

    //set up 4 parameters
    $server = "localhost";
    $user = "root";
    $password = "root";
    $database = "nba_db";

    //for later use(fro gph - good programing habit)
    $databaseTable = "nba_table";

    //make a connection to the tdatabase - use php funtion: mysqli_connect()
    $mycon = mysqli_connect($server, $user, $password, $database) or die("no connection established");

    function dataPrint($results, $title){
        $numrecs = mysqli_num_rows($results);
        if ($numrecs > 0) {
            print "<h2>".$title."</h2>";
            print "<table border = '1'>";
            print "<tr>";
                print"<th>ID</th>";
                print"<th>Team</th>";
                print"<th>Year Founded</th>";
                print"<th>NBA wins</th>";
                print"<th>year of win</th>";
            print "</tr>";
            //loop through the matching record(s)
            while ($recordArray = mysqli_fetch_row($results)) {
    
                //extracting field's values
                $id = $recordArray[0];
                $team = $recordArray[1];
                $yearFounded = $recordArray[2];
                $NBAWins = $recordArray[3];
                $yearofWin = $recordArray[4];

                print "<tr>";   
                    print"<td>$id</td>";
                    print"<td>$team</td>";
                    print"<td>$yearFounded</td>";
                    print"<td>$NBAWins</td>";
                    print"<td>$yearofWin</td>";
                print "</tr>";

        }
        print "</table>";
        }else {
            print "No record(s) found";
        }
    }

    if ($key ==1) {
    //create a string variable that holds the SQL command
    $SQLselect = "SELECT * FROM " . $databaseTable;
    
    //to run the above SQL command = PHP has a funtion: mysqli_query()
    //store the results of the run in a variable
    $results = mysqli_query($mycon, $SQLselect) or die(" query did not run");
    $title = "All the Information";
     //funtion to display the data
    dataPrint($results, $title);
}else if ($key == 2) {

    //create a string variable that holds the SQL command
    $SQLselect = "SELECT * FROM ".$databaseTable." ORDER BY yearfounded ASC
	LIMIT 5"; 
    
    //to run the above SQL command = PHP has a funtion: mysqli_query()
    //store the results of the run in a variable
    $results = mysqli_query($mycon, $SQLselect) or die(" query did not run");
    $title = "Top 5 Oldest Teams";
     //funtion to display the data
    dataPrint($results, $title);
}else if ($key == 3) {

    //create a string variable that holds the SQL command
    $SQLselect = "SELECT * FROM ".$databaseTable." ORDER BY yearfounded DESC
	LIMIT 5"; 
    
    //to run the above SQL command = PHP has a funtion: mysqli_query()
    //store the results of the run in a variable
    $results = mysqli_query($mycon, $SQLselect) or die(" query did not run");
    $title = "Top 5 Most Recently Founded Teams";
    //funtion to display the data
    dataPrint($results, $title);
    
}if ($onload ==0) {

//create a string variable that holds the SQL command
$SQLselect = "SELECT team, NBAwins FROM " .$databaseTable." WHERE NBAwins = (SELECT MAX(CAST(NBAwins AS SIGNED))AS MAX FROM ".$databaseTable.")";
    
//to run the above SQL command = PHP has a funtion: mysqli_query()
//store the results of the run in a variable
$results = mysqli_query($mycon, $SQLselect) or die(" query did not run");

$numrecs = mysqli_num_rows($results);
        if ($numrecs > 0) {
            print "<br />";
            print "<h3>4. Which team won the championship the most</h3>";
            print "<table border = '1'>";
            print "<tr>";
                print"<th>Team</th>";
                print"<th>NBA wins</th>";
            print "</tr>";
            //loop through the matching record(s)
            while ($recordArray = mysqli_fetch_row($results)) {
    
                //extracting field's values
                $team = $recordArray[0];
                $NBAWins = $recordArray[1];

                print "<tr>";   
                    print"<td>$team</td>";
                    print"<td>$NBAWins</td>";
                print "</tr>";
        }
        print "</table>";
        }else {
            print "No record(s) found";
        }

    //create a string variable that holds the SQL command
$SQLselect = "SELECT team, yearofWin FROM " .$databaseTable." WHERE yearofWin LIKE '%1970%' OR yearofWin LIKE '%1980%' OR yearofWin LIKE '%1990%'";
    
//to run the above SQL command = PHP has a funtion: mysqli_query()
//store the results of the run in a variable
$results = mysqli_query($mycon, $SQLselect) or die(" query did not run");
//year of NBA championship for loop
$year = 1990;
$numrecs = mysqli_num_rows($results);
        if ($numrecs > 0) {
            print "<br />";
            print "<h3>5. Which team(s) won the NBA championship in 1970, 1980, and 1990.</h3>";
            print "<table border = '1'>";
            print "<tr>";
            print"<th>NBA championship in</th>";
                print"<th>Team</th>";
                print"<th>Year of Wins</th>";
            print "</tr>";
    
            //loop through the matching record(s)
            while ($recordArray = mysqli_fetch_row($results)) {
    
                //extracting field's values
                $team = $recordArray[0];
                $NBAWins = $recordArray[1];

                print "<tr>"; 
                print"<td>$year</td>";  
                    print"<td>$team</td>";
                    print"<td>$NBAWins</td>";
                print "</tr>";
                $year = $year - 10;
        }
        print "</table>";
        
        }else {
            print "No record(s) found";
        }
    }
?>
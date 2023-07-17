<?php

function makeDatabasesTable($query, $value = NULL, $showTables = false, $showColumns = false, $dbName = NULL) 
{
    if((!isset($_POST['showTables']) && !isset($_POST['showColumns'])) || $showTables || $showColumns)
    {
        if(!isset($_POST['showTables']) && !isset($_POST['showColumns']))
        {
            echo '<h1>Alle Schemata</h1>';
        }

        try 
        {
            $stmt = makeStatement($query, $value);
            
            echo '<form method="post"><table class="table">';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>';

                $row = array_values($row);
                
                foreach ($row as $r) 
                {
                    echo '<td>'.($showColumns ? '<input type="text" value="'.$r.'"></input>' 
                    : '<input name="'.($showTables ? 'showColumns' : 'showTables').'" type="submit" value="'.$r.'"></input>')
                    .'</td>';
                    
                    if($showTables)
                        echo '<input name="dbName" type="hidden" value="'.$dbName.'"></input';

                    if($showColumns)
                        break;
                }

                echo '</tr>';
            }

            echo '</table></form>';
        }
        catch (Exception $e) 
        {
            echo 'Fehler beim Erstellen der Tabelle: <br>'.$e->getCode().': '.$e->getMessage().'<br>';
        }
    }
    elseif(isset($_POST['showTables']) && !isset($_POST['showColumns']))
    {
        $databaseName = $_POST['showTables'];
        $showTablesQuery = "SHOW TABLES FROM ".$databaseName;

        echo "<h1>Alle Tabellen in ".$databaseName."</h1>";

        makeDatabasesTable($showTablesQuery, NULL, true, false, $databaseName);
    }
    elseif(isset($_POST['showColumns']))
    {         
        $tableName = $_POST['showColumns'];
        $databaseName = $_POST['dbName'];
        $showColumnsQuery = "SHOW COLUMNS FROM $databaseName.$tableName";
        
        echo "<h1>Alle Spalten in $databaseName.$tableName</h1>";

        makeDatabasesTable($showColumnsQuery, NULL, false, true);
    }
}

function makeStatement($query, $executeArray = NULL) 
{
    global $con;
    
    $stmt = $con->prepare($query);
    $stmt->execute($executeArray);
    return $stmt;
}
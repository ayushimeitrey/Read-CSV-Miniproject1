<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<?php
/**
 * Created by PhpStorm.
 * User: ayushi
 * Date: 2/26/19
 * Time: 2:29 PM
 */

main::start("example.csv");

class main {

    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
        system::printTable($table);
    }

}

class csv {

    static public function getRecords($filename){

        $file = fopen($filename,"r");

        $fieldNames = array();
        $count = 0;

        while(! feof($file))
        {
            $record = fgetcsv($file);

            if ($count == 0){
                $fieldNames = $record;
            }
            else{
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;

        }

        fclose($file);
        return $records;
    }
}

class record{

    public function __construct($fieldNames = null , $values= null)
    {

        $record= array_combine($fieldNames,$values);

        foreach ($record as $key => $values){
            $this->createProperty($key,$values);
        }

    }

    public function createProperty($name="defaultName" , $value="defaultValue")
    {
        $this->{$name} = $value;
    }

    public function returnArray(){
        $array = (array) $this;
        return $array;

    }
}

class recordFactory{

    public static function create(Array $fieldNames = null, Array $record = null)
        {
            $record = new record($fieldNames,$record);
            return $record;
        }
}


class html {

    static public function generateTable($records){

        $count=0;

        $finalArray1 = array();
        $finalArray2 = array();

        foreach($records as $record)
        {
            if ($count == 0) {
                   $array = $record->returnArray();
                   $keys = array_keys($array);
                   $values = array_values($array);

                   array_push($finalArray1, $keys);
                   array_push($finalArray1, $values);

               }

            else {
                   $array = $record->returnArray();
                   $values = array_values($array);

                   array_push($finalArray2, $values);

               }

            $count++;

        }

        $finalArray = array_merge($finalArray1, $finalArray2);
        return $finalArray;

    }
}

class system {

    static public function printTable($table)
    {
        $count=0;

        echo "<table class='table table-dark table-striped table-bordered '>";

        foreach($table as $record)
        {

            if ($count == 0) {

                $keys = array_values($record);

                echo "<thead style='color:maroon'><tr>";

                foreach($keys as $key) {
                        echo "<th>" . $key . "</th>";
                    }
                echo"</tr></thead><tbody>";

            }

            else {

                $values = array_values($record);

                echo "<tr>";

                foreach($values as $value) {
                    echo "<td>" . $value . "</td>";
                }

                echo "</tr>";

            }

            $count++;
        }

        echo "</tbody></table>";

    }
}


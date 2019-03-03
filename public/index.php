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
        print_r($records);

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





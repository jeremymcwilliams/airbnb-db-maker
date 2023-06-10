<?php

class parse{
    public $database;
    public $server;
    public $username;
    public $password;

    function __construct(){
        include("config/config.php");

        $this->database=$database;
        $this->server=$server;
        $this->username=$username;
        $this->password=$password;

    }

    function dbConnect(){

        /****** connect to database **************/

        try {
            $db = new PDO("mysql:host=$this->server;dbname=$this->database;charset=utf8;port=3306", $this->username, $this->password);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $db;

    }

    function process(){
        
        $data=$this->readCsv();


        //works
       // $this->populateNeighborhoodsTable($data);

        //works
       //$this->populateRoomTypesTable($data);

        //works
       //$this->populateAmenitiesTable($data);


       

       // $this->loadListings($data);




    }


    function readCsv(){
        $filename = 'listings.csv';

        // The nested array to hold all the arrays
        $the_big_array = []; 
        
        // Open the file for reading
        if (($h = fopen("{$filename}", "r")) !== FALSE) 
        {
          // Each line in the file is converted into an individual array that we call $data
          // The items of the array are comma separated
          $i=0;
          while (($data = fgetcsv($h, 10000, ",")) !== FALSE) 
          {
            if($i>0){
            // Each individual array is being pushed into the nested array
           // echo $data[0]."<br>";
            $the_big_array[] = $data;	
            }
            $i++;
          }       
          // Close the file
          fclose($h);
        }
        return $the_big_array;
    }

    function loadListings($data){

        foreach($data as $item){
            $extId=$item[0];
            $listingUrl=$item[1];
            $name=$item[5];
            $description=$item[6];
            $nho=$item[7];
            $pictureUrl=$item[8];
            $hostId=$item[9];
            $neighborhoodCleansed=$item[28];


        }




    }

    function populateNeighborhoodsTable($data){
        $hoods=array();
        foreach($data as $item){
            $neighborhood=$item[28];
            if(!in_array($neighborhood, $hoods)){
                array_push($hoods, $neighborhood);
            }

        }
        echo count($hoods);
        var_dump($hoods);
        $this->insertHoods($hoods);



    }

    function populateRoomTypesTable($data){
        $rts=array();
        foreach($data as $item){
            $roomType=$item[33];
            if(!in_array($roomType, $rts)){
                array_push($rts, $roomType);
            }

        }
        echo count($rts);
        var_dump($rts);
        $this->insertRoomTypes($rts);



    }
    function populateAmenitiesTable($data){
        $amenities=array();
        foreach($data as $item){
            $ams=$item[39];

            $listingsAms=json_decode($ams);

            if($listingsAms){
                foreach($listingsAms as $am){
                    if(!in_array($am, $amenities)){
                        array_push($amenities, $am);
                    }
    
    
                }
            }
        }
       // echo count($rts);
       // var_dump($rts);
        $this->insertAmenities($amenities);
      




    }




    function insertHoods($hoods){
        $db=$this->dbConnect();

        foreach ($hoods as $neighborhood){
            try {
                $stmt = $db->prepare("insert into neighborhoods (neighborhood) values (:neighborhood)");
                
                $stmt->execute(array(":neighborhood"=>$neighborhood));
                $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo $db->lastInsertId();               
            }
            catch (Exception $e) {               
                echo $e;
            }
        }
    }

    function insertRoomTypes($roomTypes){
        $db=$this->dbConnect();

        foreach ($roomTypes as $roomType){
            try {
                $stmt = $db->prepare("insert into roomTypes (type) values (:roomType)");
                
                $stmt->execute(array(":roomType"=>$roomType));
                $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo $db->lastInsertId();               
            }
            catch (Exception $e) {               
                echo $e;
            }
        }
    }

    function insertAmenities($amenities){
        $db=$this->dbConnect();

        foreach ($amenities as $amenity){
            try {
                $stmt = $db->prepare("insert into amenities (amenity) values (:amenity)");
                
                $stmt->execute(array(":amenity"=>$amenity));
                $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo $db->lastInsertId();               
            }
            catch (Exception $e) {               
                echo $e;
            }
        }
    }


}

$parse=new parse();

$parse->process();
//$db=$parse->dbConnect();

//$parse->readCsv();




?>
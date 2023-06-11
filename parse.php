<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class parse{
    public $database;
    public $server;
    public $username;
    public $password;
    public $roomTypes;
    public $db;


    function __construct(){
        include("config/config.php");

        $this->database=$database;
        $this->server=$server;
        $this->username=$username;
        $this->password=$password;

        $db=$this->dbConnect();
        $this->db=$db;

    }

    function dbConnect(){

        /****** connect to database **************/

        try {
            $db = new PDO("mysql:host=$this->server;dbname=$this->database;charset=utf8mb4;port=3306", $this->username, $this->password);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $db;

    }

    function process(){



        
        $data=$this->readCsv();


        //works
        $this->populateNeighborhoodsTable($data);

        //works
        $this->populateRoomTypesTable($data);

        //works
       $this->populateAmenitiesTable($data);

        //works
        $this->populateHostsTable($data);
       

        $this->loadListings($data);




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
          while (($data = fgetcsv($h, 10000, ",", '"', '"')) !== FALSE) 
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
        $x=0;
        foreach($data as $item){
            $extId=$item[0];
            $listingUrl=$item[1];
            $name=$item[5];
            $description=$item[6];
            $nho=$item[7];
            $pictureUrl=$item[8];
            $hostId=$item[9];


            $neighborhoodCleansed=$item[28];
            $hoodId=$this->getHoodId($neighborhoodCleansed);
           // echo $hoodId."<br>";
            $latitude=$item[30];
            $longitude=$item[31];
            $roomType=$item[33];
            $roomTypeId=$this->getRoomTypeId($roomType);
            //echo "<p>rt: $roomTypeId</p>";
            $accomodates=$item[34];
            $baths=$item[36];
            $z=explode(" ", $baths);
            $bathrooms=floatval($z[0]);


            $bedrooms=$item[37];
            if (strlen($bedrooms)==0){$bedrooms=0;}
            $beds=$item[38];
            if($beds==""){$beds=0.0;}
            $amenities=$item[39];
            $p=$item[40];
            $price=floatval(ltrim($p, "$"));
            $minNights=$item[41];
            $maxNights=$item[42];
            $numReviews=$item[56];
            $rating=$item[61];
            if ($rating==""){$rating=1.0;}

           // echo "<div>$listingUrl,$name,$description,$nho, $pictureUrl,$hostId, $hoodId, $latitude, $longitude, $roomTypeId, $accomodates, $bathrooms, $bedrooms, $beds,$price, $minNights, $maxNights, $numReviews, $rating, $extId</div>";
            
           // echo "<div>$extId: $description</div>";
           /// echo "<hr>";
           if (!$this->checkListing($extId)){

            echo "<div><p>Amenities: $amenities"; 

            echo "</p><p>listingURL: $listingUrl</p>,<p>Name: $name</p>,<p>Desc: $description</p>,<p>NH overview: $nho</p>, <p>Pic url: $pictureUrl</p>,<p>host id: $hostId</p>, <p>hood id: $hoodId</p>, <p>lat: $latitude</p>, <p>lon: $longitude</p>, <p>room type id: $roomTypeId</p>, <p>accommodates: $accomodates</p>, <p>bathrooms: $bathrooms</a>, <p>bedrooms: $bedrooms</p>, <p>beds: $beds</p>,<p>price: $price</p>, <p>min: $minNights</p>, <p>max: $maxNights</p>, <p>num reviews:$numReviews</p>, <p>rating: $rating</p>, <p>ext id: $extId</p></div>";


            $this->addListing($listingUrl,$name,$description,$nho, $pictureUrl,$hostId, $hoodId, $latitude, $longitude, $roomTypeId, $accomodates, $bathrooms, $bedrooms, $beds,$price, $minNights, $maxNights, $numReviews, $rating, $extId);
            $x++;
           }
                       //if($x<1){
                //$this->addListing($listingUrl,$name,$description,$nho, $pictureUrl,$hostId, $hoodId, $latitude, $longitude, $roomTypeId, $accomodates, $bathrooms, $bedrooms, $beds,$price, $minNights, $maxNights, $numReviews, $rating, $extId);

           // }

            

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

    function populateHostsTable($data){
        $hosts=array();
        foreach($data as $item){
            $host_id=$item[9];
            $hostUrl=$item[10];
            $hostName=$item[11];
            $hostLocation=$item[13];
            $hostAbout=$item[14];
            $isSh=$item[18];
            $hostPic=$item[19];



            
            if(!array_key_exists($host_id, $hosts)){
               // array_push($hosts, $host_id);
                $hosts[$host_id]["url"]=$hostUrl;
                $hosts[$host_id]["name"]=$hostName;
                $hosts[$host_id]["location"]=$hostLocation;
                $hosts[$host_id]["about"]=$hostAbout;
                $hosts[$host_id]["superhost"]=$isSh;
                $hosts[$host_id]["pic"]=$hostPic;
            }

        }
        //var_dump($hosts);
        $this->insertHosts($hosts);
 
    }

    function checkListing($extId){
        $db=$this->db;

        try{
            $stmt=$db->prepare("select id from listings where extId=:extId");
            $stmt->execute(array(":extId"=>$extId));
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows)==1){return true;}
            else{return false;}

        }
        catch(Exception $e){

        }
    }

    function addListing($listingUrl,$name,$description,$nho, $pictureUrl,$hostId, $hoodId, $latitude, $longitude, $roomTypeId, $accomodates, $bathrooms, $bedrooms, $beds,$price, $minNights, $maxNights, $numReviews, $rating, $extId){
        $db=$this->db;
        try {
            $stmt = $db->prepare("insert into listings (listingUrl, name, description, neighborhoodOverview, pictureUrl, hostId, neighborhoodId, latitude, longitude, roomTypeId, accommodates, bathrooms, bedrooms, beds, price, minNights, maxNights, numReviews, rating, extId) values (:listingUrl, :name, :description, :neighborhoodOverview, :pictureUrl, :hostId, :neighborhoodId, :latitude, :longitude, :roomTypeId, :accommodates, :bathrooms, :bedrooms, :beds, :price, :minNights, :maxNights, :numReviews, :rating, :extId)");
            
            
            if ($stmt->execute(array(":listingUrl"=>$listingUrl, ":name"=>$name, ":description"=>$description, ":neighborhoodOverview"=>$nho, ":pictureUrl"=>$pictureUrl, ":hostId"=>$hostId, ":neighborhoodId"=>$hoodId, ":latitude"=>$latitude, ":longitude"=>$longitude, ":roomTypeId"=>$roomTypeId, ":accommodates"=>$accomodates, ":bathrooms"=>$bathrooms, ":bedrooms"=>$bedrooms, ":beds"=>$beds, ":price"=>$price, ":minNights"=>$minNights, ":maxNights"=>$maxNights, ":numReviews"=>$numReviews, ":rating"=>$rating, ":extId"=>$extId))){
                
                $last= $db->lastInsertId(); 
                echo "<p>$extId: $last</p>";

            }
            else{echo "<p>falied: $extId</p>";}
            //$stmt->fetchAll(PDO::FETCH_ASSOC);
            //echo "hello";
            //echo $db->lastInsertId();               
        }
        catch (Exception $e) {               
            echo $e;
        }


    }





    function insertHoods($hoods){
        $db=$this->db;

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
        $db=$this->db;

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
        $db=$this->db;

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

    function insertHosts($hosts){

        $db=$this->db;

        foreach ($hosts as $hostId=>$h){
            
            $hostUrl=$h["url"];
            $hostName=$h["name"];
            $hostLocation=$h["location"];
            $hostAbout=$h["about"];
            $isSh=$h["superhost"];
            $hostPic=$h["pic"];

            if($isSh=="t"){$sh=1;}
            if($isSh=="f"){$sh=0;}

            
            try {
                $stmt = $db->prepare("insert into hosts (id, hostUrl, hostName, hostLocation, hostAbout, superhost, hostPic) values (:id, :hostUrl, :hostName, :hostLocation, :hostAbout, :superhost, :hostPic)");
                
                $stmt->execute(array(":id"=>$hostId, ":hostUrl"=>$hostUrl, ":hostName"=>$hostName, ":hostLocation"=>$hostLocation, ":hostAbout"=>$hostAbout, ":superhost"=>$sh, ":hostPic"=>$hostPic));
                $stmt->fetchAll(PDO::FETCH_ASSOC);
               // echo $db->lastInsertId();               
            }
            catch (Exception $e) {               
                echo $e;
            }
            
        }

    }

    function getHoodId($hood){
        $db=$this->db;
        try {
            $stmt = $db->prepare("select id from neighborhoods where neighborhood=:hood");
            
            $stmt->execute(array(":hood"=>$hood));
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $id=$rows[0]["id"];
           // echo $db->lastInsertId(); 
           return $id;              
        }
        catch (Exception $e) {               
            echo $e;
        }       


    }

    function getRoomTypeId($roomType){
        if(!isset($this->roomTypes)){
            $roomTypes=$this->setRoomTypes();

        }
        else{
            $roomTypes=$this->roomTypes;
        }
        $roomTypeId=$roomTypes[$roomType];
        return $roomTypeId;


    }

    function setRoomTypes(){
        $db=$this->db;
        $roomTypes=array();
        try {
            $stmt = $db->prepare("select * from roomTypes");
            
            $stmt->execute();
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($rows as $row){

                $id=$row["id"];
                $type=$row["type"];
                $roomTypes[$type]=$id;

            }
             
        }
        catch (Exception $e) {               
            echo $e;
        } 
        $this->roomTypes=$roomTypes;
        return $roomTypes;

    }


}

$parse=new parse();

$parse->process();
//$db=$parse->dbConnect();

//$parse->readCsv();

//$csv = array_map('str_getcsv', file('listings.csv'));

//var_dump($csv);


?>
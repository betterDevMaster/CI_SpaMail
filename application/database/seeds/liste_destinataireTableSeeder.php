<?php
include_once './vendor/autoload.php';
require_once './config_mail.php';
class liste_destinataireTableSeeder {
    private $servername = DATABASE_HOST;
    private $username = DATABASE_USERNAME;
    private $password = DATABASE_PASS;
    private $dbname = DATABASE_NAME;

    private $stmt = NULL;
    private $table = 'liste_destinataire';

    public function run() {
        $faker = Faker\Factory::create();
        

        try {

            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $conn->prepare("DELETE FROM $this->table");
            $sql->execute();
            $adresse_id = 0;
            for( $i=0; $i<10; $i++){
                $this->stmt =  $conn->prepare("INSERT INTO $this->table (libelle, adresse_id, mail_id) VALUES (:libelle, :adresse_id, :mail_id)");
                // $adresse_id_arr = array(0,1,2,3,4);
                $adresse_id++;
                $mail_id_arr = array(0,1,2,3,4,5,6,7,8);
                $libelle = $faker->name;
                // $adresse_id = array_rand($adresse_id_arr, 1);
                $mail_id = array_rand($mail_id_arr,1);


               
                $this->stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
                $this->stmt->bindParam(':mail_id', $mail_id, PDO::PARAM_INT);
                $this->stmt->bindParam(':adresse_id', $adresse_id, PDO::PARAM_INT);

                if($this->stmt->execute()) {
                  echo "1 row has been inserted \n ";  
                }

                
            }
            $conn = null;
         
           
        }   
        catch(PDOException $e){
            echo $e;
        }
    }

}
$buffer = new liste_destinataireTableSeeder();
$buffer->run();

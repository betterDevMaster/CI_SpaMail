<?php
include_once './vendor/autoload.php';
require_once './config_mail.php';
class adresseTableSeeder {
    private $servername = DATABASE_HOST;
    private $username = DATABASE_USERNAME;
    private $password = DATABASE_PASS;
    private $dbname = DATABASE_NAME;

    private $stmt = NULL;
    private $table = 'adresse';

    public function run() {
        $faker = Faker\Factory::create();
        


        try {

            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $conn->prepare("DELETE FROM $this->table");
            $sql->execute();
            $liste_destinataire_id =0;
            for( $i=0; $i<50; $i++){
                $liste_destinataire_id ++;
                $email = $faker->email;
                // $liste_destinataire_id_arr = array(2,3,4,5,6,7,8,9,10,11);
                if($liste_destinataire_id === 10){
                    $liste_destinataire_id = 1;
                }
                $nom = $faker->name;
                $prenom = $faker->name;
                $abo = 1;
                $this->stmt =  $conn->prepare("INSERT INTO $this->table (email, liste_destinataire_id, nom, prenom, abonnee) VALUES (:email, :liste_destinataire_id, :nom, :prenom, :abonnee)");
               
                $this->stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $this->stmt->bindParam(':liste_destinataire_id', $liste_destinataire_id, PDO::PARAM_INT);
                $this->stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $this->stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $this->stmt->bindParam(':abonnee', $abo, PDO::PARAM_INT);

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
$buffer = new adresseTableSeeder();
$buffer->run();

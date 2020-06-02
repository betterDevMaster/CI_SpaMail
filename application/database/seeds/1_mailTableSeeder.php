<?php
include_once './vendor/autoload.php';
require_once './config_mail.php';
class mailTableSeeder {
    private $servername = DATABASE_HOST;
    private $username = DATABASE_USERNAME;
    private $password = DATABASE_PASS;
    private $dbname = DATABASE_NAME;

    private $stmt = NULL;
    private $table = 'mail';

    public function run() {
        

        $faker = Faker\Factory::create();
        try {

            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $conn->prepare("DELETE FROM $this->table");
            $sql->execute();
            $type_arr = array('html','text');

            $status_arr = array(0,1);
            for( $i=0; $i<10; $i++){
                $this->stmt =  $conn->prepare("INSERT INTO $this->table (type, sujet, date_envoi, status, token, email, nom, corps_mail) VALUES (:type, :sujet, :date_envoi, :status, :token, :email, :nom, :corps_mail)");
                
                $type = $type_arr[array_rand($type_arr,1)];
                $sujet= $faker->name;
                $date_envoi = $faker->date;
                $status = array_rand($status_arr, 1) ;
                $email = $faker->email;
                $nom = $faker->name;
                $token = $this->randomString();
                $corps_mail= $faker->text;

                $this->stmt->bindParam(':type', $type, PDO::PARAM_STR);
                $this->stmt->bindParam(':sujet', $sujet, PDO::PARAM_STR);
                $this->stmt->bindParam(':date_envoi', $date_envoi, PDO::PARAM_STR);
                $this->stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
                $this->stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $this->stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $this->stmt->bindParam(':corps_mail', $corps_mail, PDO::PARAM_STR);
                $this->stmt->bindParam(':token', $token, PDO::PARAM_STR);
                
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
    public function randomString($length = 20) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}
$buffer = new mailTableSeeder();
$buffer->run();

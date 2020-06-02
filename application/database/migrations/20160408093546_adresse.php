<?php
require_once './config_mail.php';
class Migration_adresse extends CI_Migration {
    private $servername = DATABASE_HOST;
    private $username = DATABASE_USERNAME;
    private $password = DATABASE_PASS;
    private $dbname = DATABASE_NAME;
    private $sql = NULL;

    public function up() {
        try {

            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            //sql to create the activity registered table

            /*$sql = 'CREATE TABLE adresse (

                exemple for syntax
                Activity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                participant_id INT(6) FOREIGN KEY (participant_id) REFERENCES participants,
                entry_number INT(2),
                recorded_result INT(6),
                entry_date TIMESTAMP


                 request here

            )';*/

            $this->sql = 'CREATE TABLE adresse (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(150) NOT NULL,
                liste_destinataire_id INT(11) UNSIGNED,
                nom VARCHAR(150) ,
                prenom VARCHAR(150) ,
                abonnee INT(11) UNSIGNED,
                CONSTRAINT adresse_liste_destinataire_id_liste_destinataire_foreign FOREIGN KEY (liste_destinataire_id) REFERENCES liste_destinataire (id) ON delete CASCADE
               

            )';


            //use exec() because no results are returned
            $conn->exec($this->sql);
            echo "Table Activity Recorder created successfully \n";
        }
        catch(PDOException $e){
            echo $this->sql . $e->getMessage();
        }

        $conn = null;
    }

    public function down() {
        $this->sql= $conn->prepare("DROP TABLE adresse");
        $conn->exec($this->sql);
    }

}
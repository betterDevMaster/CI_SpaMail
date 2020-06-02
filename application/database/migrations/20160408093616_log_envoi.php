<?php
require_once './config_mail.php';
class Migration_log_envoi extends CI_Migration {
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

            /*$sql = 'CREATE TABLE log_envoi (

                exemple for syntax
                Activity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                participant_id INT(6) FOREIGN KEY (participant_id) REFERENCES participants,
                entry_number INT(2),
                recorded_result INT(6),
                entry_date TIMESTAMP


                 request here

            )';*/

            $this->sql = 'CREATE TABLE log_envoi (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                mail_id INT(11) UNSIGNED,
                enregistrement INT(11),
                envoi INT(11),
                error INT(11),
                CONSTRAINT log_envoi_mail_id_mail_foreign FOREIGN KEY (mail_id) REFERENCES mail (id) ON DELETE CASCADE               

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
        $this->sql= $conn->prepare("DROP TABLE log_envoi");
        $conn->exec($this->sql);
    }

}
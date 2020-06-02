<?php
include_once './vendor/autoload.php';

class ArtisanP extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }

        $this->load->dbforge();

        // initiate faker
        $this->faker = Faker\Factory::create();
    }

    public function message($to = 'World') {
        echo "Hello {$to}!" . PHP_EOL;
    }

    public function help() {
        $result = "The following are the available command line interface commands\n\n";
        $result .= "php index.php tools migration \"file_name\"         Create new migration file\n";
        $result .= "php index.php tools migrate [\"version_number\"]    Run all migrations. The version number is optional.\n";
        $result .= "php index.php tools seeder \"file_name\"            Creates a new seed file.\n";
        $result .= "php index.php tools seed \"file_name\"              Run the specified seed file.\n";

        echo $result . PHP_EOL;
    }

    public function migration($name) {
        $this->make_migration_file($name);
    }

    public function migrate($version = null) {
        $this->load->library('migration');

        if ($version != null) {
            if ($this->migration->version($version) === FALSE) {
                show_error($this->migration->error_string());
            } else {
                echo "Migrations run successfully" . PHP_EOL;
            }

            return;
        }

        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migrations run successfully" . PHP_EOL;
        }
    }


    public function seeder($name) {
        $this->make_seed_file($name);
    }

    public function seed($name) {
        if($name ==="all"){
            foreach (glob("application/database/seeds/*.php") as $filename)
            {
                $cmd = "php ".$filename;
                echo shell_exec($cmd);
            }
        }
        else{
            $cmd = "php application/database/seeds/$name.php";
            echo shell_exec($cmd);
        }
        echo"seed run done !";
    }

    protected function make_migration_file($name) {
        $date = new DateTime();
        $timestamp = $date->format('YmdHis');

        $table_name = strtolower($name);

        $path = APPPATH . "database/migrations/$timestamp" . "_" . "$name.php";

        $my_migration = fopen($path, "w") or die("Unable to create migration file!");

        $migration_template = "<?php

class Migration_$name extends CI_Migration {
    private \$servername = 'localhost';
    private \$username = 'root';
    private \$password = NULL;
    private \$dbname = 'mailing_kertios';
    private \$sql = NULL;

    public function up() {
        try {

            \$conn = new PDO(\"mysql:host=\$this->servername;dbname=\$this->dbname\", \$this->username, \$this->password);
            //set the PDO error mode to exception
            \$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            //sql to create the activity registered table

            /*\$sql = 'CREATE TABLE $table_name (

                exemple for syntax
                Activity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                participant_id INT(6) FOREIGN KEY (participant_id) REFERENCES participants,
                entry_number INT(2),
                recorded_result INT(6),
                entry_date TIMESTAMP


                 request here

            )';*/

            \$this->sql = 'CREATE TABLE $table_name (

               

            )';

            //use exec() because no results are returned
            \$conn->exec(\$this->sql);
            echo \"Table Activity Recorder created successfully \\n\";
        }
        catch(PDOException \$e){
            echo \$this->sql . \$e->getMessage();
        }

        \$conn = null;
    }

    public function down() {
        \$this->sql= \$conn->prepare(\"DROP TABLE $table_name\");
        \$conn->exec(\$this->sql);
    }

}";

        fwrite($my_migration, $migration_template);

        fclose($my_migration);

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    protected function make_seed_file($name) {
        $path = APPPATH . "database/seeds/$name.php";

        $my_seed = fopen($path, "w") or die("Unable to create seed file!");

        $seed_template = "<?php

class $name {
    private \$servername = 'localhost';
    private \$username = 'root';
    private \$password = NULL;
    private \$dbname = 'mailing_kertios';
    private \$stmt = NULL;
    private \$table = 'users';

    public function run() {
        


        try {

            \$conn = new PDO(\"mysql:host=\$this->servername;dbname=\$this->dbname\", \$this->username, \$this->password);
            //set the PDO error mode to exception
            \$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            \$sql = \$conn->prepare(\"TRUNCATE TABLE \$this->table\");
            \$sql->execute();
            \$this->stmt =  \$conn->prepare(\"INSERT INTO \$this->table (..,..) VALUES (:.., :.., :.., :..)\");
           
            \$this->stmt->bindParam(':..', \$.., PDO::PARAM_STR);

            if(\$this->stmt->execute()) {
              echo \"1 row has been inserted \\n \";  
            }

            \$conn = null;
         
           
        }   
        catch(PDOException \$e){
            echo \$e;
        }
    }

}
\$buffer = new $name();
\$buffer->run();
";

        fwrite($my_seed, $seed_template);

        fclose($my_seed);

        echo "$path seeder has successfully been created." . PHP_EOL;
    }

}

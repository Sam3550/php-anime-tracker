<?php

class DatabaseSingleton
{
    // Class that represents a Singleton Pattern. 
    // This type of pattern is used in order to only have on instance ever exisiting. 
    // A little bit confusing compared to "basic" object oriented programming.
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        // FIXME : Move these credentials to a .env file

        $host = '127.0.0.1';
        $port = 3306;
        $dbname = 'anime-tracker';
        $user = 'root';
        $password = 'password';
        try {
            $this->conn = new PDO(
                "mysql:host=$host:$port;dbname=$dbname",
                $user,
                $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
            );
        } catch (PDOException $e) {
            error_log('Error whilst connecting to database. ');
            throw $e;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseSingleton();
        }

        return self::$instance;
    }

    public function query(string $query): array
    {
        // To use only if there are no variables
        $results = $this->conn->query($query);
        return $results->fetchAll(PDO::FETCH_COLUMN);
    }

    public function prepare(string $query)
    {
        return $this->conn->prepare($query);

    }

}
function file_to_associative_array(string $csvFilepath): array
{
    /**
     * Reads a CSV file and returns an array of arrays. 
     * Sub Array contains a $key => value format respecting the csv headers
     */

    // read all lines and store it in a csv file.
    $csv_lines = array_map("str_getcsv", file($csvFilepath, FILE_SKIP_EMPTY_LINES));

    // Read all keys
    $keys = array_shift($csv_lines);

    // Generate an associative key => value for each record
    foreach ($csv_lines as $i => $row) {
        $csv_lines[$i] = array_combine($keys, $row);
    }
    return $csv_lines;
}


function clean_array($array)
{
    // Each record of the array is trimmed 
    // Duplicates are removed.

    $array = array_map("trim", $array);
    $array = array_unique($array);
    return $array;
}
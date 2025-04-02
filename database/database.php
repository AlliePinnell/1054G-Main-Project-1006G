<?php
// Define 'Database' class
class Database {
    // Protected property to hold database connection
    protected $connection;

    // Constructor method to initialize database connection
    function __construct() {
        // Check if connection has not been set
        if(!isset($this->connection)) {
            // Create a new mysql connection to Revo database
            $this->connection = new mysqli('localhost', 'root', 'mysql', 'revo');
            
            // Check if the connection was not successful
            if(!$this->connection) {
                // If the connection failed, terminate the script and display an error message
                die("Database connection failed" . mysqli_connect_error() . mysqli_connect_error());
            }
        }
        // Return the connection
        return $this->connection;
    }
}
?>

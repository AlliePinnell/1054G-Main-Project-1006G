<?php
    /* SERVER SETUP */
    // Include database class
    require_once 'database/database.php';

    // Define 'crud' class that extends the 'database' class
    class crud extends database {
        
        // Calls parent 'database' constructor to initialize database connection
        public function __construct() {
            parent::__construct();
        }

        // Method to get the database connection
        public function getConnection() {
            return $this->connection;
        }

        // Method to execute a given SQL query
        public function execute($query) {
            // Execute the SQL query using the database connection
            $result = $this->connection->query($query);
            
            // Check if the query execution was successful
            if($result == false) {
                // If the query failed, display an error message
                echo "<p>Cannot execute the command</p>";
                return false;
            } else {
                // If the query succeeded, return true
                return true;
            }
        }

        // Method to escape special characters in a string for use in SQL statements
        public function escape_string($value) {
            // Use the 'real_escape_string' method of the database connection to escape the string
            return $this->connection->real_escape_string($value);
        }

        /* POST HANDLING */
        // Retrieves posts filtered by eraTag or returns all posts ordered by eraTag
        public function getPosts($eraTag) {
            if ($eraTag != null) { // eratag not null. specific era of posts being shown
                $query = "SELECT * FROM revoposts WHERE eraTag = ? ORDER BY FIELD(eraTag, 80, 90, 2000, 10, 20)";
                $revo = $this->connection->prepare($query); // Prepares the query
                $revo->bind_param("i", $eraTag); // Binds the eraTag parameter as an integer
            } else { // If the eratag is null (all posts are shown)
                $query = "SELECT * FROM revoposts ORDER BY FIELD(eraTag, 80, 90, 2000, 10, 20)";
                $revo = $this->connection->prepare($query); // Prepares query to fetch all posts
            }

            $revo->execute(); // Executes the prepared query
            $result = $revo->get_result(); // Retrieves the query result
            
            $posts = [];
            while ($row = $result->fetch_assoc()) { // Loops through the result rows
                $posts[] = $row; // Adds each row to the posts array
            }

            if ($posts == null) { // Checks if no posts were fetched
                echo "<div class='post'>";
                echo "<p>No results</p>"; // Outputs "No results" message
                echo "</div>";
            }

            return $posts; // Returns the posts array
        }

        // Retrieves posts by a specific user handle and orders them by eraTag
        public function getuserPosts($handle) {
            $query = "SELECT * FROM revoposts WHERE handle = ? ORDER BY FIELD(eraTag, 80, 90, 2000, 10, 20)";
            $revo = $this->connection->prepare($query); // Prepares the query
            $revo->bind_param("s", $handle); // Binds the user handle parameter

            $revo->execute(); // Executes the query
            $result = $revo->get_result(); // Retrieves the result
            
            $userPosts = [];
            while ($row = $result->fetch_assoc()) { // Iterates through result rows
                $userPosts[] = $row; // Adds each row to userPosts array
            }

            if ($userPosts == null) { // Checks if no posts were found
                echo "<div class='post'>";
                echo "<p>No results</p>"; // Outputs "No results" message
                echo "</div>";
            }

            return $userPosts; // Returns the user posts array
        }

        // Retrieves posts based on a specific selection or viewTag, filtered by user handle
        public function getSelectedPosts($viewTag, $handle, $selection) {
            if ($viewTag != null) { //if viewTag is not null (showing played, replayed, recorded posts)
                $query = "SELECT DISTINCT revoposts.* FROM revoposts JOIN revoactions ON revoposts.postid = revoactions.postid WHERE revoactions.handle = ? AND revoactions.$selection = 1 ORDER BY FIELD(revoposts.eraTag, '80', '90', '2000', '10', '20')";
            } else { // showing all posts from a user
                $query = "SELECT DISTINCT * FROM revoposts WHERE handle = ? ORDER BY FIELD(eraTag, '80', '90', '2000', '10', '20')";
            }

            $revo = $this->connection->prepare($query); // Prepares the query
            $revo->bind_param("s", $handle); // Binds user handle parameter
            $revo->execute(); // Executes the query
            $result = $revo->get_result(); // Fetches the query result

            $selectedPosts = [];
            while ($row = $result->fetch_assoc()) { // Iterates through rows
                $selectedPosts[] = $row; // Adds each row to selectedPosts array
            }

            if (empty($selectedPosts)) { // Checks if no posts were found
                echo "<div class='post'>";
                echo "<p>No results</p>"; // Outputs "No results" message
                echo "</div>";
            }

            return $selectedPosts; // Returns the selected posts array
        }
            
        /* ACTION HANDLING */
        // Checks if the post is liked by the user handle
        public function checkLike($handle, $postId) {
            $query = $this->connection->prepare("SELECT played FROM revoactions WHERE handle = ? AND postid = ?");
            $query->bind_param("si", $handle, $postId); // Binds handle and postId
            $query->execute(); // Executes query
            $result = $query->get_result(); // Retrieves result
            return $result->fetch_assoc(); // Returns associative array with results
        }
        
        // Checks if the post is replayed by the user handle
        public function checkReplay($handle, $postId) {
            $query = $this->connection->prepare("SELECT replayed FROM revoactions WHERE handle = ? AND postid = ?");
            $query->bind_param("si", $handle, $postId);
            $query->execute();
            $result = $query->get_result();
            return $result->fetch_assoc();
        }

        // Checks if the post is recorded by the user handle
        public function checkRecord($handle, $postId) {
            $query = $this->connection->prepare("SELECT recorded FROM revoactions WHERE handle = ? AND postid = ?");
            $query->bind_param("si", $handle, $postId);
            $query->execute();
            $result = $query->get_result();
            return $result->fetch_assoc();
        }


        /* IMAGE HANDLING */
        // Retrieves profile and banner image data for the given handle
        public function imageHandler($handle) {
            $revo = $this->connection->prepare("SELECT profileImage, profileName, bannerImage, bannerName FROM revoaccounts WHERE handle = ?");
            $revo->bind_param("s", $handle);
            $revo->execute();
            $imagelist = $revo->get_result();

            $images = [];
            while ($row = $imagelist->fetch_assoc()) { // Iterates through result rows
                $images[] = $row; // Adds each row to images array
            }

            return $images; // Returns the images array
        }

        /* ACCOUNT CHECKS */
        // Checks if a variable value is duplicated in the database
        public function isDuplicate($name, $variable) {
            $query = $this->connection->prepare("SELECT * FROM revoaccounts WHERE $name = ?");
            $query->bind_param("s", $variable); // Binds variable parameter
            $query->execute();
            $result = $query->get_result();
        
            $isDuplicate = $result->num_rows > 0; // Returns true if duplicate exists
            return $isDuplicate;
        }

        // Validates user credentials (handle and password)
        public function checkCredentials($handle, $psword) {
            $query = "SELECT * FROM revoaccounts WHERE handle = '$handle' AND psword = '$psword'";
            $result = $this->connection->query($query); // Executes the query

            $doesExist = $result->num_rows > 0; // Returns true if credentials match
            return $doesExist;
        }

        /* ADMIN HANDLING */
        // Retrieves all accounts from a specified table
        public function getAllInfo($table) {
            $query = "SELECT * FROM " . $this->escape_string($table); // Escapes table name
            $revo = $this->connection->prepare($query);
            $revo->execute();
            $result = $revo->get_result();

            $info = [];
            while ($row = $result->fetch_assoc()) { // Iterates through result rows
                $info[] = $row; // Adds each row to info array
            }

            return $info; // Returns the account information
        } 

        // Updates account information (accountid, fname, lname, email, monthEntry, dayEntry, yearEntry)
        public function editAccount($accountid, $fname, $lname, $email, $monthEntry, $dayEntry, $yearEntry) {
            $account = $this->connection->query("UPDATE revoaccounts SET 
                    fname = '$fname',
                    lname = '$lname',
                    email = '$email',
                    monthEntry = '$monthEntry',
                    dayEntry = '$dayEntry',
                    yearEntry = '$yearEntry'
                WHERE accountid = '$accountid'
            "); //change account info based on the id location
            return $account; // Returns the query result
        }
        
        // Updates post details (content, plays, replays, records, eraTag)
        public function editPost($postid, $content, $plays, $replays, $records, $eraTag) {
            $post = $this->connection->query("UPDATE revoposts SET 
                    content = '$content',
                    plays = '$plays',
                    replays = '$replays',
                    records = '$records',
                    eraTag = '$eraTag'
                WHERE postid = '$postid'
            ");
            return $post; // Returns the query result
        }

        // Updates action details (actionid, postid, played, replayed, recorded)
        public function editAction($actionid, $postid, $played, $replayed, $recorded) {
            $action = $this->connection->query("SELECT played, replayed, recorded FROM revoactions WHERE actionid = '$actionid'")->fetch_assoc();
        
            // Update the action data with new values for played, replayed, and recorded
            $editAction = $this->connection->query("UPDATE revoactions SET 
                        played = '$played',
                        replayed = '$replayed',
                        recorded = '$recorded'
                    WHERE actionid = '$actionid'
            ");
            
            // Flag to track if updates to posts are successful
            $editPosts = true;
        
            // Check if the 'played' count has increased or decreased and update the related post's plays
            if ($played > $action['played']) {
                $editPosts = $this->connection->query("UPDATE revoposts SET plays = plays + 1 WHERE postid = '$postid'");
            } elseif ($played < $action['played']) {
                $editPosts = $this->connection->query("UPDATE revoposts SET plays = plays - 1 WHERE postid = '$postid'");
            }
        
            // Check if the 'replayed' count has increased or decreased and update the related post's replays
            if ($replayed > $action['replayed']) {
                $editPosts = $this->connection->query("UPDATE revoposts SET replays = replays + 1 WHERE postid = '$postid'");
            } elseif ($replayed < $action['replayed']) {
                $editPosts = $this->connection->query("UPDATE revoposts SET replays = replays - 1 WHERE postid = '$postid'");
            }
        
            // Check if the 'recorded' count has increased or decreased and update the related post's records
            if ($recorded > $action['recorded']) {
                $editPosts = $this->connection->query("UPDATE revoposts SET records = records + 1 WHERE postid = '$postid'");
            } elseif ($recorded < $action['recorded']) {
                $editPosts = $this->connection->query("UPDATE revoposts SET records = records - 1 WHERE postid = '$postid'");
            }
        
            // Return true if both the action update and post updates are successful
            return $editAction && $editPosts;
        }
    }
?>

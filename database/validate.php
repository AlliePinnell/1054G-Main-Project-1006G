<?php
    class validate { // Define a new class named validate
        // Function to check if any of the specified fields are empty
        public function checkEmpty($data, $fields) {
            $message = null; // Initialize the message variable
            foreach ($fields as $value) { // Loop through each field
                if (empty($data[$value])) { // Check if the field is empty
                    $message .= " $value "; // Append the field name to the message
                }
            }
            return $message; // Return the message with empty field names
        }

        // Function to validate an email address 
        public function validEmail($email) {
            $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; // Define the email pattern
            if (preg_match($pattern, $email)) { // Check if the email matches the pattern
                return true; // Return true if the email is valid
            }
            return false; // Return false if the email is not valid
        }

        // Function to validate a password based on specific criteria
        public function validPassword($psword) {
            if (preg_match('/[A-Z]/', $psword) && // Check if there's at least one uppercase letter
                preg_match('/[0-9]/', $psword) && // Check if there's at least one number
                preg_match('/[a-z]/', $psword)) { // Check if there's at least one lowercase letter
                return ''; // Return an empty string if the password is valid
            }
            // Return an error message if the password does not meet the criteria
            return "<p>Password must include at least one number, one uppercase letter and one lowercase letter</p>";
        }
        
        public function validName($name){
            if (preg_match('/[a-zA-Z]/', $name) && // Check if there's at least one uppercase letter
                !preg_match('/[0-9]/', $name)) { // Ensure there are NO numbers
                return true; // Return true if the name meets the criteria
            }
            return false; // Return false if the name does not meet the criteria
        }
    }
?>

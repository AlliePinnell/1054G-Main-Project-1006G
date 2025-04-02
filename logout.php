<?php
    session_start(); // Start a session or resume the current one
    session_unset(); // Unset all session variables, effectively clearing them
    session_destroy(); // Destroy the current session completely
    header("Location: ./index.php"); // Redirect the user to the index page
    exit(); // Ensure that no further code is executed after the redirect
?>
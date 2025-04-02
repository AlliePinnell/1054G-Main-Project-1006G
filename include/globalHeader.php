<!doctype html>
<?php
    // This code adds a class to the entire html based on if the user is on index.php
    // The only real change is just the background being purple versus the rest of the site
    // having a white background
    if ($isIndex == true) {
        echo '<html lang="en" class="indexBackground">';
    }
    else
    {
        echo '<html lang="en">';
    }
?>
    <head>
        <!-- Basic meta tags for character encoding, viewport settings, and search engine instructions -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <meta name="description" content="<?php echo $pageDesc; ?>"> <!-- Dynamic description for the page -->
        <link rel="icon" type="image/x-icon" href="./img/icon.png"> <!-- Link to site favicon -->
        <title><?php echo "Revo / " . $pageTitle; ?></title> <!-- Dynamic page title -->

        <!-- External stylesheets for resetting and custom styles -->
        <link rel="stylesheet" href="./css/reset.css">
        <link rel="stylesheet" href="./css/style.css">

         <!-- External JavaScript for additonal displays (posting, editing, deleting) -->
        <script src="./script/script.js" defer></script>

        <!-- google fonts link -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&family=Russo+One&display=swap" rel="stylesheet">
    </head>
    <body>
        <!-- Mobile menu toggle button -->
        <button class="navToggleBtn" id="mobileMenu">☰</button>

        <?php
            $page_message = ''; // Initialize a variable for error or status messages

            // Include database interaction and validation functionality
            include_once('database/crud.php');
            include_once('database/validate.php');

            // Create instances of the CRUD and validation classes
            $crud = new crud();
            $valid = new Validate();

            // Handle form submission for logging in an account
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'login_account') {
                // Escape and sanitize user inputs
                $handle = $crud->escape_string($_POST['handle']);
                $psword = $crud->escape_string(hash('sha512', $_POST['psword']));
            
                // Check credentials against the database
                if ($crud->checkCredentials($handle, $psword)) {
                    // Set the session variable for the handle and redirect to the home page
                    $_SESSION['handle'] = $handle;
                    header("Location: home.php");
                } else {
                    // Set error message for invalid login credentials
                    $page_message = "Invalid handle or password.";
                }
            }

            if (isset($_SESSION['handle'])) {
                $handle = $_SESSION['handle'];
                $imagelist = $crud->imageHandler($handle);
            }
           

            // If this is not the index page, display the header with the logo
            if ($isIndex == false) {
                echo '<section class="homeHeader">';
                echo '<img src="./img/horizontalLogo.png" alt="placeholder" class="placeholder">';
                echo '</section>';
            }
        ?>

        <!-- Section for the mobile navigation display -->
        <section class="navDisplay">
            <?php
                if ($isIndex == true) {
                    echo '<section class="indexNavigation">';
                }
                else {
                    echo '<section class="homeNavigation">';
                }
            ?>
            
                <div class="navLinks"> <!-- links for for navigation around the site -->
                   <?php
                        if (isset($_SESSION['handle']) && $_SESSION['handle'] != '') { // if the user is logged in, display the log out link and the admin page link
                            foreach ($imagelist as $image) { 
                                // Loop through the list of images and display the profile picture as a clickable link
                                echo '<button id="profileBtn">';
                                echo '<img src="' . htmlspecialchars($image['profileImage']) . '" title="' . htmlspecialchars($image['profileName']) . '">';
                                echo '</button>';
                            }
                        }
                        else {
                            if ($isIndex == false) {
                                echo '<button id="loginBtn">';
                                echo '<img src="./img/SignIn.png" alt="placeholder" class="placeholder">';
                                echo '</button>';
                            }
                        }
                    ?>
                    <!-- navigation links that anyone can use and view -->
                    <a href="home.php">Home</a> 
                    <a href="about.php">About</a>
                    <a href="eras.php">Eras</a>

                    <?php
                        if (isset($_SESSION['handle']) && $_SESSION['handle'] != '') { // if the user is logged in, display the log out link and the admin page link
                            echo '<a href="admin.php">Admin</a>';
                            echo '<a href="logout.php">Log Out</a>';
                        }
                        else {
                            if ($isIndex == false) {
                                echo '<a href="index.php">Sign Up</a>';
                            }
                        }
                    ?>
                </div>
            </section>
         </section>

         <section class="loginDisplay">
            <form class="loginAccount" method="post">
                <!-- Section for logging in -->
                <h1>Log In</h1>

                <!-- Hidden input specifying the form type -->
                <input type="hidden" name="form_type" value="login_account">

                <!-- Handle input for login -->
                <div>
                    <label for="loginHandle">Handle</label>
                        <div>
                            <input type="text" name="handle" id="loginHandle" placeholder="@Example123" required>
                        </div>
                    </div>

                <!-- Password input for login -->
                <div>
                    <label for="loginPsword">Password</label>
                    <div>
                        <input type="password" name="psword" id="loginPsword" required>
                    </div>
                </div>

                <!-- Submit button for logging in -->
                <div>
                    <input type="submit" value="Log In">
                </div>
            </form>
            <button id="closeBtnLogin"></button>
        </section>
<?php
    session_start(); // Start a new or resume an existing session

    //go back to sign in page if no handle in session
    if (!isset($_SESSION['handle']) || $_SESSION['handle'] == '') {
        Header('location:index.php');
        exit;
    }

    $pageTitle = $_SESSION['handle']; // Set the title of the page
    $pageDesc = 'Your Profile on REVO'; // Set a description for the page
    $isIndex = false; // Flag indicating whether this is the index page
    include './include/globalHeader.php'; // Include the global header bar from the specified file path
    include './include/globalPostSystem.php'; // Include the global post system (that controls post functions)

    if (isset($_POST['postImage'])) {
        // count the total files provided
        $countfiles = count($_FILES['files']['name']);
        $connection = $crud->getConnection(); // Establishing a connection to the database

        // Determine if the user is saving a profile picture or banner
        if ($_POST['postImage'] == 'Save Profile Pic') {
            $query = "UPDATE revoaccounts SET profileImage = ? WHERE handle = ?";
            $target_dir = './img/profilePics/'; // Directory for profile pictures
        } elseif ($_POST['postImage'] == 'Save Profile Banner') {
            $query = "UPDATE revoaccounts SET bannerImage = ? WHERE handle = ?";
            $target_dir = './img/profileBanners/'; // Directory for profile banners
        }

        // Prepare the SQL query
        $revo = $connection->prepare($query);

        // Loop through all uploaded files
        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $_FILES['files']['name'][$i]; // Get the file name
            $target_file = $target_dir . $filename; // Define the target path for the file
            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION); // Extract the file extension
            $file_extension = strtolower($file_extension); // Convert the file extension to lowercase
            
            // Define valid file extensions for uploaded images
            $valid_extension = array("png", "jpeg", "jpg", "gif", "svg", "webp");

            // Check if the file has a valid extension
            if (in_array($file_extension, $valid_extension)) {
                // Move the file to the target directory and check if it succeeded
                if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)) {
                    $handle = $_SESSION['handle']; // Get the user handle from the session
                    // Bind parameters to the prepared statement and execute it
                    $revo->bind_param("ss", $target_file, $handle);
                    $revo->execute();
                }
            }
        }
    }

    // Grab the user handle from the session
    $handle = $_SESSION['handle'];
    // Call the imageHandler method to get a list of images associated with the user
    $imagelist = $crud->imageHandler($handle);
?>

        <section class="profileSection">
            <?php
                foreach ($imagelist as $image) { // loops through the list of images and display the banner image
                    echo '<img class="profileBanner" src="' . htmlspecialchars($image['bannerImage']) . '" title="' . htmlspecialchars($image['bannerName']) . '">';
                }
            ?>
            <section class="profileInfo">
                <?php
                foreach ($imagelist as $image) { // loop through the list of images and display the profile picture
                    echo '<img src="' . htmlspecialchars($image['profileImage']) . '" title="' . htmlspecialchars($image['profileName']) . '">';
                }
                ?>
                <h2><?php echo htmlspecialchars($_SESSION['handle']); ?></h2> <!-- display the user's handle -->
                
                <form method='post' enctype='multipart/form-data'>
                    <!-- File input for uploading a profile picture -->
                    <p><input type='file' name='files[]' /></p>
                    <!-- Submit button for saving the profile picture -->
                    <p><input id='submitBanner' type='submit' value='Save Profile Pic' name='postImage' /></p>
                </form>

                <form method='post' enctype='multipart/form-data'>
                    <!-- File input for uploading a profile banner -->
                    <p><input type='file' name='files[]' /></p>
                    <!-- Submit button for saving the profile banner -->
                    <p><input id='submitProfile' type='submit' value='Save Profile Banner' name='postImage' /></p>
                </form>
            </section>
        </section>

        <section class="profileBtns">
            <!-- buttons that are attached to user's posts -->
            <a href="myprofile.php" class="button">Posts</a>
            <a href="myprofile.php?view=played" class="button">Plays</a>
            <a href="myprofile.php?view=replayed" class="button">Replays</a>
            <a href="myprofile.php?view=recorded" class="button">Records</a>
        </section>
<?php
    $feedType = 1; // Define the type of feed to be displayed; 1 shows filtered posts (played, replayed, recorded) from current session user
    include './include/globalFeed.php'; // Include the global feed file, which presumably handles displaying the feed based on the feed type
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>
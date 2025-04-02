<?php
  session_start(); // Start a new or resume an existing session
  if (isset($_GET['handle'])) {
    $handle = htmlspecialchars($_GET['handle']);
  }
  $pageTitle = $handle; // Set the title of the page
  $pageDesc = 'A profile on REVO'; // Set a description for the page
  $isIndex = false; // Flag indicating whether this is the index page
  include './include/globalHeader.php'; // Include the global header bar from the specified file path
  include './include/globalPostSystem.php'; // Include the global post system (that controls post functions)
  $handle = htmlspecialchars($_GET['handle']); // format the handle in a way that the html can read
  $imagelist = $crud->imageHandler($handle); // grab the list of images for the specific user to display them
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
            <h2><?php echo htmlspecialchars($handle); ?></h2> <!-- display the user's handle -->
        </section>
    </section>

    <section class="profileBtns">
        <!-- buttons that are attached to user's posts -->
        <a href="profile.php?handle=<?php echo $handle; ?>" class="button">Posts</a>
        <a href="profile.php?handle=<?php echo $handle; ?>&view=played" class="button">Plays</a>
        <a href="profile.php?handle=<?php echo $handle; ?>&view=replayed" class="button">Replays</a>
    </section>
<?php
    $feedType = 2; // Define the type of feed to be displayed; 2 shows filtered posts (played, replayed, recorded) from user being viewed
    include './include/globalFeed.php'; // Include the global feed file, which presumably handles displaying the feed based on the feed type
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>
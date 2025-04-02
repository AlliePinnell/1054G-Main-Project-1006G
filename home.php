<?php
  session_start(); // Start a new or resume an existing session
  $pageTitle = 'Home'; // Set the title of the page
  $pageDesc = 'The Home page for REVO'; // Set a description for the page
  $isIndex = false; // Flag indicating whether this is the index page
  include './include/globalHeader.php'; // Include the global header bar from the specified file path
  include './include/globalPostSystem.php'; // Include the global post system (that controls post functions)
?>
  <section class="eraBtns">
      <a href="home.php" id="ALL" class="button">ALL</a> <!-- Link that directs to the homepage and shows content for all eras -->
      <a href="home.php?era=80" class="button">80s</a> <!-- Link that directs to the homepage with content filtered for the 1980s -->
      <a href="home.php?era=90" class="button">90s</a> <!-- Link that directs to the homepage with content filtered for the 1990s -->
      <a href="home.php?era=2000" class="button">00s</a> <!-- Link that directs to the homepage with content filtered for the 2000s -->
      <a href="home.php?era=10" class="button">10s</a> <!-- Link that directs to the homepage with content filtered for the 2010s -->
      <a href="home.php?era=20" class="button">20s</a> <!-- Link that directs to the homepage with content filtered for the 2020s -->
  </section>
<?php
    $feedType = 0; // Define the type of feed to be displayed; 0 shows all posts based on the era tag selected
    include './include/globalFeed.php'; // Include the global feed file, which presumably handles displaying the feed based on the feed type
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>
<?php
  session_start(); // Start a new or resume an existing session
  $pageTitle = 'About'; // Set the title of the page
  $pageDesc = 'The About page for REVO'; // Set a description for the page
  $isIndex = false; // Flag indicating whether this is the index page
  include './include/globalHeader.php'; // Include the global header bar from the specified file path
?>
        <header> 
            <section class="aboutHeader"> 
                <h1>About</h1>
            </section>
        </header>
        <main> 
            <section class="about"> 
                    <section class="aboutSections"> 
                        <div class="abtSecL">
                            <h3>What is REVO ?</h3> <!-- General summary about the site and what you should post on it -->
                            <p>REVO is an online message board dedicated to celebrating the individual passions and cherished memories of the eras that defined each generation. Whether it is the neon colours and boombox culture of the 1980s, the rise of boy bands and Y2K fashion of the 2000s, or the viral trends and digital revolutions of the 2020s, REVO is the place to hang and relive your favourite decade or to learn what made each era special. Want to share how you dressed in the 2000s by rocking double denim and chunky flip-flops? Or perhaps reminisce about 80s trips to the arcade, mixtapes, and shoulder pads? With REVO's easily accessible UI, revisiting past memories and creating new memories is just one click away. REVO isn’t simply a platform—it’s an ever growing time capsule, preserving and sharing the most prominent moments and trends that have shaped the lives of millions through the decades.</p>
                        </div>

                        <section class="aboutButns"> <!-- Section to explain buttons and how to use the site -->
                        <div class="singleButn">
                            <div class="postIcon postIcon1"></div> <!-- Explanation on how the post button works-->
                            <p>This is the button you press whenever you want to make a post. Clicking on this button will bring you to the post creation screen where you can input text into the text-box and add an era tag to it.</p>
                        </div>

                        <div class="singleButn">
                            <div class="postIcon postIcon2"></div> <!-- Explanation on the button that allows the jser to exit the post creation screen -->
                            <p>This is a back button that allows you to exit the post creation screen if you've decided you no longer want to create a post. Just click it to go back to the previous screen.</p>
                        </div>

                        <div class="singleButn">
                            <div class="postIcon postIcon3"></div> <!-- Information about the replay button -->
                            <p>Use the replays button to repost a post you really like to your own profile and share it with your followers</p>
                        </div>

                        <div class="singleButn">
                            <div class="postIcon postIcon4"></div> <!-- Information about how to use the plays button -->
                            <p>"plays" are REVO's version of a like button. Press the button on any post to let the poster know how much you liked their post.</p>
                        </div>

                        <div class="singleButn"> <!-- Dummary on the record button -->
                            <div class="postIcon postIcon5"></div>
                            <p>Privately save any posts to your records folder by pressing the record button on a post. This way, you can save it and look at it later</p>
                        </div>

                        <div class="singleButn"> <!-- Information on how the edit button works -->
                            <div class="postIcon postIcon6"></div>
                            <p>This button allows you to edit a post after its been created. When you make changes to your post, they'll overwrite your original post</p>
                        </div>

                        <div class="singleButn"> <!-- Information about the delete button -->
                            <div class="postIcon postIcon7"></div>
                            <p>Use this button to delete any one of your posts. Once deleted, the post is wiped off of the site forever !</p>
                        </div>
                    </section>


                    <div class="abtSecR"> <!--  Extra section about the creator of REVO (BONUS TEXT!!) -->
                            <h3>Who made REVO ?</h3>
                            <p>Phish Aey is known for his work on the global phenomenon that was the seafood-based E-Delivery™ pizza site, Seaside Slices.  After selling off his hugely popular pizza empire and looking for a new passion to fill his life, Phish began to reminisce about the good ol’ days and what made him happy in his life. He longed to connect with likeminded people who shared the same nostalgia for the past. Inspired by his early days on the internet, Phish aimed to create the most significant and prominent message board yet: REVO. Phish yearned for the creativity and sense of community he experienced with his earlier, lesser-known web projects. He wanted to establish a space where people, regardless of their age or background, could connect with others who share similar interests and fond memories. Now, with a renewed opportunity to demonstrate his good intentions, Phish is dedicated to helping individuals the world over to build connections based on shared experiences of their past; all in the hopes of creating a better future for all</p>
                    </div>
                </section>
            </section>            
        </main>
<?php
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>
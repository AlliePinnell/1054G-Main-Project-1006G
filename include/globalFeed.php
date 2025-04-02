<div class="feed">
    <?php
        if ($feedType == 1) { // if the feed type is 1 (user's profile / myprofile.php)
            $handle = $_SESSION['handle']; // get the user's handle and store it in a variable
            $viewTag = isset($_GET['view']) ? $_GET['view'] : null; 
            $selection = $viewTag;
            $posts = $crud->getSelectedPosts($viewTag, $handle, $selection);
        }
        elseif ($feedType == 2) { // if the feed type is 2 (specific profile / profile.php)
            $handle = $_GET['handle'];
            $viewTag = isset($_GET['view']) ? $_GET['view'] : null; 
            $selection = $viewTag;
            $posts = $crud->getSelectedPosts($viewTag, $handle, $selection);
        }
        else // (all posts / home.php)
        {
            $eraTag = isset($_GET['era']) ? $_GET['era'] : null; 
            $posts = $crud->getPosts($eraTag); 
        }

        foreach ($posts as $post) { // loop through all of the posts to display them
            echo "<div class='post'>";
            if ($post['eraTag'] == '2000') { // if the era tag attached to the post is the 2000s' era tag, make it display "00's" on the post
                echo "<h3 class='era'>00s</h3>";
            }
            else { // display the other era tags
                echo "<h3 class='era'>" . htmlspecialchars($post['eraTag']) . "s</h3>";
            }
            if (isset($_SESSION['handle']) && ($post['handle'] == $_SESSION['handle'])) { 
                echo "<h3><a href='myprofile.php'>" . htmlspecialchars($post['handle']) . "</a></h3>"; // if the handle is the user's account, link them to the my profile page
            }
            else {
                echo "<h3><a href='profile.php?handle=" . htmlspecialchars($post['handle']) . "'>" . htmlspecialchars($post['handle']) . "</a></h3>"; //if the handle isn't the user's account, link them to the account that the handle belongs to
            }
            
            echo "<p>" . htmlspecialchars($post['content']) . "</p>"; // display the post content 
                echo "<section class='postBtns'>"; 
                    echo "<form method='post' class='likeForm'>";
                        echo "<input type='hidden' name='form_type' value='like_post'>";
                        echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($post['postid']) . "'>";
                        if (isset($_SESSION['handle'])) { // if the person is logged in display their handle
                            $handle = $_SESSION['handle'];
                        }
                        else {
                            $handle = null; // else there is no handle
                        }
                        $postId = $post['postid']; 
                        $playedata = $crud->checkLike($handle, $postId);
                        if ($playedata) {
                            if ($playedata['played'] == 1) { // if the plays button is clicked, display the clicked version of the icon
                                echo "<button type='submit' class='playsClicked'></button>";
                            } else {
                                echo "<button type='submit' class='plays'></button>";
                            }
                        }
                        else {
                            echo "<button type='submit' class='plays'></button>";
                        }
                        echo "<p class='small'>" . htmlspecialchars($post['plays']) . "</p>";
                    echo "</form>";

                    echo "<form method='post' class='replayForm'>";
                        echo "<input type='hidden' name='form_type' value='replay_post'>";
                        echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($post['postid']) . "'>";
                        if (isset($_SESSION['handle'])) {
                            $handle = $_SESSION['handle'];
                        }
                        else {
                            $handle = null;
                        }
                        $postId = $post['postid'];
                        $replayData = $crud->checkReplay($handle, $postId);
                        if ($replayData) { // if the replays button is clicked, display the clicked version of the icon
                            if ($replayData['replayed'] == 1) {
                                echo "<button class='replaysClicked'></button>";
                            } else {
                                echo "<button class='replays'></button>";
                            }
                        }
                        else {
                            echo "<button type='submit' class='replays'></button>";
                        }
                        echo "<p class='small'>" . htmlspecialchars($post['replays']) . "</p>";
                    echo "</form>";
                    
                    echo "<form method='post' class='recordForm'>";
                        echo "<input type='hidden' name='form_type' value='record_post'>";
                        echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($post['postid']) . "'>";
                        if (isset($_SESSION['handle'])) {
                            $handle = $_SESSION['handle'];
                        }
                        else {
                            $handle = null;
                        }
                        $postId = $post['postid'];
                        $recordData = $crud->checkRecord($handle, $postId);
                        if ($recordData) {
                            if ($recordData['recorded'] == 1) { // if the records button is clicked, display the clicked version of the icon
                                echo "<button class='recordsClicked'></button>";
                            } else {
                                echo "<button class='records'></button>";
                            }
                        }
                        else {
                            echo "<button type='submit' class='records'></button>";
                        }
                        echo "<p class='small'>" . htmlspecialchars($post['records']) . "</p>";
                    echo "</form>";
                    
                    if (isset($_SESSION['handle']) && ($post['handle'] == $_SESSION['handle'])) { // if the user has an account and is logged in 
                        echo "<section>"; //display the edit and delete buttons for their posts
                        echo "<button class='editBtn' data-content='" . htmlspecialchars($post['content']) . "' data-eraTag='" . htmlspecialchars($post['eraTag']) . "' data-handle='" . htmlspecialchars($post['handle']) . "' data-id='" . htmlspecialchars($post['postid']) . "'></button>"; 
                        echo "<button class='delBtn' data-content='" . htmlspecialchars($post['content']) . "' data-eraTag='" . htmlspecialchars($post['eraTag']) . "' data-handle='" . htmlspecialchars($post['handle']) . "' data-id='" . htmlspecialchars($post['postid']) . "'></button>";
                        echo "</section>";
                    }
                echo "</section>";
            echo "</div>";
        }
    ?>
</div>
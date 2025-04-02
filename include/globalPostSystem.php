<?php
            if (isset($_SESSION['handle'])) {
                $handle = $_SESSION['handle']; // Get the user's handle from the session
            }
            else {
                $handle = null;
            }
            // Check if the form is submitted and the form type is 'add_post'
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'add_post') {
                // Escape and sanitize inputs to prevent SQL injection
                $content = $crud->escape_string($_POST['content']);
                $eraTag = $crud->escape_string($_POST['eraTag']); 
                
                $msg = $valid->checkEmpty($_POST, array('content', 'eraTag')); // Validate required fields are not empty
                if ($msg != null) {
                    $page_message = "These elements are empty : $msg";
                }
                else {
                    $res = $crud->execute("INSERT INTO revoposts (content, eraTag, handle) VALUES ('$content', '$eraTag', '$handle')");
                }
            }
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'edit_post') {
                // Escape and sanitize inputs to prevent SQL injection
                $content = $crud->escape_string($_POST['content']);
                $eraTag = $crud->escape_string($_POST['eraTag']);
                $postId = $crud->escape_string($_POST['post_id']);

                $msg = $valid->checkEmpty($_POST, array('content', 'eraTag')); // Validate required fields are not empty
                if ($msg != null) {
                    $page_message = "These elements are empty : $msg";
                }
                else {
                    $res = $crud->execute("UPDATE revoposts SET content='$content', eraTag='$eraTag' WHERE postid='$postId' AND handle='$handle'");
                }
            }
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'del_post') {
                // Escape and sanitize input to prevent SQL injection
                $postId = $crud->escape_string($_POST['post_id']);

                $res = $crud->execute("DELETE FROM revoactions WHERE postid='$postId' AND handle='$handle'");
                $res = $crud->execute("DELETE FROM revoposts WHERE postid='$postId' AND handle='$handle'");
            }

            if (isset($_POST['form_type']) && $_POST['form_type'] == 'like_post') {
                // Escape and sanitize input to prevent SQL injection
                $postId = $crud->escape_string($_POST['post_id']);

                if ($handle != null) {
                    // Check if the user has already liked the post
                    $likeData = $crud->checkLike($handle, $postId);
                    if ($likeData) {
                        if ($likeData['played'] == 1) {
                            // User has already liked the post, remove like
                            $res = $crud->execute("UPDATE revoposts SET plays = plays - 1 WHERE postid='$postId'");
                            $res = $crud->execute("UPDATE revoactions SET played = 0 WHERE handle='$handle' AND postid='$postId'");
                        } else {
                            // User has not liked the post, update plays
                            $res = $crud->execute("UPDATE revoposts SET plays = plays + 1 WHERE postid='$postId'");
                            $res = $crud->execute("UPDATE revoactions SET played = 1 WHERE handle='$handle' AND postid='$postId'");
                        }
                    } else {
                        // No record in revoactions, insert new like
                        $res = $crud->execute("UPDATE revoposts SET plays = plays + 1 WHERE postid='$postId'");
                        $res = $crud->execute("INSERT INTO revoactions (handle, postid, played) VALUES ('$handle', '$postId', 1)");
                    }
                }
                else
                {
                    header('Location: index.php');
                }
            }
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'replay_post') {
                // Escape and sanitize input to prevent SQL injection
                $postId = $crud->escape_string($_POST['post_id']);
                
                if ($handle != null) {
                    // Check if the user has already replayed the post
                    $replayData = $crud->checkReplay($handle, $postId);
                    if ($replayData) {
                        if ($replayData['replayed'] == 1) {
                            // User has already liked the post, remove replay
                            $res = $crud->execute("UPDATE revoposts SET replays = replays - 1 WHERE postid='$postId'");
                            $res = $crud->execute("UPDATE revoactions SET replayed = 0 WHERE handle='$handle' AND postid='$postId'");
                        } else {
                            // User has not replayed the post, update replays
                            $res = $crud->execute("UPDATE revoposts SET replays = replays + 1 WHERE postid='$postId'");
                            $res = $crud->execute("UPDATE revoactions SET replayed = 1 WHERE handle='$handle' AND postid='$postId'");
                        }
                    } else {
                        // No record in revoactions, insert new replay
                        $res = $crud->execute("UPDATE revoposts SET replays = replays + 1 WHERE postid='$postId'");
                        $res = $crud->execute("INSERT INTO revoactions (handle, postid, replayed) VALUES ('$handle', '$postId', 1)");
                    }
                }
                else
                {
                    header('Location: index.php');
                }
            }
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'record_post') {
                // Escape and sanitize input to prevent SQL injection
                $postId = $crud->escape_string($_POST['post_id']);

                if ($handle != null) {
                    // Check if the user has already recorded the post
                    $recordData = $crud->checkRecord($handle, $postId);
                    if ($recordData) {
                        if ($recordData['recorded'] == 1) {
                            // User has already liked the post, remove record
                            $res = $crud->execute("UPDATE revoposts SET records = records - 1 WHERE postid='$postId'");
                            $res = $crud->execute("UPDATE revoactions SET recorded = 0 WHERE handle='$handle' AND postid='$postId'");
                        } else {
                            // User has not recorded the post, update records
                            $res = $crud->execute("UPDATE revoposts SET records = records + 1 WHERE postid='$postId'");
                            $res = $crud->execute("UPDATE revoactions SET recorded = 1 WHERE handle='$handle' AND postid='$postId'");
                        }
                    } else {
                        // No record in revoactions, insert new record
                        $res = $crud->execute("UPDATE revoposts SET records = records + 1 WHERE postid='$postId'");
                        $res = $crud->execute("INSERT INTO revoactions (handle, postid, recorded) VALUES ('$handle', '$postId', 1)");
                    }
                }
                else
                {
                    header('Location: index.php');
                }
            }

            if ($handle != null) {
                echo '<button id="displayBtn"></button>';
            }
        ?>

        <!-- Section for post display -->
        <section class="postDisplay">
            <form method="post">
                <!-- Hidden input to specify the form type as 'add_post' -->
                <input type="hidden" name="form_type" value="add_post">
                <div>
                    <!-- Text area for user to input post content -->
                    <textarea name="content" id="postContent" cols="30" rows="10" placeholder="Remember when..." required></textarea>
                </div>
                <div>
                    <!-- Label for the Era Tag dropdown -->
                    <label for="eraTag">Era Tag</label>
                    <div>
                        <!-- Dropdown menu to select an Era Tag -->
                        <select name="eraTag" id="eraTag">
                            <option value="80">80s</option>
                            <option value="90">90s</option>
                            <option value="2000">00s</option>
                            <option value="10">10s</option>
                            <option value="20">20s</option>
                        </select>
                    </div>
                </div>
                <button type="submit">Post</button>
            </form>
            <button id="closeBtn"></button>
        </section>

        <!-- Section for edit display -->
        <section class="editDisplay">
            <form method="post">
                <!-- Hidden input to specify the form type as 'add_post' and to have current post id stored -->
                <input type="hidden" name="form_type" value="edit_post">
                <input type="hidden" name="post_id" id="post_id_Edit">
                <div>
                    <!-- Text area for user to edit post content -->
                    <textarea name="content" id="editContent" cols="30" rows="10"></textarea>
                </div>
                <div >
                    <!-- Hidden dropdown menu to select an Era Tag -->
                    <select class="hidden" name="eraTag">
                        <option value="80">80s</option>
                        <option value="90">90s</option>
                        <option value="2000">00s</option>
                        <option value="10">10s</option>
                        <option value="20">20s</option>
                    </select>
                </div>
                <button type="submit">Post</button>
            </form>
            <button id="closeBtn2"></button>
        </section>

        <!-- Section for delete display -->
        <section class="delDisplay">
            <form method="post">
                <div>
                    <!-- Label to prompt the user with a confirmation message -->
                    <label>Are you sure you want to delete this post?</label>
                    <!-- Hidden input to specify the form type as 'del_post' -->
                    <input type="hidden" name="form_type" value="del_post">
                    <!-- Hidden input to store the ID of the post being deleted -->
                    <input type="hidden" name="post_id" id="post_id">
                </div>

                <div>
                    <button type="submit">Yes</button>
                    <button type="button" id="closeBtn3">No</button>
                </div>
            </form>
        </section>
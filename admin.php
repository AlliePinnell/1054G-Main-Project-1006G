<?php
    session_start(); // Start a new or resume an existing session
    $pageTitle = 'Admin'; // Set the title of the page
    $pageDesc = 'The Admin Area of REVO'; // Set a description for the page
    $isIndex = false; // Flag indicating whether this is the index page
    include './include/globalHeader.php'; // Include the global header bar from the specified file path

    // Check if the user is logged in by verifying the session 'handle'
    // If not set or empty, redirect to 'index.php' and terminate script execution
    if (!isset($_SESSION['handle']) || $_SESSION['handle'] == '') {
        Header('location:index.php');
        exit();
    }

    // Determine the selected database table based on the 'table' query parameter in the url
    // Default to 'revoaccounts' if the parameter is not provided / first loaded
    $selectedTable = isset($_GET['table']) ? $_GET['table'] : 'revoaccounts';

    // Check if the form submission is intended for editing an admin account
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'edit_accountAdmin') {
        // Escape user input to prevent SQL injection
        $accountid = $crud->escape_string($_POST['accountid']);
        $fname = $crud->escape_string($_POST['fname']);
        $lname = $crud->escape_string($_POST['lname']);
        $email = $crud->escape_string($_POST['email']);
        $monthEntry = $crud->escape_string($_POST['monthEntry']);
        $dayEntry = $crud->escape_string($_POST['dayEntry']);
        $yearEntry = $crud->escape_string($_POST['yearEntry']);
    
        $msg = $valid->checkEmpty($_POST, array('fname', 'lname', 'email', 'monthEntry', 'dayEntry', 'yearEntry')); // Check for empty fields
        $checkFName = $valid->validName($fname); // Validate first name
        $checkLName = $valid->validName($lname); // Validate last name
        $checkEmail = $valid->validEmail($email); // Validate email format

        if ($msg != null) {
            $page_message = "These elements are empty : $msg";
        }
        elseif ($checkFName == false) {
            $page_message = "<p>Please provide a valid first name</p>";   
        }
        elseif ($checkLName == false) {
            $page_message = "<p>Please provide a valid last name</p>";   
        }
        elseif ($checkEmail == false) {
            $page_message = "<p>Please provide a valid email</p>";   
        }
        else {
            // Call the 'editAccount' to update account details
            $success = $crud->editAccount($accountid, $fname, $lname, $email, $monthEntry, $dayEntry, $yearEntry);
            $page_message = "Account updated successfully!";
        }
    }

    if (isset($_POST['form_type']) && $_POST['form_type'] == 'edit_postAdmin') {
        // Escape user input to prevent SQL injection
        $postid = $crud->escape_string($_POST['postid']);
        $content = $crud->escape_string($_POST['content']);
        $plays = $crud->escape_string($_POST['plays']);
        $replays = $crud->escape_string($_POST['replays']);
        $records = $crud->escape_string($_POST['records']);
        $eraTag = $crud->escape_string($_POST['eraTag']);;
    
        $msg = $valid->checkEmpty($_POST, array('content', 'plays', 'replays', 'records', 'eraTag')); // Validate required fields are not empty
        if ($msg != null) {
            $page_message = "These elements are empty : $msg";
        }
        else {
            // Call the 'editPost' to update post details
            $success = $crud->editPost($postid, $content, $plays, $replays, $records, $eraTag);
            $page_message = "Post updated successfully!";
        }
    }

    if (isset($_POST['form_type']) && $_POST['form_type'] == 'edit_actionAdmin') {
        // Escape user input to prevent SQL injection
        $actionid = $crud->escape_string($_POST['actionid']);
        $postid = $crud->escape_string($_POST['postid']);

        if (isset($_POST['played'])) {
            $played = 1; // Checkbox is checked
        } else {
            $played = 0; // Checkbox is unchecked
        }
        
        if (isset($_POST['replayed'])) {
            $replayed = 1; // Checkbox is checked
        } else {
            $replayed = 0; // Checkbox is unchecked
        }
        
        if (isset($_POST['recorded'])) {
            $recorded = 1; // Checkbox is checked
        } else {
            $recorded = 0; // Checkbox is unchecked
        }
        
        
        // Call the 'editAction' to update action details
        $success = $crud->editAction($actionid, $postid, $played, $replayed, $recorded);
    
        // Provide user feedback based on whether the action update was successful
        if ($success) {
            $page_message = "Action updated successfully!";
        } else {
            $page_message = "Failed to update the action.";
        }
    }

    if (isset($_POST['form_type']) && $_POST['form_type'] == 'del_accountAdmin') {
        // Escape user input to prevent SQL injection
        $handle = $crud->escape_string($_POST['handle']);

        // Delete all associated entries with this account (including posts and actions)
        // order needs to be actions > posts > accounts to prevent foreign key errors
        $res = $crud->execute("DELETE FROM revoactions WHERE handle='$handle'");
        $res = $crud->execute("DELETE FROM revoposts WHERE handle='$handle'");
        $res = $crud->execute("DELETE FROM revoaccounts WHERE handle='$handle'");

        // If the currently signed in user's account is deleted, go back to the log in page
        if ($handle == $_SESSION['handle']) {
            header('Location: index.php');
        }

        // Provide user feedback based on whether the account deletion was successful
        if ($res) {
            $page_message = "Account deleted successfully!";
        } else {
            $page_message = "Failed to delete the account.";
        }
    }
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'del_postAdmin') {
        // Escape user input to prevent SQL injection
        $handle = $crud->escape_string($_POST['handle']);
        $postid = $crud->escape_string($_POST['postid']);

        // Delete all associated entries with this post (including post actions)
        $res = $crud->execute("DELETE FROM revoactions WHERE postid='$postid'");
        $res = $crud->execute("DELETE FROM revoposts WHERE postid='$postid'");

        // Provide user feedback based on whether the post deletion was successful
        if ($res) {
            $page_message = "Post deleted successfully!";
        } else {
            $page_message = "Failed to delete the post.";
        }
    }
    
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'del_actionAdmin') {
        // Escape user input to prevent SQL injection
        $actionid = $crud->escape_string($_POST['actionid']);
        $postid = $crud->escape_string($_POST['postid']);

        // Set played, replayed and recorded values for this specific action to 0
        $played = 0;
        $replayed = 0;
        $recorded = 0;
        
        // Call the `editAccount` method
        $success = $crud->editAction($actionid, $postid, $played, $replayed, $recorded);
    
        // Delete associated entry with this action's action id
        $res = $crud->execute("DELETE FROM revoactions WHERE actionid='$actionid'");

        // Provide user feedback based on whether the action deletion was successful
        if ($res) {
            $page_message = "Action deleted successfully!";
        } else {
            $page_message = "Failed to delete the action.";
        }
    }
    //refresh and reset to show updated info, and grab accounts
    $crud = new crud();
    $accounts = $crud->getAllInfo($selectedTable);
?>      
        <header>
            <section class="adminHeader">
                <h1>Admin</h1>
                <div class="dropdown">
                    <?php
                        // Dynamically generate a button with the current selected table's name
                        echo '<button class="dropbtn">' . htmlspecialchars($selectedTable) . '</button>';
                    ?>
                    <div class="dropdown-content">
                        <!-- Links for navigating to different tables in the admin interface -->
                        <a href="admin.php?table=revoaccounts">revoaccounts</a>
                        <a href="admin.php?table=revoposts">revoposts</a>
                        <a href="admin.php?table=revoactions">revoactions</a>
                    </div>
                </div>
            </section>
        </header>
        <main>
        <section class="adminDelDisplay">
                <?php
                // Check if the selected table is 'revoaccounts'
                if ($selectedTable === 'revoaccounts')
                {
                ?>
                    <form class="adminAccount" method="post">
                        <h1>Delete Account</h1>
                        <!-- Hidden input to specify the form type as 'del_accountAdmin' -->
                        <input type="hidden" name="form_type" value="del_accountAdmin">
                        <!-- Hidden input for storing the handle -->
                        <input type="hidden" name="handle" id="handle">
                        <div>
                            <!-- Label for the confirmation message -->
                            <label>Are you sure you want to delete this account?</label>
                        </div>
                <?php
                }
                ?>

                <?php
                // Check if the selected table is 'revoposts'
                if ($selectedTable === 'revoposts')
                {
                ?>
                    <form class="adminAccount" method="post">
                        <h1>Delete Post</h1>
                        <!-- Hidden input to specify the form type as 'del_postAdmin' -->
                        <input type="hidden" name="form_type" value="del_postAdmin">
                        <!-- Hidden input for storing the post ID -->
                        <input type="hidden" name="postid" id="postidDel">
                        <!-- Hidden input for storing the handle -->
                        <input type="hidden" name="handle" id="handle">
                        <div>
                            <!-- Label for the confirmation message -->
                            <label>Are you sure you want to delete this post?</label>
                        </div>
                <?php
                }
                ?>

                <?php
                // Check if the selected table is 'revoactions'
                if ($selectedTable === 'revoactions')
                {
                ?>
                    <form class="adminAccount" method="post">
                        <h1>Delete Action</h1>
                        <!-- Hidden input to specify the form type as 'del_actionAdmin' -->
                        <input type="hidden" name="form_type" value="del_actionAdmin">
                        <!-- Hidden input for storing the action ID -->
                        <input type="hidden" name="actionid" id="actionidDel">
                        <!-- Hidden input for storing the post ID -->
                        <input type="text" name="postid" id="postid-Action">
                        <!-- Hidden inputs for storing the possible post actions-->
                        <input type="hidden" name="played" id="playedDel">
                        <input type="hidden" name="replayed" id="replayedDel">
                        <input type="hidden" name="recorded" id="recordedDel">
                        <div>
                            <!-- Label for the confirmation message -->
                            <label>Are you sure you want to delete this action?</label>
                        </div>
                <?php
                }
                ?>
                        <!-- Sumbit button and end of form to allow all forms to have one shared 'No' close button id -->
                        <div>
                            <button type="submit">Yes</button>
                            <button type="button" id="closeBtn4">No</button>
                        </div>
                    </form>
            </section>

            <section class="adminDisplay">
                <?php
                // Check if the selected table is 'revoaccounts'
                if ($selectedTable === 'revoaccounts')
                {
                ?>
                    <!-- Simple form that has text boxes for first name, last name, email as well as a drop down for birthday .... and a submit button -->
                    <form class="adminAccount" method="post">
                                <h1>Edit Account</h1>
                                <input type="hidden" name="form_type" value="edit_accountAdmin">
                                <input type="hidden" name="accountid" id="accountid">
                                <div>
                                    <label for="fname">First Name</label>
                                    <div>
                                        <input type="text" name="fname" id="fname">
                                    </div>
                                </div>
                                <div>
                                    <label for="lname">Last Name</label>
                                    <div>
                                        <input type="text" name="lname" id="lname">
                                    </div>
                                </div>
                                <div>
                                    <label for="email">Email</label>
                                    <div>
                                        <input type="email" name="email" id="email">
                                    </div>
                                </div>
                                <div>
                                    <label>Birthday</label>
                                    <div>
                                    <select name="monthEntry" id="monthEntry">
                                        <option value="Jan">January</option>
                                        <option value="Feb">February</option>
                                        <option value="Mar">March</option>
                                        <option value="Apr">April</option>
                                        <option value="May">May</option>
                                        <option value="Jun">June</option>
                                        <option value="Jul">July</option>
                                        <option value="Aug">August</option>
                                        <option value="Sep">September</option>
                                        <option value="Oct">October</option>
                                        <option value="Nov">November</option>
                                        <option value="Dec">December</option>
                                    </select>
                                    <select name="dayEntry" id="dayEntry">
                                        <option value="01">1</option>
                                        <option value="02">2</option>
                                        <option value="03">3</option>
                                        <option value="04">4</option>
                                        <option value="05">5</option>
                                        <option value="06">6</option>
                                        <option value="07">7</option>
                                        <option value="08">8</option>
                                        <option value="09">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                    <select name="yearEntry" id="yearEntry">
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2004">2004</option>
                                        <option value="2003">2003</option>
                                        <option value="2002">2002</option>
                                        <option value="2001">2001</option>
                                        <option value="2000">2000</option>
                                        <option value="1999">1999</option>
                                        <option value="1998">1998</option>
                                        <option value="1997">1997</option>
                                        <option value="1996">1996</option>
                                        <option value="1995">1995</option>
                                        <option value="1994">1994</option>
                                        <option value="1993">1993</option>
                                        <option value="1992">1992</option>
                                        <option value="1991">1991</option>
                                        <option value="1990">1990</option>
                                    </select>
                                    </div>
                                </div>
                                <div>
                                    <input type="submit" >
                                </div>
                            </form>
                <?php
                }
                ?>

                <?php
                // Check if the selected table is 'revoposts'
                if ($selectedTable === 'revoposts')
                {
                ?>
                    <!-- Simple form that has a text box to edit the post and interactions on said post, as well as drop down to change post era...and a submit button -->
                    <form class="adminAccount" method="post">
                        <h1>Edit Post</h1>
                        <input type="hidden" name="form_type" value="edit_postAdmin">
                        <input type="hidden" name="postid" id="postid-post">
                        <div>
                            <label for="postContent">Content</label>
                            <div>
                                <textarea name="content" id="postContent" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div>
                            <label for="plays">Plays</label>
                            <div>
                                <input type="text" name="plays" id="plays">
                            </div>
                        </div>
                        <div>
                            <label for="replays">Replays</label>
                            <div>
                                <input type="text" name="replays" id="replays">
                            </div>
                        </div>
                        <div>
                            <label for="records">Records</label>
                            <div>
                                <input type="text" name="records" id="records">
                            </div>
                        </div>
                        <div>
                            <label for="eraTag">Era Tag</label>
                            <div>
                                <select name="eraTag" id="eraTag">
                                    <option value="80">80s</option>
                                    <option value="90">90s</option>
                                    <option value="2000">00s</option>
                                    <option value="10">10s</option>
                                    <option value="20">20s</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <input type="submit" >
                        </div>
                    </form>
                <?php
                }
                ?>

                <?php
                // Check if the selected table is 'revoactions'
                if ($selectedTable === 'revoactions')
                {
                ?>
                    <!-- Simple form that has checkboxes for the possible post actions and a submit button -->
                    <form class="adminAccount" method="post">
                        <h1>Edit Action</h1>
                        <input type="hidden" name="form_type" value="edit_actionAdmin">
                        <input type="hidden" name="actionid" id="actionidEdit">
                        <input type="hidden" name="postid" id="postid-action">
                        <div>
                            <label for="played">Played</label>
                            <div>
                                <input type="checkbox" name="played" id="played">
                            </div>
                        </div>
                        <div>
                            <label for="replayed">Replayed</label>
                            <div>
                                <input type="checkbox" name="replayed" id="replayed">
                            </div>
                        </div>
                        <div>
                            <label for="recorded">Recorded</label>
                            <div>
                                <input type="checkbox" name="recorded" id="recorded">
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Submit">
                        </div>
                    </form>
                <?php
                }
                ?>
                <button id="closeBtnAdmin"></button>
            </section>
            <section class="admin">
                <table>
                    <thead>
                        <tr>
                            <?php
                            // Check if the selected table is 'revoaccounts'
                            if ($selectedTable === 'revoaccounts')
                            {
                                // Headers for the 'revoaccounts' table
                                echo '<th>Account ID</th>';
                                echo '<th>Handle</th>';
                                echo '<th>First Name</th>';
                                echo '<th>Last Name</th>';
                                echo '<th>Email</th>';
                                echo '<th>Birthday</th>';
                                echo '<th>Profile Img</th>';
                                echo '<th>Profile Name</th>';
                                echo '<th>Banner Img</th>';
                                echo '<th>Banner Name</th>';
                                echo '<th>Edit</th>';
                                echo '<th>Delete</th>';
                            }
                            // Check if the selected table is 'revoposts'
                            if ($selectedTable === 'revoposts')
                            {
                                // Headers for the 'revoposts' table
                                echo '<th>Post ID</th>';
                                echo '<th>Handle</th>';
                                echo '<th>Content</th>';
                                echo '<th>Plays</th>';
                                echo '<th>Replays</th>';
                                echo '<th>Records</th>';
                                echo '<th>Era Tag</th>';
                                echo '<th>Edit</th>';
                                echo '<th>Delete</th>';
                            }
                            // Check if the selected table is 'revoactions'
                            if ($selectedTable === 'revoactions')
                            {
                                // Headers for the 'revoactions' table
                                echo '<th> Action ID </th>';
                                echo '<th> Handle </th>';
                                echo '<th> Post ID </th>';
                                echo '<th> Played </th>';
                                echo '<th> Replayed </th>';
                                echo '<th> Recorded </th>';
                                echo '<th>Edit</th>';
                                echo '<th>Delete</th>';
                            }
                        ?>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        // Check if the selected table is 'revoaccounts'
                        if ($selectedTable === 'revoaccounts')
                        {
                            // Populate rows for the 'revoaccounts' table
                            foreach ($accounts as $account) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($account['accountid']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['handle']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['fname']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['lname']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['email']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['monthEntry']) . '/' . htmlspecialchars($account['dayEntry']) . '/' . htmlspecialchars($account['yearEntry']) . '</td>';
                                echo '<td><img src="' . htmlspecialchars($account['profileImage']) . '" alt="Profile Image" width="50"></td>';
                                echo '<td>' . htmlspecialchars($account['profileName']) . '</td>';
                                echo '<td><img src="' . htmlspecialchars($account['bannerImage']) . '" alt="Banner Image" width="50"></td>';
                                echo '<td>' . htmlspecialchars($account['bannerName']) . '</td>';
                                // send variables to the javascript for the edit button
                                echo '<td>
                                    <button class="adminEditAcc" 
                                            data-accountid="' . htmlspecialchars($account['accountid']) . '" 
                                            data-handle="' . htmlspecialchars($account['handle']) . '" 
                                            data-fname="' . htmlspecialchars($account['fname']) . '" 
                                            data-lname="' . htmlspecialchars($account['lname']) . '" 
                                            data-email="' . htmlspecialchars($account['email']) . '" 
                                            data-monthEntry="' . htmlspecialchars($account['monthEntry']) . '" 
                                            data-dayEntry="' . htmlspecialchars($account['dayEntry']) . '" 
                                            data-yearEntry="' . htmlspecialchars($account['yearEntry']) . '">
                                        Edit
                                    </button>
                                </td>';     
                                // send the handle to the javascript for the delete button                   
                                echo '<td>
                                    <button class="adminDelAcc" 
                                            data-handle="' . htmlspecialchars($account['handle']) . '">
                                        Delete
                                    </button>
                                </td>';   
                                echo '</tr>';
                            }
                        }
                        // Check if the selected table is 'revoposts'
                        if ($selectedTable === 'revoposts')
                        {
                            // Populate rows for the 'revoposts' table
                            foreach ($accounts as $account) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($account['postid']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['handle']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['content']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['plays']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['replays']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['records']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['eraTag']) . '</td>';
                                // send variables to the javascript for the edit button
                                echo '<td>
                                    <button class="adminEditPst" 
                                            data-postid="' . htmlspecialchars($account['postid']) . '" 
                                            data-handle="' . htmlspecialchars($account['handle']) . '" 
                                            data-content="' . htmlspecialchars($account['content']) . '" 
                                            data-plays="' . htmlspecialchars($account['plays']) . '" 
                                            data-replays="' . htmlspecialchars($account['replays']) . '" 
                                            data-records="' . htmlspecialchars($account['records']) . '" 
                                            data-eraTag="' . htmlspecialchars($account['eraTag']) . '"> 
                                        Edit
                                    </button>
                                </td>'; 
                                // send the postid and the handle to the javascript for the delete button
                                echo '<td>
                                    <button class="adminDelPst" 
                                            data-postid="' . htmlspecialchars($account['postid']) . '" 
                                            data-handle="' . htmlspecialchars($account['handle']) . '">
                                        Delete
                                    </button>
                                </td>';   
                                echo '</tr>';
                            }
                        }
                        // Check if the selected table is 'revoactions'
                        if ($selectedTable === 'revoactions')
                        {
                            // Populate rows for the 'revoactions' table
                            foreach ($accounts as $account) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($account['actionid']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['handle']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['postid']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['played']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['replayed']) . '</td>';
                                echo '<td>' . htmlspecialchars($account['recorded']) . '</td>';
                                // send variables to the javascript for the edit button
                                echo '<td>
                                    <button class="adminEditActn" 
                                            data-actionid="' . htmlspecialchars($account['actionid']) . '" 
                                            data-handle="' . htmlspecialchars($account['handle']) . '" 
                                            data-postid="' . htmlspecialchars($account['postid']) . '" 
                                            data-played="' . htmlspecialchars($account['played']) . '" 
                                            data-replayed="' . htmlspecialchars($account['replayed']) . '" 
                                            data-recorded="' . htmlspecialchars($account['recorded']) . '"> 
                                        Edit
                                    </button>
                                </td>'; 
                                // send variables to the javascript for the delete button
                                echo '<td>
                                    <button class="adminDelActn" 
                                            data-actionid="' . htmlspecialchars($account['actionid']) . '" 
                                            data-handle="' . htmlspecialchars($account['handle']) . '" 
                                            data-postid="' . htmlspecialchars($account['postid']) . '" 
                                            data-played="' . htmlspecialchars($account['played']) . '" 
                                            data-replayed="' . htmlspecialchars($account['replayed']) . '" 
                                            data-recorded="' . htmlspecialchars($account['recorded']) . '"> 
                                        Delete
                                    </button>
                                </td>';   
                                echo '</tr>';
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </section>

            <!--  page message bar to give user feedback for actions done on this page -->
            <div id="message-bar" class="message-bar">
                <?php echo $page_message; ?>
            </div>
        </main>
<?php
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>
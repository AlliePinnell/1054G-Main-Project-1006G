<?php
  session_start(); // Start a new or resume an existing session
  $_SESSION['handle'] = ''; // Initialize the session variable 'handle' with an empty string
  $pageTitle = 'Register'; // Set the title of the page
  $pageDesc = 'The Register/Log In page on REVO'; // Set a description for the page
  $isIndex = true; // Flag indicating whether this is the index page (set to true since this is)
  include './include/globalHeader.php'; // Include the global header bar from the specified file path
?>
        <?php
            // Check if the 'form_type' POST variable is not set
            if (isset($_POST['form_type']) == false) {
                // Unset specific session variables for account and user details
                unset($_SESSION['account_added']);
                unset($_SESSION['fname']);
                unset($_SESSION['lname']);
            }

            // Handle form submission for adding a new account
            if (isset($_POST['form_type']) && $_POST['form_type'] == 'add_account') {
                // Escape and sanitize user inputs to prevent SQL injection
                $fname = $crud->escape_string($_POST['fname']);
                $lname = $crud->escape_string($_POST['lname']);
                $email = $crud->escape_string($_POST['email']);
                $psword = $crud->escape_string($_POST['psword']);
                $monthEntry = $crud->escape_string($_POST['monthEntry']);
                $dayEntry = $crud->escape_string($_POST['dayEntry']);
                $yearEntry = $crud->escape_string($_POST['yearEntry']);
                $handle = $crud->escape_string($_POST['handle']);

                // Validate the form inputs
                $msg = $valid->checkEmpty($_POST, array('fname', 'lname', 'email', 'psword', 'monthEntry', 'dayEntry', 'yearEntry', 'handle')); // Check for empty fields
                $checkFName = $valid->validName($fname); // Validate first name
                $checkLName = $valid->validName($lname); // Validate last name
                $checkEmail = $valid->validEmail($email); // Validate email format
                $checkPassword = $valid->validPassword($psword); // Validate password based on specific conditions
                $checkHandle = $valid->validHandle($handle); // Validate handle format
                $existEmail = $crud->isDuplicate('email', $email); // Check if email already exists
                $existHandle = $crud->isDuplicate('handle', $handle); // Check if handle already exists

                // Hash the password
                $psword = hash('sha512', $psword);

                // Check validation results and set appropriate error messages
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
                elseif ($checkHandle == false) {
                    $page_message = "<p>Handle does not start with an @</p>";  
                }
                elseif ($checkPassword != '') {
                    $page_message = $checkPassword;
                }
                elseif ($existEmail != '') {
                    $page_message = "Email already exists. Please choose a different email.";
                }
                elseif ($existHandle != '') {
                    $page_message = "Handle already exists. Please choose a different handle."; 
                }
                else {
                    // Insert new user details into the database
                    $res = $crud->execute("INSERT INTO revoaccounts (fname, lname, email, psword, monthEntry, dayEntry, yearEntry, handle) VALUES ('$fname', '$lname', '$email', '$psword', '$monthEntry', '$dayEntry', '$yearEntry', '$handle')");
                    if ($res) {
                        // Set the session variable for the handle and redirect to the home page
                        $_SESSION['handle'] = $handle;
                        header("Location: home.php");
                        exit(); // Stop script execution after redirection
                    }
                    else {
                        $page_message = "Could not add user";
                        
                    }
                }
            }

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
        ?>
        <!-- Site header with the main title and cta -->
        <header>
            <h1>Blast from the Past</h1>
            <h2>Join Today</h2>
        </header>
        <!-- Main container containing all account forms-->
        <main>
            <div class="container">
                <img src="./img/verticalLogo.png" alt="Revo Logo" class="logo">
                
                <!-- Section for adding a new account -->
                <section id="addAccount">
                    <form class="addAccount" method="post">
                        <!-- Form title -->
                        <h1>Add Account</h1>

                        <!-- Hidden input specifying the form type -->
                        <input type="hidden" name="form_type" value="add_account">
                        
                        <!-- First Name input -->
                        <div>
                            <label for="fname">First Name</label>
                            <div>
                                <input type="text" name="fname" id="fname">
                            </div>
                        </div>

                        <!-- Last Name input -->
                        <div>
                            <label for="lname">Last Name</label>
                            <div>
                                <input type="text" name="lname" id="lname">
                            </div>
                        </div>

                        <!-- Email input -->
                        <div>
                            <label for="email">Email</label>
                            <div>
                                <input type="email" name="email" id="email">
                            </div>
                        </div>

                        <!-- Password input -->
                        <div>
                            <label for="psword">Password</label>
                            <label title="Password must include at least one number, one uppercase letter and one lowercase letter">ℹ️</label>
                            <div>
                                <input type="password" name="psword" id="psword">
                            </div>
                        </div>

                        <!-- Birthday selection -->
                        <div>
                            <label>Birthday</label>
                            <div>
                            <!-- Dropdown for selecting the month -->
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

                            <!-- Dropdown for selecting the day -->
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

                            <!-- Dropdown for selecting the year -->
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

                        <!-- Handle input -->
                        <div>
                            <label for="handle">Handle</label>
                            <div>
                                <input type="text" name="handle" id="handle" placeholder="@Example123">
                            </div>
                        </div>

                        <!-- Submit button for adding account -->
                        <div>
                            <input type="submit" value="Submit">
                        </div>
                    </form>

                    <form class="loginAccount" method="post">
                        <!-- Section for logging in -->
                        <h1>or Log In</h1>

                        <!-- Hidden input specifying the form type -->
                        <input type="hidden" name="form_type" value="login_account">

                        <!-- Handle input for login -->
                        <div>
                            <label for="loginHandle">Handle</label>
                                <div>
                                    <input type="text" name="handle" id="loginHandle" placeholder="@Example123">
                                </div>
                            </div>

                        <!-- Password input for login -->
                        <div>
                            <label for="loginPsword">Password</label>
                            <div>
                                <input type="password" name="psword" id="loginPsword">
                            </div>
                        </div>

                        <!-- Submit button for logging in -->
                        <div>
                            <input type="submit" value="Log In">
                        </div>
                    </form>
                </section>
            </div>

            <!-- Error bar to display messages dynamically -->
            <div id="message-bar" class="message-bar">
                <?php echo $page_message; ?>
            </div>
        </main>
<?php
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>
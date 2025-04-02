// Select elements from the DOM
var postDisplay = document.querySelector(".postDisplay");
var editDisplay = document.querySelector(".editDisplay");
var delDisplay = document.querySelector(".delDisplay");
var adminDisplay = document.querySelector(".adminDisplay");
var adminDelDisplay = document.querySelector(".adminDelDisplay");
var navDisplay = document.querySelector(".navDisplay");
var displayBtn = document.getElementById("displayBtn");
var delBtn = document.getElementById("delBtn");
var closeBtn = document.getElementById("closeBtn"); //close button for postDisplay
var closeBtn2 = document.getElementById("closeBtn2"); //close button for editDisplay
var closeBtn3 = document.getElementById("closeBtn3"); //close button for delDisplay
var closeBtn4 = document.getElementById("closeBtn4"); //close button for any deletion on the admin.php
var closeBtnAdmin = document.getElementById("closeBtnAdmin");
var mobileMenu = document.getElementById("mobileMenu");
var loginBtn = document.getElementById("loginBtn");
var loginDisplay = document.querySelector(".loginDisplay");
var closeBtnLogin = document.getElementById("closeBtnLogin"); //close button for loginDisplay
var profileBtn = document.getElementById("profileBtn");

// Function to display the post creation section
function makeAPost() {
	postDisplay.style.display = "block";
	displayBtn.style.display = "none";
}

// Function to edit a post, populating form fields with existing data
function editAPost(content, eraTag, handle, postId) {
	editDisplay.style.display = "block";
	document.querySelector('.editDisplay input[name="post_id"]').value = postId;
	document.querySelector('.editDisplay textarea[name="content"]').value = content;
	document.querySelector('.editDisplay select[name="eraTag"]').value = eraTag;
}

// Function to edit user account details
function editAccount(accountid, fname, lname, email, monthEntry, dayEntry, yearEntry) {
	adminDisplay.style.display = "block";
	document.querySelector('.adminDisplay input[name="accountid"]').value = accountid;
	document.querySelector('.adminDisplay input[name="fname"]').value = fname;
	document.querySelector('.adminDisplay input[name="lname"]').value = lname;
	document.querySelector('.adminDisplay input[name="email"]').value = email;
	document.querySelector('.adminDisplay select[name="monthEntry"]').value = monthEntry;
	document.querySelector('.adminDisplay select[name="dayEntry"]').value = dayEntry;
	document.querySelector('.adminDisplay select[name="yearEntry"]').value = yearEntry;
}

// Function to confirm account deletion
function delAccount(handle) {
	adminDelDisplay.style.display = "block";
	document.querySelector('.adminDelDisplay input[name="handle"]').value = handle;
}

// Function to edit a post from the admin panel
function editPost(postid, content, plays, replays, records, eraTag) {
    adminDisplay.style.display = "block";
    document.querySelector('.adminDisplay input[name="postid"]').value = postid;
    document.querySelector('.adminDisplay textarea[name="content"]').value = content;
    document.querySelector('.adminDisplay input[name="plays"]').value = plays;
    document.querySelector('.adminDisplay input[name="replays"]').value = replays;
    document.querySelector('.adminDisplay input[name="records"]').value = records;
    document.querySelector('.adminDisplay select[name="eraTag"]').value = eraTag;
}

// Function to confirm post deletion
function delPost(postid, handle) {
	adminDelDisplay.style.display = "block";
	document.querySelector('.adminDelDisplay input[name="postid"]').value = postid;
	document.querySelector('.adminDelDisplay input[name="handle"]').value = handle;
}

// Function to edit an action
function editAction(actionid, postid, played, replayed, recorded) {
    adminDisplay.style.display = "block";
    document.querySelector('.adminDisplay input[name="actionid"]').value = actionid;
	document.querySelector('.adminDisplay input[name="postid"]').value = postid;
	document.querySelector('.adminDisplay input[name="played"]').checked = played == 1;
	document.querySelector('.adminDisplay input[name="replayed"]').checked = replayed == 1;
	document.querySelector('.adminDisplay input[name="recorded"]').checked = recorded == 1;
}

// Function to confirm action deletion
function delAction(actionid, postid, played, replayed, recorded) {
	adminDelDisplay.style.display = "block";
    document.querySelector('.adminDelDisplay input[name="actionid"]').value = actionid;
	document.querySelector('.adminDelDisplay input[name="postid"]').value = postid;
	document.querySelector('.adminDelDisplay input[name="played"]').checked = played == 1;
	document.querySelector('.adminDelDisplay input[name="replayed"]').checked = replayed == 1;
	document.querySelector('.adminDelDisplay input[name="recorded"]').checked = recorded == 1;
}

// Function to close the post creation display
function exit() {
	postDisplay.style.display = "none";
	displayBtn.style.display = "block";
}

// Function to close the edit post display
function exit2() {
	editDisplay.style.display = "none";
	displayBtn.style.display = "block";
}

// Function to close the delete post confirmation display
function exit3() {
	delDisplay.style.display = "none";
	displayBtn.style.display = "block";
}

// Function to close the admin delete account display
function exit4() {
	adminDelDisplay.style.display = "none";
}

// Function to close the admin edit account/post/action display
function exit5() {
	adminDisplay.style.display = "none";
}

function exit6() {
	loginDisplay.style.display = "none";
}

// Function to toggle mobile navigation menu
function mobileNav() {
	if (window.innerWidth > 1268) {
	  // For larger screens, always set the display to "flex"
	  navDisplay.style.display = "flex";
	} 
	else {
	  // For mobile screens, toggle between "none" and "flex" based on current state
		if (navDisplay.style.display === "flex") {
			navDisplay.style.display = "none";
		} else {
			navDisplay.style.display = "flex";
		}
	}
  }
  
// Function to ensure proper display on window resize ( for mobileNav() )
function handleResize() {
// Checks if the current window is mobile sized (like css check)
	if (window.innerWidth > 1268) {
		// Ensure the navigation display is "flex" on larger screens
		navDisplay.style.display = "flex";
	}
}

// Adding event listeners to all elements with the class 'editBtn'
document.querySelectorAll(".editBtn").forEach(function (button) {
	button.addEventListener("click", function () {
		// Retrieving custom attributes from the clicked button
		var content = this.getAttribute("data-content");
		var eraTag = this.getAttribute("data-eraTag");
		var handle = this.getAttribute("data-handle");
		var postId = this.getAttribute("data-id");
		// Calling a function to edit a post, passing the retrieved attributes as arguments
		editAPost(content, eraTag, handle, postId);
	});
});

// Adding event listeners to all elements with the class 'delBtn'
document.querySelectorAll(".delBtn").forEach(function (button) {
	button.addEventListener("click", function () {
        // Retrieving the 'data-id' attribute from the clicked button
        var postId = this.getAttribute("data-id");
        // Setting the value of an input element with ID 'post_id' inside '.delDisplay'
        document.querySelector(".delDisplay #post_id").value = postId;
        // Making the '.delDisplay' element visible
        document.querySelector(".delDisplay").style.display = "block";
	});
});

// Adding event listeners to all elements with the class 'adminEditAcc'
document.querySelectorAll(".adminEditAcc").forEach(function (button) {
	button.addEventListener("click", function () {
		// Retrieving various attributes from the clicked button
		var accountid = this.getAttribute("data-accountid");
		var fname = this.getAttribute("data-fname");
		var lname = this.getAttribute("data-lname");
		var email = this.getAttribute("data-email");
		var monthEntry = this.getAttribute("data-monthEntry");
		var dayEntry = this.getAttribute("data-dayEntry");
		var yearEntry = this.getAttribute("data-yearEntry");
		// Calling a function to edit an account, passing the retrieved attributes as arguments
		editAccount(accountid, fname, lname, email, monthEntry, dayEntry, yearEntry);
	});
});

// Adding event listeners to all elements with the class 'adminDelAcc'
document.querySelectorAll(".adminDelAcc").forEach(function (button) {
	button.addEventListener("click", function () {
        // Retrieving the 'data-handle' attribute from the clicked button
        var handle = this.getAttribute("data-handle");
        // Calling the function 'delAccount', passing the retrieved handle as an argument
        delAccount(handle);
	});
});

// Adding event listeners to all elements with the class 'adminEditPst'
document.querySelectorAll(".adminEditPst").forEach(function (button) {
	button.addEventListener("click", function () {
        // Retrieving attributes from the clicked button
        var postid = this.getAttribute("data-postid");
        var content = this.getAttribute("data-content");
        var plays = this.getAttribute("data-plays");
        var replays = this.getAttribute("data-replays");
        var records = this.getAttribute("data-records");
        var eraTag = this.getAttribute("data-eraTag");
        // Calling the function 'editPost', passing the retrieved attributes as arguments
        editPost(postid, content, plays, replays, records, eraTag);

	});
});

// Adding event listeners to all elements with the class 'adminDelPst'
document.querySelectorAll(".adminDelPst").forEach(function (button) {
    button.addEventListener("click", function () {
		var postid = this.getAttribute("data-postid");
        // Retrieving the 'data-handle' attribute from the clicked button
        var handle = this.getAttribute("data-handle");
        // Calling the function 'delPost', passing the retrieved handle as an argument
        delPost(postid, handle);
    });
});

// Adding event listeners to all elements with the class 'adminEditActn'
document.querySelectorAll(".adminEditActn").forEach(function (button) {
    button.addEventListener("click", function () {
        // Retrieving attributes related to actions from the clicked button
        var actionid = this.getAttribute("data-actionid");
        var postid = this.getAttribute("data-postid");
        var played = this.getAttribute("data-played");
        var replayed = this.getAttribute("data-replayed");
        var recorded = this.getAttribute("data-recorded");
        // Calling the function 'editAction', passing the retrieved attributes as arguments
        editAction(actionid, postid, played, replayed, recorded);
    });
});

// Adding event listeners to all elements with the class 'adminDelActn'
document.querySelectorAll(".adminDelActn").forEach(function (button) {
    button.addEventListener("click", function () {
        // Retrieving attributes related to actions from the clicked button
        var actionid = this.getAttribute("data-actionid");
        var postid = this.getAttribute("data-postid");
        var played = this.getAttribute("data-played");
        var replayed = this.getAttribute("data-replayed");
        var recorded = this.getAttribute("data-recorded");
        // Calling the function 'delAction', passing the retrieved attributes as arguments
        delAction(actionid, postid, played, replayed, recorded);
    });
});

function loginInHeader() {
	loginDisplay.style.display = "block";
	displayBtn.style.display = "none";
}

// Adding a global event listener for the 'resize' event on the window
window.addEventListener("resize", handleResize);

// Checking if 'mobileMenu' exists before adding a 'click' event listener
if (mobileMenu) {
    mobileMenu.addEventListener("click", mobileNav);
}

// Checking if 'displayBtn' exists before adding a 'click' event listener
if (displayBtn) {
    displayBtn.addEventListener("click", makeAPost);
}

// Adding 'click' event listeners to close' buttons if they exist
if (closeBtn) {
    closeBtn.addEventListener("click", exit);
}
if (closeBtn2) {
  closeBtn2.addEventListener("click", exit2);
}
if (closeBtn3) {
  closeBtn3.addEventListener("click", exit3);
}
if (closeBtn4) {
	closeBtn4.addEventListener("click", exit4);
}

// Adding 'click' event listeners for admin-related 'close' buttons if they exist
if (closeBtnAdmin) {
	closeBtnAdmin.addEventListener("click", exit5);
}

if (loginBtn) {
    loginBtn.addEventListener("click", loginInHeader);
}
if (closeBtnLogin) {
    closeBtnLogin.addEventListener("click", exit6);
}

if (profileBtn) {
	profileBtn.addEventListener("click", function() {
		window.location.href = "./myprofile.php";
	});
}
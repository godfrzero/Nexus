/* JavaScript Document */
/* Notification System Created by redAtom Studios @ 2012 */

/* Notifier Variables */
var alert_id = 0;
var notify_delay = 3000;
var notifyStack = [];
var liveNotifications = 0;
var maxParallelNotify = 2;
var emailRegex = /\S+@\S+\.\S+/;

var getElement = function(elementID) {
	return document.getElementById(elementID);
}

var checkEmail = function(email, errorStack) {
	if(!emailRegex.test(email)) {
		errorStack.push(['Please enter a valid email address.', 0]);
	}
}

// Notification functions
var openNotification = function() {
	if(notifyStack.length > 0 && liveNotifications <= maxParallelNotify) {
		var thisMessage = notifyStack.shift(); // Get the latest message
		var thisType = thisMessage.split('|')[1]; // Separate the message type and message
		thisMessage = thisMessage.split('|')[0];
		$('div#notifier').append('<div id="m'+alert_id+'" class="'+(thisType == '1' ? 'notification' : 'alert')+'">'+thisMessage+'</div>') // Create control string to output to JS
		var this_id = '#m' + alert_id++;
		$(this_id).animate({height: 2+'em'}, function(){
			liveNotifications++;
			if(liveNotifications < maxParallelNotify) { // Open notifications in parallel, until limit reached
				openNotification();
			}
			setTimeout(function(){
				$(this_id).queue('fx', []).animate({height: 0}, function(){
					$(this).hide().remove();
					if(liveNotifications == maxParallelNotify)
						openNotification(); // When last message is fired, check stack and repeat if there are more messages.
					liveNotifications--;
				});
			}, notify_delay);
		});
	}
}

var stackNotify = function(message, type) {
	notifyStack.push(message + '|' + type);
}

var Notify = function(messages) {
	$.each(messages, function(index, value){
		stackNotify(value[0], value[1]);
	});
	openNotification();
}

// Navigation functions
var toggleNav = function(){
	$('#navWrap > nav').queue('fx', []).slideToggle(100);
}

// Show and hide the loading notification GIF
var showLoader = function() {
	$('#loadIndicator').queue('fx', []).show().animate({opacity: 1});
}

var hideLoader = function() {
	$('#loadIndicator').queue('fx', []).animate({opacity: 0}, function(){ $(this).hide() });
}


// Form processing functions
// processJson populates page based on server response
function processJson(data) {
	switch(data.Status) {
		case 'Failure': 
		Notify([[data.Reason, 0]]);

		if(data.Redirect) {
			window.location = data.Redirect;
		}
		break;

		case 'Success': 
		if(data.Reason) {
			Notify([[data.Reason, 1]]);
		}

		if(data.Content) {
			$('#loginWrap').animate({marginTop: 0, width: 978+'px'}, function(){
				$(this).css({
					bottom: 'auto',
					position: 'static'
				})
			});

			$('#messageWrapper').html(data.Content).slideToggle().animate({opacity: 1}).append('<div class="clear"></div>');
			$('#actionWindow').animate({opacity: 0}, function(){
				$(this).empty();
				var navString = '<ul>' +
									        '<li>' +
									          '<div class="vCenter">' +
									            '<button id="postTrigger" value="Post Something">Post Something</button>' +
									            '<a href="people/"><button id="peopleTrigger" value="Find People">Find People</button></a>' +
									            '<a href="mine/"><button id="selfTrigger" value="Your Posts">Your Posts</button></a>' +
									            '<a href="logout.php"><button id="logout" value="Logout">Logout</button></a>' +
									          '</div>' +
									        '</li>' +
									      '</ul>';
				$(this).html(navString).css({width: 735+'px'}).animate({opacity: 1});

				// Initialize hinting again to process new form fields
				initializeHinting();

				// Show the new contents
				$('#actionWindow li').animate({opacity: 1});
			});
		}

		if(data.Redirect) {
			window.location = data.Redirect;
		}
		break;

		default: break;
	}
}

// Request function to send and receive form data asynchronously
function sendRequest(method, target, parameters) {
	var xmlhttp;
	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
	else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var response = xmlhttp.responseText.split('\\').join('');
				// console.log(xmlhttp.responseText, response);
				var jsonData = eval("(" + response + ")");
				processJson(jsonData);
				hideLoader();
			}
		}
	showLoader();
	xmlhttp.open(method, target, true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// console.log(parameters);
	xmlhttp.send(parameters);
}

// Form hinting initializer
// User the data-hint attribute
function initializeHinting() {
	$('input[type="text"], input[type="password"]').each(function(){
		if(this.attributes['data-hint']) {
			this.value = this.attributes['data-hint'].value;
			this.style.color = "rgba(0, 0, 0, 0.3)";
		}
	});
}

jQuery(document).ready(function($) {

	// Notification scriptlet?!?! Sets up the notifier on each page and handles notifications...like a boss. :D
	$('body').append('<div id="notifier"></div>').append('<img src="/resources/graphics/loading.gif" id="loadIndicator" />');

	/* Vertical Slider code, showing login and signup */
	$('#slideTrigger').show().css({opacity: 1});

	$('.slideTrigger').click(function() {
		var offsetIndex = this.id.split('_')[1];
		var slideParent = $(this).parents('ul')[0];
		var slideElement = $(this).parents('li')[0];
		var targetElement = $(slideParent).children()[offsetIndex];

		var slideOffset = $(slideElement).height() * offsetIndex;

		$(slideParent).children('li').queue('fx', []).animate({opacity: 0});
		$(slideParent).queue('fx', []).animate({top: -slideOffset+'px'});
		$(targetElement).queue('fx', []).show().animate({opacity: 1});
	});


	/* Input hinting snippet */
	initializeHinting();

	/* Live hinting for focus and blur */
	$('body').on('focus', 'input[type="text"], input[type="password"]', function(){
		if(this.attributes['data-hint']) {
			if(this.value == this.attributes['data-hint'].value) {
				this.value = "";
				this.style.color = "#000";
			}
		}
	}).on('blur', 'input[type="text"], input[type="password"]', function(){
		if(this.value == '') {
			if(this.attributes['data-hint']) {
				this.value = this.attributes['data-hint'].value;
				this.style.color = "rgba(0, 0, 0, 0.3)";
			}
		}
	});

	/* Signup and Signin Management */
	$('#loginForm').submit(function(e) {
		// Prevent form submission so we can validate
		e.preventDefault();

		// Get form elements
		var U_name = getElement('eMail');
		var P_word = getElement('pWord');
		var errorMessages = [];

		// Frontend validation for username
		checkEmail(U_name.value, errorMessages);

		// Frontend validation for password
		if(P_word.value.length < 8) {
			errorMessages.push(['Password is too short', 0]);
		}

		// If there are errors, display them
		// Otherwise, submit the form :D
		if(errorMessages.length) {
			Notify(errorMessages);
		} else {
			sendRequest('POST', '/controllers/gatekeeper.php', $('#loginForm').serialize());
		}
	});

	$('#signupForm').submit(function(e){
		// Prevent form submission so we can validate
		e.preventDefault();

		// Get form elements
		var U_name = getElement('signUpEmail');
		var errorMessages = [];

		// Frontend validation for username
		checkEmail(U_name.value, errorMessages);

		// If there are errors, display them
		// Otherwise, submit the form :D
		if(errorMessages.length) {
			Notify(errorMessages);
		} else {
			sendRequest('POST', '/controllers/gatekeeper.php', $('#signupForm').serialize());
		}
	});


	/* New post management */
	$('#messageWrapper').on('submit', 'form#newPost', function(e){
		// Prevent form submission, just for fun.
		e.preventDefault();

		// Well, we alread prevented submission
		// Let do some basic validation~

		var postTitle = getElement('postTitle');
		var postContent = getElement('postContent');
		var errorMessages = [];

		if(postTitle.value || postContent.value) {
			// A post only needs a title or content, not both
			sendRequest('POST', '/controllers/postman.php', $('#newPost').serialize());
			$('form#newPost').animate({opacity: 0, height: 0 + 'px'}, function(){ $(this).hide() });
			$('form#newPost input[type="text"], form#newPost textarea').each(function(){
				this.value = "";
			});
		} else {
			// Nothing filled in, what's the point of posting?
			// Let's tell them to fill in either content or the title.
			Notify([['Title or Content must be filled in!', 0]]);
		}
	});

	/* Profile management */
	$('#profileForm').submit(function(e){
		// Prevent form submission, just for fun.
		e.preventDefault();
		// console.log('Submission Prevented!');

		// Well, we alread prevented submission
		// Let do some basic validation~

		var password = getElement('password');
		var password2 = getElement('passwordConfirm');
		var name = getElement('Name');
		var errorMessages = [];

		if(password.value == password2.value && password.value.length >= 8 && /^[a-zA-Z ]*$/.test(name.value)) {
			// A post only needs a title or content, not both
			sendRequest('POST', '/controllers/gatekeeper.php', $('#profileForm').serialize());
		} else {
			// Nothing filled in, or something doesn't match
			if(password.value != password2.value) {
				Notify([['Both passwords should be matching!', 0]]);
			}

			if(password.value.length < 8) {
				Notify([['Password should be atleast 8 characters!', 0]]);	
			}

			if(!/^[a-zA-Z ]*$/.test(name.value)) {
				Notify([['Name should only have letters!', 0]]);	
			}
		}
	});

	$('#actionWindow').on('click', 'button#postTrigger', function() {
		$('form#newPost').show().animate({opacity: 1, height: 235 + 'px'});
	}).on('click', 'button#logout', function() {

	})

	$('#messageWrapper').on('click', 'input#closePosting', function() {
		$('form#newPost').animate({opacity: 0, height: 0 + 'px'}, function(){ $(this).hide() });
		$('form#newPost input[type="text"], form#newPost textarea').each(function(){
			this.value = "";
		});
	})

});
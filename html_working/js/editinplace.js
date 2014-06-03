	// This example shows how to call the function and display a textarea
	// instead of a regular text box. A few other options are set as well,
	// including an image saving icon, rows and columns for the textarea,
	// and a different rollover color.
	// $(".edit-desc").editInPlace({

	// 	callback: function(unused, enteredText) { 

	// 		$.ajax({
	// 			type: 'POST',
	// 			url: '../../php_working/editinplace.php',
	// 			data: { description: enteredText; }

	// 		});

	// 		return enteredText; },

	//     url: "../../php_working/editinplace.php",
	// 	bg_over: "#cff",
	// 	field_type: "textarea",
	// 	textarea_rows: "15",
	// 	textarea_cols: "35"
	// 	// saving_image: "./images/ajax-loader.gif"

	// });

$(document).ready(function() {

     $(".edit_area").editable('../../php_working/editinplace.php', { 
         type      : 'textarea',
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="img/indicator.gif">',
         
   
     });

 });
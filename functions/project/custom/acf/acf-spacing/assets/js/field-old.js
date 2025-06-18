
/**
 * Included when FIELD_NAME fields are rendered for editing by publishers.
 */

( function( $ ) {
	function initialize_field( $field ) {
		/**
		 * $field is a jQuery object wrapping field elements in the editor.
		 */
		var top = '';
		var bottom = '';
		var res = '';
		var arrayValues = [
			// ARRAYS ARE ALWAYS SET AS: TOP / BOTTOM / TOP BOTTOM

			// TOP
			"u--pt-22 u--pt-tablets-15",
			"u--pt-15 u--pt-tablets-10",
			"u--pt-10 u--pt-tablets-7",
			"u--pt-7 u--pt-tablets-4",

			// BOTTOM
			"u--pb-22 u--pb-tablets-15",
			"u--pb-15 u--pb-tablets-10",
			"u--pb-10 u--pb-tablets-7",
			"u--pb-7 u--pb-tablets-4",

			// MIXED
			// VALUES FOR LARGE
			"u--pt-15 u--pt-tablets-10 u--pb-22 u--pb-tablets-15",
			"u--pt-15 u--pt-tablets-10 u--pb-15 u--pb-tablets-10",
			"u--pt-15 u--pt-tablets-10 u--pb-10 u--pb-tablets-7",
			"u--pt-15 u--pt-tablets-10 u--pb-7 u--pb-tablets-4",

			// VALUES FOR MEDIUM
			"u--pt-10 u--pt-tablets-7 u--pb-22 u--pb-tablets-15",
			"u--pt-10 u--pt-tablets-7 u--pb-15 u--pb-tablets-10",
			"u--pt-10 u--pt-tablets-7 u--pb-10 u--pb-tablets-7",
			"u--pt-10 u--pt-tablets-7 u--pb-7 u--pb-tablets-4",

			// VALUES FOR SMALL
			"u--pt-7 u--pt-tablets-4 u--pb-22 u--pb-tablets-15",
			"u--pt-7 u--pt-tablets-4 u--pb-15 u--pb-tablets-10",
			"u--pt-7 u--pt-tablets-4 u--pb-10 u--pb-tablets-7",
			"u--pt-7 u--pt-tablets-4 u--pb-7 u--pb-tablets-4",

			// VALUES FOR EXTRA LARGE
			"u--pt-22 u--pt-tablets-15 u--pb-22 u--pb-tablets-15",
			"u--pt-22 u--pt-tablets-15 u--pb-15 u--pb-tablets-10",
			"u--pt-22 u--pt-tablets-15 u--pb-10 u--pb-tablets-7",
			"u--pt-22 u--pt-tablets-15 u--pb-7 u--pb-tablets-4",
		];
		var arrayNames = [
			// TOP
			"top-extra-large",
			"top-large",
			"top-medium",
			"top-small",

			// BOTTOM
			"bottom-extra-large",
			"bottom-large",
			"bottom-medium",
			"bottom-small",

			// MIXED
			"top-extra-large-bottom-extra-large",
			"top-extra-large-bottom-large",
			"top-extra-large-bottom-medium",
			"top-extra-large-bottom-small",

			"top-large-bottom-extra-large",
			"top-large-bottom-large",
			"top-large-bottom-medium",
			"top-large-bottom-small",
			
			"top-medium-bottom-extra-large",
			"top-medium-bottom-large",
			"top-medium-bottom-medium",
			"top-medium-bottom-small",

			"top-small-bottom-extra-large",
			"top-small-bottom-large",
			"top-small-bottom-medium",
			"top-small-bottom-small",
		];

		var arrayVal = [
			// top
			"t-xl",
			"d-e",
			"d-f",
			"d-g",

			// bottom
			"b-xl",
			"b-h",
			"b-i",
			"b-j",

			// top & bottom
			"t-xl-b-xl",
			"t-xl-b-h",
			"t-xl-b-i",
			"t-xl-b-j",

			"d-e-b-xl",
			"d-e-b-h",
			"d-e-b-i",
			"d-e-b-j",
			
			"d-f-b-xl",
			"d-f-b-h",
			"d-f-b-i",
			"d-f-b-j",

			"d-g-b-xl",
			"d-g-b-h",
			"d-g-b-i",
			"d-g-b-j",
		];
		var topSpace = $field.find(".js--top-space");
		var bottomSpace = $field.find(".js--bottom-space");
		var topTitle = $field.find(".js--top-title");
		var bottomTitle = $field.find(".js--bottom-title");
		$.each($($field.find(".js--padding").find("button")),function(){
			if($field.find("input").val()){
				$.each($($field.find(".js--padding").find("button")),function(){
					var fieldValue = $field.find("input").val();
					switch ($field.find("input").val()) {
						case "bottom-extra-large":
						case "bottom-large":
						case "bottom-medium":
						case "bottom-small":
							if($(this).val() == "b"){
								$(this).addClass('active')
							}else{
								$(this).addClass('no-active')
							}
							if(fieldValue == 'bottom-extra-large'){
								bottom = "u--pb-22 u--pb-tablets-15"
							}else if(fieldValue == 'bottom-large'){
								bottom = "u--pb-15 u--pb-tablets-10"
							}else if(fieldValue == 'bottom-small'){ // ERROR?
								bottom = "u--pb-10 u--pb-tablets-7"
							}else if(fieldValue == 'bottom-small'){
								bottom = "u--pb-7 u--pb-tablets-4"
							}
							break;
						case "top-extra-large":
						case "top-large":
						case "top-medium":
						case "top-small":
							if($(this).val() == "d"){
								$(this).addClass('active')
							}else{
								$(this).addClass('no-active')
							}
							if(fieldValue == 'top-extra-large'){
								top = "u--pt-22 u--pt-tablets-15"
							}else if(fieldValue == 'top-large'){
								top = "u--pt-15 u--pt-tablets-10"
							}else if(fieldValue == 'top-small'){ // ERROR?
								top = "u--pt-10 u--pt-tablets-7"
							}else if(fieldValue == 'top-small'){
								top = "u--pt-7 u--pt-tablets-4"
							}
							break;
						case "top-extra-large-bottom-extra-large":
						case "top-extra-large-bottom-large":
						case "top-extra-large-bottom-medium":
						case "top-extra-large-bottom-small":
						case "top-large-bottom-extra-large":
						case "top-large-bottom-large":
						case "top-large-bottom-medium":
						case "top-large-bottom-small":
						case "top-medium-bottom-extra-large":
						case "top-medium-bottom-large":
						case "top-medium-bottom-medium":
						case "top-medium-bottom-small":
						case "top-small-bottom-extra-large":
						case "top-small-bottom-large":
						case "top-small-bottom-medium":
						case "top-small-bottom-small":
							if($(this).val() == "a"){
								$(this).addClass('active')
							}else{
								$(this).addClass('no-active')
							}
							if(fieldValue == 'top-extra-large-bottom-extra-large'){
								top = "u--pt-22 u--pt-tablets-15";
								bottom = "u--pb-22 u--pb-tablets-15";
							}else if(fieldValue == 'top-extra-large-bottom-large'){
								top = "u--pt-22 u--pt-tablets-15";
								bottom = "u--pb-15 u--pb-tablets-10";
							}else if(fieldValue == 'top-extra-large-bottom-medium'){
								top = "u--pt-22 u--pt-tablets-15";
								bottom = "u--pb-10 u--pb-tablets-8";
							}else if(fieldValue == 'top-extra-large-bottom-small'){
								top = "u--pt-22 u--pt-tablets-15";
								bottom = "u--pb-8 u--pb-tablets-5";
							}else if(fieldValue == 'top-large-bottom-extra-large'){
								top = "u--pt-15 u--pt-tablets-10";
								bottom = "u--pb-22 u--pb-tablets-15";
							}else if(fieldValue == 'top-large-bottom-large'){
								top = "u--pt-15 u--pt-tablets-10";
								bottom = "u--pb-10 u--pb-tablets-7"; // Error?
							}else if(fieldValue == 'top-large-bottom-medium'){
								top = "u--pt-15 u--pt-tablets-10";
								bottom = "u--pb-15 u--pb-tablets-10"; // Error?
							}else if(fieldValue == 'top-large-bottom-small'){
								top = "u--pt-15 u--pt-tablets-10";
								bottom = "u--pb-7 u--pb-tablets-4";
							}else if(fieldValue == 'top-medium-bottom-extra-large'){
								top = "u--pt-10 u--pt-tablets-7";
								bottom = "u--pb-22 u--pb-tablets-15";
							}else if(fieldValue == 'top-medium-bottom-large'){
								top = "u--pt-10 u--pt-tablets-7";
								bottom = "u--pb-15 u--pb-tablets-10";
							}else if(fieldValue == 'top-medium-bottom-medium'){
								top = "u--pt-10 u--pt-tablets-7";
								bottom = "u--pb-10 u--pb-tablets-7";
							}else if(fieldValue == 'top-medium-bottom-small'){
								top = "u--pt-10 u--pt-tablets-7";
								bottom = "u--pb-7 u--pb-tablets-4";
							}else if(fieldValue == 'top-small-bottom-extra-large'){
								top = "u--pt-7 u--pt-tablets-4";
								bottom = "u--pb-22 u--pb-tablets-15";
							}else if(fieldValue == 'top-small-bottom-large'){
								top = "u--pt-7 u--pt-tablets-4";
								bottom = "u--pb-15 u--pb-tablets-10";
							}else if(fieldValue == 'top-small-bottom-medium'){
								top = "u--pt-7 u--pt-tablets-4 ";
								bottom = "u--pb-10 u--pb-tablets-7";
							}else if(fieldValue == 'top-small-bottom-small'){
								top = "u--pt-7 u--pt-tablets-4";
								bottom = "u--pb-7 u--pb-tablets-4";
							}
							break;
						default:
							if($(this).val() == "-"){
								$(this).addClass('active')
							}else{
								$(this).addClass('no-active')
							}
							break;
					}
		
				});
				
			}
			$(this).on("click", (e) => {
				// ON IMAGE CLICK WE REMOVE ALL ACTIVE FIELDS AND SET LARGE AS DEFAULT
				e.preventDefault();
				var buttonValue = $(this).val();
				
				$.each($($field.find(".js--padding").find("button")),function(){
					$(this).removeClass('active')
					$(this).addClass('no-active')
				});
				$(this).addClass('active');
				$(this).removeClass('no-active');


				if(buttonValue == 'a'){
					// TOP & BOTTOM
					topSpace.css("display", "inline-flex");
					bottomSpace.css("display", "inline-flex");
					topTitle.css("display", "block");
					bottomTitle.css("display", "block");

					// SET BY DEFAULT EXTRA LARGE
					top = "u--pt-22 u--pt-tablets-15";
					bottom = "u--pb-22 u--pb-tablets-15";

					// TOP EXTRA LARGE
					$.each($($field.find(".js--top-space").find("#t-xl")),function(){
						$(this).addClass('active')
						$(this).removeClass('no-active')
					});
					// TOP LARGE
					$.each($($field.find(".js--top-space").find("#e")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// TOP MEDIUM
					$.each($($field.find(".js--top-space").find("#f")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// TOP SMALL
					$.each($($field.find(".js--top-space").find("#g")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// BOTTOM EXTRA LARGE
					$.each($($field.find(".js--bottom-space").find("#b-xl")),function(){
						$(this).addClass('active')
						$(this).removeClass('no-active')
					});
					// BOTTOM LARGE
					$.each($($field.find(".js--bottom-space").find("#h")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// BOTTOM MEDIUM
					$.each($($field.find(".js--bottom-space").find("#i")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// BOTTOM SMALL
					$.each($($field.find(".js--bottom-space").find("#j")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
				}else if(buttonValue == 'd'){
					// ONLY TOP
					topSpace.css("display", "inline-flex");
					bottomSpace.css("display", "none");
					topTitle.css("display", "block");
					bottomTitle.css("display", "none");

					// SET BY DEFAULT EXTRA LARGE
					top = "u--pt-22 u--pt-tablets-15";
					bottom = "";

					// TOP EXTRA LARGE
					$.each($($field.find(".js--top-space").find("#t-xl")),function(){
						$(this).addClass('active')
						$(this).removeClass('no-active')
					});
					// TOP LARGE
					$.each($($field.find(".js--top-space").find("#e")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// TOP MEDIUM
					$.each($($field.find(".js--top-space").find("#f")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// TOP SMALL
					$.each($($field.find(".js--top-space").find("#g")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
				}else if(buttonValue == 'b'){
					// ONLY BOTTOM
					topSpace.css("display", "none");
					bottomSpace.css("display", "inline-flex");
					topTitle.css("display", "none");
					bottomTitle.css("display", "block");

					// SET BY DEFAULT EXTRA LARGE
					top = "";
					bottom =  "u--pb-22 u--pb-tablets-15";

					// BOTTOM EXTRA LARGE
					$.each($($field.find(".js--bottom-space").find("#b-xl")),function(){
						$(this).addClass('active')
						$(this).removeClass('no-active')
					});
					// BOTTOM LARGE
					$.each($($field.find(".js--bottom-space").find("#h")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// BOTTOM MEDIUM
					$.each($($field.find(".js--bottom-space").find("#i")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
					// BOTTOM SMALL
					$.each($($field.find(".js--bottom-space").find("#j")),function(){
						$(this).removeClass('active')
						$(this).addClass('no-active')
					});
				}else{
					// NONE
					topSpace.css("display", "none");
					bottomSpace.css("display", "none");
					topTitle.css("display", "none");
					bottomTitle.css("display", "none");

					top = "";
					bottom = "";
				}
				$field.find("input").val(top + " " + bottom);
				
				if(top && bottom){
					res = top + " " + bottom;
				}else if(top){
					res = top ;
				}else if(bottom){
					res = bottom ;
				}else{
					res = '';
				}
				const found =  arrayValues.indexOf(res )
				if(res != ''){
					$field.find("input").val(arrayNames[found]);
				}else{
					$field.find("input").val("-");
				}

			});
		});

		$.each($($field.find(".js--top-space").find("button")),function(){
			if($field.find("input").val()){
				$.each($($field.find(".js--top-space").find("button")),function(){
					var valu = $field.find("input").val();
					var test =  arrayNames.indexOf(valu);
					console.log(valu);
					console.log(test);
					if(test !== -1){
						if(arrayVal[test].includes($(this).val())){
							$(this).addClass('active')
							topSpace.css("display", "inline-flex");
							topTitle.css("display", "block");
						}else{
							$(this).addClass('no-active')
						}
					}else{
						$(this).addClass('no-active')
					}
				});
			}
			$(this).on("click", (e) => {
				// TOP OPTIONS BUTTONS
				e.preventDefault();
				var buttonValue = $(this).val();
				console.log(buttonValue);
				top = buttonValue;
				if(buttonValue == "t-xl"){
					top = "u--pt-22 u--pt-tablets-15";
				}else if(buttonValue == "e"){
					top = "u--pt-15 u--pt-tablets-10";
				}else if(buttonValue == "f"){
					top = "u--pt-10 u--pt-tablets-7";
				}else if(buttonValue == 'g'){
					top = "u--pt-7 u--pt-tablets-4";
				}
				console.log(top);
				console.log(bottom);
				if(top && bottom){
					res = top + " " + bottom;
				}else if(top){
					res = top ;
				}else if(bottom){
					res = bottom ;
				}
				const foundTop =  arrayValues.indexOf(res );
				$field.find("input").val(arrayNames[foundTop]);
				console.log(res);
				$.each($($field.find(".js--top-space").find("button")),function(){
					$(this).removeClass('active')
					$(this).addClass('no-active')
				});
				$(this).addClass('active');
				$(this).removeClass('no-active');

			});
		});

		$.each($($field.find(".js--bottom-space").find("button")),function(){
			if($field.find("input").val()){
				$.each($($field.find(".js--bottom-space").find("button")),function(){
					var valu = $field.find("input").val();
					var test =  arrayNames.indexOf(valu);
					if(test !== -1){
						if(arrayVal[test].includes($(this).val())){
							$(this).addClass('active')
							bottomSpace.css("display", "inline-flex");
							bottomTitle.css("display", "block");
						}else{
							$(this).addClass('no-active')
						}
					}else{
						$(this).addClass('no-active')
					}
				});
			}
			$(this).on("click", (e) => {
				// BOTTOM OPTIONS BUTTONS
				e.preventDefault();
				var buttonValue = $(this).val();
				if(buttonValue == "b-xl"){
					bottom = "u--pb-22 u--pb-tablets-15";
				}else if(buttonValue == "h"){
					bottom = "u--pb-15 u--pb-tablets-10";
				}else if(buttonValue == "i"){
					bottom = "u--pb-10 u--pb-tablets-7";
				}else if(buttonValue == 'j'){
					bottom = "u--pb-7 u--pb-tablets-4";
				}
				if(top && bottom){
					res = top + " " + bottom;
				}else if(top){
					res = top ;
				}else if(bottom){
					res = bottom ;
				}
				console.log({res});
				const foundBottom =  arrayValues.indexOf(res);
				$field.find("input").val(arrayNames[foundBottom]);
				console.log(foundBottom);
				$.each($($field.find(".js--bottom-space").find("button")),function(){
					$(this).removeClass('active')
					$(this).addClass('no-active')
				});
				$(this).addClass('active');
				$(this).removeClass('no-active');

			});
		});

	}

	if( typeof acf.add_action !== 'undefined' ) {
		/**
		 * Run initialize_field when existing fields of this type load,
		 * or when new fields are appended via repeaters or similar.
		 */

		acf.add_action( 'ready_field/type=spacing', initialize_field );
		acf.add_action( 'append_field/type=spacing', initialize_field );
	}
} )( jQuery );

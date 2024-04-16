jQuery(function ($) {
	let inputPhone = document.querySelector("#billing_phone");
	let errorMsg = document.querySelector("#error-msg");
	let validMsg = document.querySelector("#valid-msg");
	let errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

	let phoneInput = window.intlTelInput(inputPhone, {
		initialCountry: "my",
		// utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
        utilsScript: acewcpcc.utilsScriptUrl,
		autoHideDialCode: false,
		preferredCountries: ["my"],
		separateDialCode: true,
	});

	let selectedCountryData = phoneInput.getSelectedCountryData();

	let resetPhoneError = function() {
        inputPhone.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
	};

	// on blur: validate
	inputPhone.addEventListener("blur", function() {
        resetPhoneError();
        
        if (inputPhone.value.trim()) {
            if (phoneInput.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                inputPhone.classList.add("error");
                var errorCode = phoneInput.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
	});

	inputPhone.addEventListener("countrychange", function() {
	    
		document.getElementById("contactNo").value = phoneInput.getNumber();

		selectedCountryData = phoneInput.getSelectedCountryData();

        if(selectedCountryData) {
			for(key in selectedCountryData) {
				if(selectedCountryData.hasOwnProperty(key)) {
					let countryCode = selectedCountryData["iso2"];
					let dialCode = selectedCountryData["dialCode"];
					let phoneCountry = selectedCountryData["name"];

					document.getElementById("countryCode").value = countryCode;
					document.getElementById("dialCode").value = dialCode;
					document.getElementById("phoneCountry").value = phoneCountry;
				}
			}
        }
	});

	$( 'body' ).on( 'click', '#place_order', function() {
		
		const wrapperBillingPhone = $('#billing_phone_field');
		
	    if (inputPhone.value.trim()) {
    		if( !phoneInput.isValidNumber() ) {
    			wrapperBillingPhone.removeClass( 'woocommerce-validated' );
    			wrapperBillingPhone.addClass( 'woocommerce-invalid' ); // error
    			wrapperBillingPhone.addClass( 'woocommerce-invalid-required-field' ); // error
    			document.getElementById("phoneHasError").value = '1';
    		} else {
    			wrapperBillingPhone.removeClass( 'woocommerce-invalid' );
    			wrapperBillingPhone.removeClass( 'woocommerce-invalid-required-field' );
    			wrapperBillingPhone.addClass( 'woocommerce-validated' ); // success
    			document.getElementById("phoneHasError").value = '';
    		}
	    }
	});

	$( 'body' ).on( 'blur change', '#billing_phone', function() {
		const wrapper = $('#billing_phone_field');
		
        if (inputPhone.value.trim()) {
            if( !phoneInput.isValidNumber() ) {
            	wrapper.removeClass( 'woocommerce-validated' );
            	wrapper.addClass( 'woocommerce-invalid' ); // error
            	wrapper.addClass( 'woocommerce-invalid-required-field' ); // error
            } else {
            	wrapper.removeClass( 'woocommerce-invalid' );
            	wrapper.removeClass( 'woocommerce-invalid-required-field' );
            	wrapper.addClass( 'woocommerce-validated' ); // success
            }
        }
	});

	$( document.body ).on( 'checkout_error', function () {
		const wrapper = $('#billing_phone_field');
		
	  if (inputPhone.value.trim()) {
		if( !phoneInput.isValidNumber() ) {
			wrapper.removeClass( 'woocommerce-validated' );
			wrapper.addClass( 'woocommerce-invalid' ); // error
			wrapper.addClass( 'woocommerce-invalid-required-field' ); // error
		} else {
			wrapper.removeClass( 'woocommerce-invalid' );
			wrapper.removeClass( 'woocommerce-invalid-required-field' );
			wrapper.addClass( 'woocommerce-validated' ); // success
		}
	  }
	});

	let handleChange = function() {

		inputPhone.classList.remove("error");
		errorMsg.innerHTML = "";
		errorMsg.classList.add("hide");
		validMsg.classList.add("hide");


		let text = (phoneInput.isValidNumber()) ? "International: " + phoneInput.getNumber() : "Please enter a number below";
		let textNode = document.createTextNode(text);
		document.getElementById("contactNo").value = phoneInput.getNumber();


		let elements = phoneInput.getSelectedCountryData();

		for(key in elements) {
			if(elements.hasOwnProperty(key)) {
				let countryCode = elements["iso2"];
				let dialCode = elements["dialCode"];
				let phoneCountry = elements["name"];

				document.getElementById("countryCode").value = countryCode;
				document.getElementById("dialCode").value = dialCode;
				document.getElementById("phoneCountry").value = phoneCountry;
			}
		}
	  };

	inputPhone.addEventListener("change", handleChange);
	inputPhone.addEventListener("keyup", handleChange);
	

	$("#billing_phone").ready(function() {

		$("#billing_phone").addClass("numberonly");
		$("#billing_phone_field").append('<span id="valid-msg" class="hide">✓ Valid</span> <span id="error-msg" class="hide"></span> <input type="hidden" id="countryCode" name="countryCode" value="" /> <input type="hidden" id="phoneCountry" name="phoneCountry" value="" /> <input type="hidden" id="dialCode" name="dialCode" value="" /> <input type="hidden" id="contactNo" name="contactNo" value="" /> <input type="hidden" id="phoneHasError" name="phoneHasError" value="" />');
		
		
		inputPhone = document.querySelector("#billing_phone");
		errorMsg = document.querySelector("#error-msg");
		validMsg = document.querySelector("#valid-msg");
		
		
		document.getElementById("contactNo").value = phoneInput.getNumber();


		let selectedCountryData = phoneInput.getSelectedCountryData();

		for(key in selectedCountryData) {
			if(selectedCountryData.hasOwnProperty(key)) {
				let countryCode = selectedCountryData["iso2"];
				let dialCode = selectedCountryData["dialCode"];
				let phoneCountry = selectedCountryData["name"];

				document.getElementById("countryCode").value = countryCode;
				document.getElementById("dialCode").value = dialCode;
				document.getElementById("phoneCountry").value = phoneCountry;
			}
		}

		$(".numberonly").keypress(function (e) {    

			var charCode = (e.which) ? e.which : event.keyCode    

			if (String.fromCharCode(charCode).match(/[^0-9]/g))    

				return false;                        

		});
	});
	
	
	let formWCCheckout = $("form.woocommerce-checkout");

	let countryCode2 = "";
	let dialCode2 = "";
	let phoneCountry2 = "";
	
	
	formWCCheckout.submit(function(e){
	
		//e.preventDefault();
	
		inputPhone = document.querySelector("#billing_phone");
		let instancePhoneInput = window.intlTelInputGlobals.getInstance(inputPhone);
		instancePhoneInput.isValidNumber();
	
		if (!instancePhoneInput.isValidNumber()) {
			//alert("Phone is not valid.");
			//return false;
		}
		
		

		let elements = phoneInput.getSelectedCountryData();
		for(key in elements) {
			if(elements.hasOwnProperty(key)) {
				countryCode2 = elements["iso2"];
				dialCode2 = elements["dialCode"];
				phoneCountry2 = elements["name"];
			}
		}

		let countryCodeField = document.getElementById("countryCode");
		countryCodeField.value = countryCode2;

		let dialCodeField = document.getElementById("dialCode");
		dialCodeField.value = dialCode2;

		let phoneCountryField = document.getElementById("phoneCountry");
		phoneCountryField.value = phoneCountry2;
		
		document.getElementById("contactNo").value = phoneInput.getNumber();
		//console.log('phoneInput.getNumber(): ', phoneInput.getNumber());
		
		//formWCCheckout.submit();
	});
});
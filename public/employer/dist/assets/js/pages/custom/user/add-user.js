"use strict";

// Class Definition
var KTAddUser = function () {
	// Private Variables
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _avatar;
	var _validations = [];

	// Private Functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			// Don't go to the next step yet
			_wizard.stop();

			// Validate form
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
			validator.validate().then(function (status, wizard) {
		        if (status == 'Valid') {
		            // Ajax request to get data

                    $.ajax({
                        method: "POST",
                        url: employerData,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            email: _formEl.querySelector('[name="email"]').value,
                            // profile_avatar: _formEl.querySelector('[name="profile_avatar"]').value,
                            // profile_avatar: _formEl.querySelector('[name="profile_avatar"]').file,
                            profile_avatar: $('#imageValue').val(),

                            name: _formEl.querySelector('[name="name"]').value,
                            phoneNo: _formEl.querySelector('[name="phoneNo"]').value,
                            phoneNo2: _formEl.querySelector('[name="phoneNo2"]').value,
                            companyPhoneNo: _formEl.querySelector('[name="companyPhoneNo"]').value,
                            companyWebAddress: _formEl.querySelector('[name="companyWebAddress"]').value,
                            aboutus: _formEl.querySelector('[name="aboutus"]').value,
                            country_name: _formEl.querySelector('[name="country_name"]').value,
                            category: $('#category').val(),
                            instagramlink: _formEl.querySelector('[name="instagramlink"]').value,
                            twitterlink: _formEl.querySelector('[name="twitterlink"]').value,
                            linkedinlink: _formEl.querySelector('[name="linkedinlink"]').value,

                            // _formEl,

                        },

                        success: function (response) {
                            if(response.status === 1){
                                $('#sessionData').load(" #sessionData > *");
                                _wizard.goNext();
                                KTUtil.scrollTop();
                            }
                            else if(response.status === 0){
                                // KTUtil.scrollTop();
                                Swal.fire({
                                    text: "Company name already present in our records for selected country.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light"
                                    }
                                }).then(function() {
                                    KTUtil.scrollTop();
                                });
                            }
                            else{
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light"
                                    }
                                }).then(function() {
                                    KTUtil.scrollTop();
                                });
                            }
                        }
                    });
                    // Go to next page
					// _wizard.goNext();
					// KTUtil.scrollTop();
				} else {
					Swal.fire({
		                text: "Sorry, looks like there are some errors detected, please try again.",
		                icon: "error",
		                buttonsStyling: false,
		                confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
		            }).then(function() {
						KTUtil.scrollTop();
					});
				}
		    });
		});

		// Change Event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

	var _initValidations = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

		// Validation Rules For Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            },
                            remote: {
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    email: _formEl.querySelector('[name="email"]').value,
                                },
                                method: 'POST',
                                url: route,
                                message: 'An account with this email id is already registered',

                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Password must be more than 8 characters'
                            }
                        }
                    },
                    confirmPassword: {
                        validators: {
                            notEmpty: {
                                message: 'Confirm password is required',
                            },
                            identical: {
                                compare: function() {
                                    return _formEl.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    name: {
						validators: {
							notEmpty: {
								message: 'Company Name is required'
							}
						}
					},
                    phoneNo: {
						validators: {
							notEmpty: {
								message: 'Company Phone Number is required'
							}
						}
					},
                    aboutus: {
						validators: {
							notEmpty: {
								message: 'Description is required'
							}
						}
					},
                    country_name: {
						validators: {
							notEmpty: {
								message: 'Location is required'
							},
                            // remote: {
                            //     data: {
                            //         _token: $('meta[name="csrf-token"]').attr('content'),
                            //         name: _formEl.querySelectorAll("div.celsi"),
                            //         // country_name: _formEl.querySelector('[name="country_name"]').value,
                            //     },
                            //     method: 'POST',
                            //     // url: 'path/candidate/register-post/',
                            //     url: employerCompanyCheckRoute,
                            //     message: 'Company name already present in our records for selected country',
                            // }
						}
					},
                    category: {
						validators: {
							notEmpty: {
								message: 'Field/Industry is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	var _initAvatar = function () {
		_avatar = new KTImageInput('kt_user_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');

			_initWizard();
			_initValidations();
			_initAvatar();
		}
	};
}();

$('.js-example-basic-multiple').select2({
    placeholder: "Select",
    allowClear: true
});

jQuery(document).ready(function () {
	KTAddUser.init();
});

$('#country_id').on('change', function() {
    // Action goes here.
    // alert('hi');
    // alert($('#country_id').val());
});

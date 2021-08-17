"use strict";

// Class Definition
var KTAddUser = function () {
	// Private Variables
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _avatar;
	var _validations = [];
	var experienceValid = 1;

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

			let degree = $('#myDegree').val();
			let checker = 0;

			let experienceChecker = 0;

			if($('#no_experience').is(':checked')){
				experienceChecker = 1;
			}
			else{
				experienceChecker = 0;
			}

			if(wizard.getStep() == 3 && degree == 1){
				checker++;
			}

			var experiencePresent = 0;
			var educationPresent = 0;

			if($('#experience_present').is(':checked')){
				experiencePresent = 1;
			}
			else{
				experiencePresent = 0;
			}

			if($('#education_present').is(':checked')){
				educationPresent = 1;
			}
			else{
				educationPresent = 0;
			}

			if(checker == 0){
				// Validate form
				var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						if((wizard.getStep() == 3 || wizard.getStep() == 4) && degree != 1){
							if(educationPresent == 0){
								if($('#educationeEndingDate').val() == ''){
									$('#educationeEndingDate').removeClass('is-valid').addClass('is-invalid');
									document.querySelector('#educationeEndingDate').nextSibling.innerHTML = '';
									document.querySelector('#educationeEndingDate').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
								}
								else{
									$('#educationeEndingDate').removeClass('is-invalid').addClass('is-valid');
									document.querySelector('#educationeEndingDate').nextSibling.innerHTML = '';
								}
							}
							else{
								$('#educationeEndingDate').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#educationeEndingDate').nextSibling.innerHTML = '';
							}
						}

						if((wizard.getStep() == 3 || wizard.getStep() == 4) && experienceChecker == 0){

							if($('#experience_description').val() == ''){
								$('#experience_description').removeClass('is-valid').addClass('is-invalid');
								document.querySelector('#experience_description').nextSibling.innerHTML = '';
								document.querySelector('#experience_description').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
								experienceValid = 0;
							}
							else{
								$('#experience_description').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#experience_description').nextSibling.innerHTML = '';
								experienceValid = 1;
							}
					
							if($('#position').val() == ''){
								$('#position').removeClass('is-valid').addClass('is-invalid');
								document.querySelector('#position').nextSibling.innerHTML = '';
								document.querySelector('#position').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
								experienceValid = 0;
							}
							else{
								$('#position').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#position').nextSibling.innerHTML = '';
								experienceValid = 1;
							}
					
					
							if($('#company_location').val() == ''){
								$('#company_location').removeClass('is-valid').addClass('is-invalid');
								document.querySelector('#company_location').nextSibling.innerHTML = '';
								document.querySelector('#company_location').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
								experienceValid = 0;
							}
							else{
								$('#company_location').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#company_location').nextSibling.innerHTML = '';
								experienceValid = 1;
							}
					
							if($('#company').val() == ''){
								$('#company').removeClass('is-valid').addClass('is-invalid');
								document.querySelector('#company').nextSibling.innerHTML = '';
								document.querySelector('#company').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
								experienceValid = 0;
							}
							else{
								$('#company').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#company').nextSibling.innerHTML = '';
								experienceValid = 1;
							}
					
							if($('#experienceStartingDate').val() == ''){
								$('#experienceStartingDate').removeClass('is-valid').addClass('is-invalid');
								document.querySelector('#experienceStartingDate').nextSibling.innerHTML = '';
								document.querySelector('#experienceStartingDate').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
								experienceValid = 0;
							}
							else{
								$('#experienceStartingDate').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#experienceStartingDate').nextSibling.innerHTML = '';
								experienceValid = 1;
							}
					
							if(experiencePresent == 0){
								if($('#experienceEndingDate').val() == ''){
									$('#experienceEndingDate').removeClass('is-valid').addClass('is-invalid');
									document.querySelector('#experienceEndingDate').nextSibling.innerHTML = '';
									document.querySelector('#experienceEndingDate').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
									experienceValid = 0;
								}
								else{
									$('#experienceEndingDate').removeClass('is-invalid').addClass('is-valid');
									document.querySelector('#experienceEndingDate').nextSibling.innerHTML = '';
									experienceValid = 1;
								}
							}
							else{
								$('#experienceEndingDate').removeClass('is-invalid').addClass('is-valid');
								document.querySelector('#experienceEndingDate').nextSibling.innerHTML = '';
								// experienceValid = 1;
							}
					
							if(experienceValid == 0){
								return;
							}
						}

						$.ajax({
							method: "POST",
							url: candidateData,
							data: {
								_token: $('meta[name="csrf-token"]').attr('content'),
								stepId: wizard.getStep(),
								email: _formEl.querySelector('[name="email"]').value,
								phone: _formEl.querySelector('[name="phone"]').value,
								firstName: _formEl.querySelector('[name="firstName"]').value,
								lastName: _formEl.querySelector('[name="lastName"]').value,
								gender: _formEl.querySelector('[name="gender"]').value,
								DOB: _formEl.querySelector('[name="DOB"]').value,
								nationality: _formEl.querySelector('[name="nationality"]').value,
								location: _formEl.querySelector('[name="location"]').value,
								field_of_expertise: $('#field_of_expertise').val(),
								country_of_interest: $('#country_of_interest').val(),
								qualification: _formEl.querySelector('[name="qualification"]').value,
								field_of_study: _formEl.querySelector('[name="field_of_study"]').value,
								institution: _formEl.querySelector('[name="institution"]').value,
								description: _formEl.querySelector('[name="description"]').value,
								starting_date: _formEl.querySelector('[name="starting_date"]').value,
								ending_date: _formEl.querySelector('[name="ending_date"]').value,
								company: _formEl.querySelector('[name="company"]').value,
								company_location: _formEl.querySelector('[name="company_location"]').value,
								position: _formEl.querySelector('[name="position"]').value,
								experience_description: _formEl.querySelector('[name="experience_description"]').value,
								experience_starting_date: _formEl.querySelector('[name="experience_starting_date"]').value,
								experience_ending_date: _formEl.querySelector('[name="experience_ending_date"]').value,
								experience_present: experiencePresent,
								education_present: educationPresent,
								no_experience: experienceChecker,
							},

							success: function (response) {
								if(response.status === 1){
									$('#sessionData').load(" #sessionData > *");
									_formEl.querySelector('[id="prev-step"]').disabled = false;
									_wizard.goNext();
									KTUtil.scrollTop();
								}
								else if(response.status === 0){
									$('#educationeEndingDate').removeClass('is-valid').addClass('is-invalid');
									Swal.fire({
										text: "'ENDING DATE' field should be greater than 'STARTING DATE' field, in Education part.",
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
								else if(response.status === 2){
									Swal.fire({
										text: "'ENDING DATE' field should be greater than 'STARTING DATE' field, in Experience part.",
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
					} 
					else {
						Swal.fire({
							text: "Sorry, looks like there are some required filed empty detected, please fill them and try again.",
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
			}
			else{
				if((wizard.getStep() == 3 || wizard.getStep() == 4) && experienceChecker == 0){

					if($('#experience_description').val() == ''){
						$('#experience_description').removeClass('is-valid').addClass('is-invalid');
						document.querySelector('#experience_description').nextSibling.innerHTML = '';
						document.querySelector('#experience_description').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
						experienceValid = 0;
					}
					else{
						$('#experience_description').removeClass('is-invalid').addClass('is-valid');
						document.querySelector('#experience_description').nextSibling.innerHTML = '';
						experienceValid = 1;
					}
			
					if($('#position').val() == ''){
						$('#position').removeClass('is-valid').addClass('is-invalid');
						document.querySelector('#position').nextSibling.innerHTML = '';
						document.querySelector('#position').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
						experienceValid = 0;
					}
					else{
						$('#position').removeClass('is-invalid').addClass('is-valid');
						document.querySelector('#position').nextSibling.innerHTML = '';
						experienceValid = 1;
					}
			
			
					if($('#company_location').val() == ''){
						$('#company_location').removeClass('is-valid').addClass('is-invalid');
						document.querySelector('#company_location').nextSibling.innerHTML = '';
						document.querySelector('#company_location').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
						experienceValid = 0;
					}
					else{
						$('#company_location').removeClass('is-invalid').addClass('is-valid');
						document.querySelector('#company_location').nextSibling.innerHTML = '';
						experienceValid = 1;
					}
			
					if($('#company').val() == ''){
						$('#company').removeClass('is-valid').addClass('is-invalid');
						document.querySelector('#company').nextSibling.innerHTML = '';
						document.querySelector('#company').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
						experienceValid = 0;
					}
					else{
						$('#company').removeClass('is-invalid').addClass('is-valid');
						document.querySelector('#company').nextSibling.innerHTML = '';
						experienceValid = 1;
					}
			
					if($('#experienceStartingDate').val() == ''){
						$('#experienceStartingDate').removeClass('is-valid').addClass('is-invalid');
						document.querySelector('#experienceStartingDate').nextSibling.innerHTML = '';
						document.querySelector('#experienceStartingDate').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
						experienceValid = 0;
					}
					else{
						$('#experienceStartingDate').removeClass('is-invalid').addClass('is-valid');
						document.querySelector('#experienceStartingDate').nextSibling.innerHTML = '';
						experienceValid = 1;
					}
			
					if(experiencePresent == 0){
						if($('#experienceEndingDate').val() == ''){
							$('#experienceEndingDate').removeClass('is-valid').addClass('is-invalid');
							document.querySelector('#experienceEndingDate').nextSibling.innerHTML = '';
							document.querySelector('#experienceEndingDate').insertAdjacentHTML('afterend', '<div class="fv-plugins-message-container"><div data-field="ending_date" data-validator="notEmpty" class="fv-help-block">Ending date is required</div></div>');
							experienceValid = 0;
						}
						else{
							$('#experienceEndingDate').removeClass('is-invalid').addClass('is-valid');
							document.querySelector('#experienceEndingDate').nextSibling.innerHTML = '';
							experienceValid = 1;
						}
					}
					else{
						$('#experienceEndingDate').removeClass('is-invalid').addClass('is-valid');
						document.querySelector('#experienceEndingDate').nextSibling.innerHTML = '';
						// experienceValid = 1;
					}
			
					if(experienceValid == 0){
						return;
					}
				}

				$.ajax({
					method: "POST",
					url: candidateData,
					data: {
						_token: $('meta[name="csrf-token"]').attr('content'),
						stepId: wizard.getStep(),
						email: _formEl.querySelector('[name="email"]').value,
						phone: _formEl.querySelector('[name="phone"]').value,
						firstName: _formEl.querySelector('[name="firstName"]').value,
						lastName: _formEl.querySelector('[name="lastName"]').value,
						gender: _formEl.querySelector('[name="gender"]').value,
						DOB: _formEl.querySelector('[name="DOB"]').value,
						nationality: _formEl.querySelector('[name="nationality"]').value,
						location: _formEl.querySelector('[name="location"]').value,
						field_of_expertise: $('#field_of_expertise').val(),
						country_of_interest: $('#country_of_interest').val(),
						qualification: _formEl.querySelector('[name="qualification"]').value,
						field_of_study: _formEl.querySelector('[name="field_of_study"]').value,
						institution: _formEl.querySelector('[name="institution"]').value,
						description: _formEl.querySelector('[name="description"]').value,
						starting_date: _formEl.querySelector('[name="starting_date"]').value,
						ending_date: _formEl.querySelector('[name="ending_date"]').value,
						company: _formEl.querySelector('[name="company"]').value,
						company_location: _formEl.querySelector('[name="company_location"]').value,
						position: _formEl.querySelector('[name="position"]').value,
						experience_description: _formEl.querySelector('[name="experience_description"]').value,
						experience_starting_date: _formEl.querySelector('[name="experience_starting_date"]').value,
						experience_ending_date: _formEl.querySelector('[name="experience_ending_date"]').value,
						experience_present: experiencePresent,
						education_present: educationPresent,
						no_experience: experienceChecker,
					},

					success: function (response) {
						if(response.status === 1){
							$('#sessionData').load(" #sessionData > *");
							_formEl.querySelector('[id="prev-step"]').disabled = false;
							_wizard.goNext();
							KTUtil.scrollTop();
						}
						else if(response.status === 0){
							Swal.fire({
								text: "'ENDING DATE' field should be greater than 'STARTING DATE' field, in Education part.",
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
						else if(response.status === 2){
							Swal.fire({
								text: "'ENDING DATE' field should be greater than 'STARTING DATE' field, in Experience part.",
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
			}
		});

		// Change Event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
        _wizard.on("submit",(function(t){
            Swal.fire({text:"All is good! Please confirm the form submission.",icon:"success",showCancelButton:!0,buttonsStyling:!1,confirmButtonText:"Yes, submit!",cancelButtonText:"No, cancel",
                customClass:{confirmButton:"btn font-weight-bold btn-primary",cancelButton:"btn font-weight-bold btn-default"}}).
            then((function(t){t.value?e.submit():"cancel"===t.dismiss&&Swal.fire({text:"Your form has not been submitted!.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",
                customClass:{confirmButton:"btn font-weight-bold btn-primary"}})}))}));
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
					phone: {
						validators: {
							notEmpty: {
								message: 'Phone is required'
							},
						}
					}
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
                    firstName: {
						validators: {
                            notEmpty: {
                                message: 'Please enter a first name'
                            }
						}
					},
                    lastName: {
						validators: {
							notEmpty: {
								message: 'Please enter a last name'
							}
						}
					},
                    gender: {
						validators: {
							notEmpty: {
								message: 'Please select your gender'
							}
						}
					},
                    DOB: {
                        validators: {
                            notEmpty: {
                                message: 'Select your date of birth'
                            }
                        }
                    },
                    nationality: {
						validators: {
							notEmpty: {
								message: 'Please select your nationality'
							}
						}
					},
                    location: {
						validators: {
							notEmpty: {
								message: 'Please select your current country'
							}
						}
					},

                    field_of_expertise: {
						validators: {
                            notEmpty: {
                            	message: 'Please select your field of industry'
                            },
                        }
					},

                    country_of_interest: {
						validators: {
							notEmpty: {
								message: 'Please select at least 1 option'
							},
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
                    qualification: {
						validators: {
                            notEmpty: {
                                message: 'Please select your degree'
                            }
						}
					},
                    field_of_study: {
						validators: {
							notEmpty: {
                                message: 'Field is required'
							}
						}
					},
                    institution: {
						validators: {
							notEmpty: {
								message: 'Institution Name is required'
							}
						}
					},
                    description: {
						validators: {
							notEmpty: {
								message: 'Description is required'
							}
						}
					},
                    starting_date: {
						validators: {
							notEmpty: {
								message: 'Starting date is required'
							}
						}
					},
                    // ending_date: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Ending date is required'
					// 		}
					// 	}
					// },
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
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

jQuery(document).ready(function () {
	KTAddUser.init();
        $('.js-example-basic-multiple').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('.js-example-basic-multiple1').select2({
            placeholder: "Select",
            allowClear: true
        });
});
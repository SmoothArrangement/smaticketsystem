
// JavaScript Document

jQuery(document).ready(function() {
     jQuery.validator.addMethod('mypassword', function(value, element) {
          return this.optional(element) || (value.match(/[A-Z]/) || value.match(/[0-9]/));
     });
	jQuery.validator.addMethod("notEqual", function(value, element, param) {
	  return this.optional(element) || value !== param;
	}, "Please choose a value!");
     var $rows = $('#signup_form').find('.row'),
     $label = $rows.children('label')
     jQuery('#signup_form').validate({
          rules: {
          	d2_fname: {
                    required: true,
			},
			d2_lname: {
                    required: true,
			},
			d2_email: {
                    required: true,
                    email: true,
                    remote: 'http://ticket.smootharrangement.de/ajax_check_user.php'
			},
			d2_email1: {
                    required: true,
                    email: true,
                    equalTo: '#d2_email'

			},
			d2_pass: {
               	required: true,
			},
			d2_pass1: {
                    required: true,
                    equalTo: '#d2_pass'
			}


          },
          messages: {
          	d2_fname: {
                    required: "Diese Angabe wird benotigt",
			},
			d2_lname: {
                    required: "Diese Angabe wird benotigt",
			},
			d2_email: {
                    required: "Diese Angabe wird benotigt",
                    email: "Ungültige E-Mail",
                    remote: "E-Mail bereits vorhanden"
			},
			d2_email1: {
                    required: "Diese Angabe wird benotigt",
                    email: "Ungültige E-Mail",
                    equalTo: "E-mail nicht überein"
			},
			d2_pass: {
               	required: "Diese Angabe wird benotigt",
			},
			d2_pass1: {
                    required: "Diese Angabe wird benotigt",
                    equalTo:  "Passwort nicht überein"
			}

          },
          // Where to place the error labels
		errorPlacement: function($error, $element){

			if ($element.hasClass('customfile-input-hidden')) {

			} else if ($element.hasClass('customfile-input-hidden')) {

				$error.insertAfter($element.parent().addClass('error'));

			// Password meter || Textarea || Spinner || Inline Datepicker || Checkbox || Radiobutton: No icon
			} else if ($element.is(':password.meter') || $element.is('textarea') || $element.is('.ui-spinner-input') || $element.is('input.mirror')) {

				$error.insertAfter($element);

			// Checkbox: No icon, after replacement
			} else if ($element.is(':checkbox') || $element.is(':radio')) {

				if ($element.is(':checkbox')) {
					$error.insertAfter($element.next().next());
				} else {
					// Find last radion button
					$error.insertAfter($('[name=' + $element[0].name + ']').last().next().next());
				}

			// Select: No icon, insert after select box replacement
			} else if ($element.is('select.chzn-done') || $element.is('.dualselects')) {

				$error.insertAfter($element.next());

			// Default: Insert after element, show icon
			} else {

				$error.insertAfter($element);

				// Show icon
				var $icon = $('<div class="error-icon icon" />').insertAfter($element).position({
					my: 'right',
					at: 'right',
					of: $element,
					offset: '-5 0',
					overflow: 'none',
					using: function(pos) {
						// Figure out the right and bottom css properties
						var offsetWidth = $(this).offsetParent().outerWidth();
						var right = offsetWidth - pos.left - $(this).outerWidth();

						// Position the element so that right and bottom are set.
						$(this).css({left: '', right: right, top: pos.top});
					}
				});

			}
		},
         success: function(element) {
               // Change icon from error to valid
			$(element).prev().filter('.error-icon').removeClass('error-icon').addClass('valid-icon');

			// If file input: remove 'error' from '.customfile'
			$(element).prev('.customfile').removeClass('error');
         },
         // Reposition error labels and hide unneeded labels
				showErrors: function(map, list){
					var self = this;

					this.defaultShowErrors();

					list.forEach(function(err){
						var $element = $(err.element),
							$error = self.errorsFor(err.element);

						// Select || Textarea || File Input || Inline Datepicker || Checkbox || Radio button: Inline Error Labels
						if ( $element.data('errorType') == 'inline' || $element.is('select') || $element.is('textarea') || $element.hasClass('customfile-input-hidden') || $element.is('input.mirror') || $element.is(':checkbox') || $element.is(':radio') || $element.is('.dualselect')) {

							// Get element to which the error label is aligned
							var $of;
							if ($element.is('select')) {
								$of = $element.next();
							} else if ($element.is(':checkbox') || $element.is(':radio')) {
								if ($element.is(':checkbox')) {
									$of = $element.next();
								} else {
									// Find last radio button
									$of = $('[name=' + $element[0].name + ']').last().next().next();
								}
								$error.css('display', 'block');
							} else if ($element.is('input.mirror')) {
								$of = $element.prev();
							} else {
								$of = $element;
							}

							$error.addClass('inline').position({
								my: 'left top',
								at: 'left bottom',
								of: $of,
								offset: '0 5',
								collision: 'none'
							});

							if (!($element.is(':checkbox') && $element.is(':radio'))) {
								$error.css('left', '');
							}

						// Default: Tooltip labels
						} else {

							$error.position({
								my: 'right top',
								at: 'right bottom',
								of: $element,
								offset: '1 8',
								using: function(pos) {
									// Figure out the right and bottom css properties
									var offsetWidth = $(this).offsetParent().outerWidth();
									var right = offsetWidth - pos.left - $(this).outerWidth();

									// Position the element so that right and bottom are set.
									$(this).css({left: '', right: right, top: pos.top});
								}
							});

						} // End if

						// Switch icon from valid to error
						$error.prev().filter('.valid-icon').removeClass('valid-icon').addClass('error-icon');

						// Hide error labe on .noerror
						if ($element.hasClass('noerror')) {
							$error.hide();
							$element.next('.icon').hide();
						}
					});

					// Hide success labels
					this.successList.forEach(function(el){
						self.errorsFor(el).hide();
					});

				}
     });
});
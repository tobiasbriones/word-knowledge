/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

let sendButton = null;
let canSendIt = false;

$(document).ready(onReady);

function onReady() {
  sendButton = $('[type=\'submit\']');
  
  sendButton.click(onSubmit);
  $('#information').focus(function() {
    $(this).css('border-bottom', '1px solid #283593');
    $(this).css('box-shadow', '0 1px 0 0 #283593');
    $('#information + label').css('color', '#3F51B5');
  });
  
  $('#information').focusout(function() {
    $(this).css('border-bottom', '1px solid #3f51b5');
    $(this).css('box-shadow', '0 1px 0 0 #3f51b5');
    $('#information + label').css('color', '#9E9E9E');
  });
}

function onSubmit(e) {
  if (!canSendIt) {
    const errors = $('#input_errors');
    
    e.preventDefault();
    errors.html('');
    checkUserExits(errors, function(exists) {
      if (!exists && validate(errors)) {
        canSendIt = true;
        
        sendButton.click();
      }
    });
  }
}

function validate(errors) {
  return checkForUser(errors)
    & checkForPassword(errors)
    & checkForAvatar(errors)
    & checkForInformation(errors);
}

function checkUserExits(errors, callback) {
  const userInput = $('#user');
  const trim = $.trim(userInput.val());
  const request = $.post('backend/ajax/check_user_exists.php', { 'user': trim });
  
  request.done(function(data) {
    if (data === 'false') {
      callback(false);
    }
    else if (data === 'true') {
      const msg = 'That username already exists';
      
      errors.html(errors.html() + paragraph(msg));
      callback(true);
    }
    else {
      errors.html(errors.html() + paragraph(data));
    }
  });
}

function checkForUser(errors) {
  const userInput = $('#user');
  const trim = $.trim(userInput.val());
  
  if (trim.length < 2) {
    const msg = 'Your user must have at least 2 characters';
    
    errors.html(errors.html() + paragraph(msg));
    return false;
  }
  if (trim.length > 25) {
    const msg = 'Your user must have a maximum of 25 characters';
    
    errors.html(errors.html() + paragraph(msg));
    return false;
  }
  if (trim.length !== userInput.val().length) {
    userInput.val(function() {
      return trim;
    });
    alert('Your username will be: ' + userInput.val());
  }
  return true;
}

function checkForPassword(errors) {
  const pw = $('#password');
  const cpw = $('#confirm_password');
  
  if (!(pw.val() === cpw.val())) {
    errors.html(errors.html() + paragraph('Passwords don\'t match'));
    return false;
  }
  if (pw.val().length < 6) {
    errors.html(errors.html() + paragraph('Passwords must have at least 6 characters'));
    return false;
  }
  if (pw.val().length > 50) {
    errors.html(errors.html() + paragraph('Passwords must have a maximum of 50 characters'));
    return false;
  }
  return true;
}

function checkForAvatar(errors) {
  const avatarInput = $('#avatar');
  const avatar = avatarInput.val();
  const extension = avatar.substring(avatar.lastIndexOf('.') + 1)
                          .toLowerCase();
  
  if (avatar === '') {
    return true;
  }
  if (!(extension === 'png' || extension === 'jpg')) {
    const msg = 'Check your avatar. Only png and jpg formats are allowed';
    
    errors.html(errors.html() + paragraph(msg));
    return false;
  }
  else if (avatarInput.files && avatarInput.files[0]) {
    if (avatarInput.files[0].size > 1000000) {
      const msg = 'Check your avatar. Maximum size allowed is 1MB';
      
      errors.html(errors.html() + paragraph(msg));
      return false;
    }
  }
  return true;
}

function checkForInformation(errors) {
  const info = $('#information').val();
  
  if (info.length > 300) {
    const msg = 'Your information must have a maximum of 300 characters';
    
    errors.html(errors.html() + paragraph(msg));
    return false;
  }
  return true;
}

function paragraph(text) {
  return '<p>' + text + '</p><br>';
}

/*
 User must be:
 - Trim
 - At least 2 characters length
 - Maximum of 25 characteres
 - Not exists in the database
 
 Password must be:
 - At least 6 characters lenght
 - Maximum of 50 characteres
 - Password and Confim matches
 
 Avatar must be:
 - 'PNG' or 'JPG' extension
 - Maximum of 1MB file size
 
 Information must be:
 - Maximum of 300 characters
 
 */

/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

let container = null;
let isMsgPaneOpen = false;
let isSmallSize = false;

$(document).ready(onReady);
$(window).on('resize', onResize);

function getReceiver() {
  const pageURL = decodeURIComponent(window.location.search.substring(1));
  const urlParams = pageURL.split('&');
  const param = 'user';
  
  for (let i = 0; i < urlParams.length; i++) {
    const paramName = urlParams[i].split('=');
    
    if (paramName[0] === param) {
      return paramName[1] === undefined ? true : paramName[1];
    }
  }
}

function onReady() {
  container = $('.container');
  isSmallSize = isSmall();
  const sendMsgAction = $('#action_send_msg');
  
  if (sendMsgAction.length) {
    sendMsgAction.click(onActionItem);
    $('#send_msg').click(function() {
      const rec = getReceiver();
      const msg = $('#msg').val();
      
      if ($.trim(msg).length === 0) {
        return;
      }
      
      const params = { 'msg': msg, 'receiver': rec };
      const request = $.post('backend/ajax/send_message.php', params);
      
      request.done(function(data) {
        const msg = $('#msg');
        
        if (data === 'false') {
          msg.val('Sorry, too many messages in this session');
          return;
        }
        msg.val('');
      });
    });
  }
}

function onResize() {
  if (isSmallSize !== isSmall()) {
    isSmallSize = isSmall();
    const pane = $('.msg-panel');
    
    if (isMsgPaneOpen) {
      if (isSmallSize) {
        container.css('transform', 'translateX(0%)');
      }
      else {
        pane.css('opacity', '1');
      }
      isMsgPaneOpen = false;
      showMessagePanel();
    }
  }
}

function onActionItem() {
  if (!isMsgPaneOpen) {
    showMessagePanel();
  }
  else {
    hideMessagePane();
  }
}

function showMessagePanel() {
  if (isMsgPaneOpen) return;
  isMsgPaneOpen = true;
  const pane = $('.msg-panel');
  
  if (!isSmall()) {
    pane.css('opacity', '1');
    pane.css('transform', 'translateX(0%)');
    container.css('transform', 'translateX(-20%)');
  }
  else {
    pane.css('display', 'block');
  }
}

function hideMessagePane() {
  if (!isMsgPaneOpen) return;
  isMsgPaneOpen = false;
  const pane = $('.msg-panel');
  
  if (!isSmall()) {
    pane.css('opacity', '0');
    pane.css('transform', 'translateX(100%)');
    container.css('transform', 'translateX(0%)');
  }
  else {
    pane.css('display', 'none');
  }
}

function isSmall() {
  return ($('body').width() < 1024);
}

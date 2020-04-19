/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

const uiManager = new UIManager();

$(document).on('ready', onReady);

// ------------------------------  CALLBACKS  ------------------------------- //
function onReady() {
  uiManager.init();
  loadPages();
}

function onLoad(mainPage, wkPage) {
  const place = getUrlParameter('go');
  
  uiManager.setPages(mainPage, wkPage);
  if (place === 'wk') {
    $('#mi-wk').triggerHandler('click');
  }
  else {
    $('#mi-main').triggerHandler('click');
  }
}

// ------------------------------  FUNCTIONS  ------------------------------- //
function loadPages() {
  const mainPage = new MainPage();
  const wkPage = new WKPage();
  const userParams = getUserParams();
  const indexRequest = $.post('backend/ajax/load_index.php', userParams);
  
  indexRequest.done(function(indexHTML) {
    const wkRequest = $.post('backend/ajax/load_wk.php', userParams);
    
    mainPage.html = indexHTML;
    wkRequest.done(function(wkHTML) {
      wkPage.html = wkHTML;
      onLoad(mainPage, wkPage);
    });
  });
}

function getUrlParameter(param) {
  const pageURL = decodeURIComponent(window.location.search.substring(1));
  const urlParams = pageURL.split('&');
  
  for (let i = 0; i < urlParams.length; i++) {
    const paramName = urlParams[i].split('=');
    
    if (paramName[0] === param) {
      return paramName[1] === undefined ? true : paramName[1];
    }
  }
}

function getUserParams() {
  const container = uiManager.container;
  const params = {};
  
  params['user'] = container.data('user');
  params['score'] = container.data('score');
  params['sgc'] = container.data('sgc');
  params['nm'] = container.data('nm');
  return params;
}

// -------------------------------  CLASSES  -------------------------------- //
function UIManager() {
  
  this.toolbar = null;
  this.container = null;
  this.mainPageManager = null;
  this.wkPageManager = null;
  const context = this;
  
  this.init = function() {
    this.toolbar = $('#toolbar');
    this.container = $('#container');
    const toolbarMenu = this.toolbar.find('.toolbar-menu');
    const preferences = new Preferences();
    
    toolbarMenu.find('.menu-item').each(function() {
      $(this).click(onMenuItem);
    });
    
    if (preferences.getPreference('cookies_user_agree', 'false') !== 'true') {
      const cookiesMsgEl = $('#cookies-msg');
      
      cookiesMsgEl.addClass('visible');
      cookiesMsgEl.find('span').on('click', () => {
        preferences.setPreference('cookies_user_agree', 'true');
        cookiesMsgEl.removeClass('visible');
      });
    }
  };
  
  this.setPages = function(mainPage, wkPage) {
    this.mainPageManager = new MainPageManager(mainPage, this.container);
    this.wkPageManager = new WKPageManager(wkPage, this.container);
  };
  
  // -----------------------------  LISTENERS  ------------------------------ //
  function onMenuItem() {
    const id = $(this).prop('id');
    let pageManager;
    
    switch (id) {
      case 'mi-main':
        pageManager = context.mainPageManager;
        break;
      
      case 'mi-wk':
        pageManager = context.wkPageManager;
        break;
      
    }
    setPage(pageManager);
  }
  
  // --------------------------  PRIVATE METHODS  --------------------------- //
  function setPage(pageManager) {
    const pageName = pageManager.page.name;
    const icon = context.toolbar.find('.logo-icon');
    const brand = context.toolbar.find('.brand-logo');
    let url = 'index.php';
    
    if (pageName === 'wk') {
      url += '?go=wk';
      icon.removeClass('app-icon');
      icon.addClass('wk-icon');
      brand.text('Word Knowledge');
      
    }
    else {
      icon.removeClass('wk-icon');
      icon.addClass('app-icon');
      brand.text('Main');
    }
    window.history.replaceState(null, '', url);
    pageManager.set();
  }
}

function MainPageManager(mainPage, container) {
  
  this.page = mainPage;
  this.mpManager = new MPManager(new MessagePanel());
  const context = this;
  
  this.page.container = container;
  this.page.onShowMessagePane = onShowMessagePane;
  
  this.set = function() {
    this.page.set();
    this.page.init();
    this.mpManager.init();
  };
  
  function onShowMessagePane() {
    const request = $.post('backend/ajax/get/user_messages.php');
    
    request.done(function(messages) {
      context.mpManager.messagesData = messages;
      
      context.mpManager.showPanel();
    });
  }
  
}

function MPManager(messagePanel) {
  
  this.panel = messagePanel;
  this.messagesData = null;
  const context = this;
  const preferences = new Preferences();
  let currentCI = null;
  
  this.panel.onConversationItem = onConversationItem;
  this.panel.onDismiss = onMPDismiss;
  this.panel.onOutputMessage = onOutputMessage;
  
  this.init = function() {
    this.panel.init();
  };
  
  this.showPanel = function() {
    const lci = preferences.getPreference('last_conversation');
    
    this.panel.setConversationItems(this.messagesData);
    this.panel.show();
    
    if (lci !== undefined) {
      const ciItem = context.panel.pane.find('[data-ci=\'' + lci + '\']');
      
      ciItem.triggerHandler('click');
    }
  };
  
  function onConversationItem(ci) {
    const messages = context.messagesData[ci]['messages'];
    currentCI = ci;
    
    preferences.setPreference('last_conversation', ci);
    context.panel.setMessages(messages);
  }
  
  function onMPDismiss() {
    context.messagesData = null;
    currentCI = null;
  }
  
  function onOutputMessage(msg) {
    const params = { 'msg': msg, 'receiver': currentCI };
    $.post('backend/ajax/send_message.php', params);
  }
  
}

function WKPageManager(wkPage, container) {
  
  this.page = wkPage;
  this.page.container = container;
  this.page.onCategory = onCategory;
  this.page.onSearch = onSearch;
  const context = this;
  
  this.set = function() {
    this.page.set();
    this.page.init();
  };
  
  function onCategory(category) {
    window.location.href = 'wk.php?c=' + category;
  }
  
  function onSearch(search) {
    if ($.trim(search).length === 0) {
      context.page.setSearch(null);
      return;
    }
    const params = { 'word': search };
    const request = $.post('backend/ajax/wk_search.php', params);
    
    request.done(function(data) {
      context.page.setSearch(data);
    });
  }
  
}

function MainPage() {
  
  this.name = 'main';
  this.html = null;
  this.container = null;
  this.onShowMessagePane = null;
  const context = this;
  
  this.set = function() {
    this.container.html(this.html);
  };
  
  this.init = function() {
    const msgButton = this.container.find('.msg');
    
    msgButton.click(onClick);
  };
  
  function onClick() {
    context.onShowMessagePane();
  }
  
}

function WKPage() {
  
  this.name = 'wk';
  this.html = null;
  this.container = null;
  this.onCategory = null;
  this.onSearch = null;
  const context = this;
  
  this.set = function() {
    this.container.html(this.html);
  };
  
  this.init = function() {
    this.container.find('*[data-cat]').each(function() {
      $(this).click(onClick);
    });
    this.container.find('#continue').click(onClick);
    this.container.find('#word-search').on('input', onInput);
  };
  
  this.setSearch = function(results) {
    const resultsPane = this.container.find('.wk-results');
    
    resultsPane.html('');
    if (results == null) {
      return;
    }
    $.each(results, function(category) {
      $.each(results[category], function() {
        resultsPane.html(resultsPane.html() + row(this['english'], this['spanish'], category));
      });
    });
    
    function row(english, spanish, category) {
      const pairHTML = `<span>${ english } <strong>-</strong> ${ spanish }</span>`;
      const categoryHTML = `<i>${ category }</i>`;
      return `
        <div class="row">
          ${ pairHTML }
          ${ categoryHTML }
        </div>
      `;
    }
    
  };
  
  function onClick() {
    const categoryId = $(this).data('cat');
    
    context.onCategory(categoryId);
  }
  
  function onInput() {
    const search = $(this).val();
    
    context.onSearch(search);
  }
  
}

function MessagePanel() {
  
  this.toolbar = null;
  this.pane = null;
  this.onConversationItem = null;
  this.onDismiss = null;
  this.onOutputMessage = null;
  const context = this;
  
  this.init = function() {
    this.toolbar = $('#msg_toolbar');
    this.pane = $('#msg-panel');
    
    this.toolbar.find('#msg_action_close').click(onDismiss);
    this.pane.find('#msg_field').keyup(function(e) {
      if (e.key === 'Enter') {
        const input = context.pane.find('#msg_field');
        const msg = input.val();
        
        if ($.trim(msg).length > 0) {
          input.val('');
          context.onOutputMessage(msg);
        }
      }
      
    });
    
  };
  
  this.show = function() {
    this.pane.css('display', 'block');
    
  };
  
  this.setConversationItems = function(messagesData) {
    const list = context.pane.find('.senders-list');
    
    list.html('');
    $.each(messagesData, function(conversationItem) {
      const isUnread = this['unread'];
      const attrs = 'class=\'' + getCIClasses(isUnread) + '\' data-ci=\'' + conversationItem + '\'';
      const span = '<span class=\'center\'>' + conversationItem + '</span>';
      const cItem = '<div ' + attrs + '>' + span + '</div>';
      
      list.html(list.html() + cItem);
    });
    $.each(list.find('.conversation-item'), function() {
      const ci = $(this);
      
      ci.click(onConversationItem);
    });
    
    function getCIClasses(unread) {
      let classes = 'conversation-item';
      
      if (unread) {
        classes += ' unread';
      }
      return classes;
    }
  };
  
  this.setMessages = function(messages) {
    const conversationPanel = context.pane.find('.conversation-panel');
    const height = conversationPanel.height();
    
    conversationPanel.html('');
    $.each(messages, function() {
      const messageHTML = getMessageHTML(this);
      
      conversationPanel.html(conversationPanel.html() + messageHTML);
    });
    conversationPanel.scrollTop(conversationPanel.prop('scrollHeight') - height);
    
    function getMessageHTML(messageItem) {
      const date = `<span>${ messageItem['date'] }</span>`;
      const content = `<p>${ messageItem['message'] }</p>`;
      let attrs = 'class=\'card-panel msg-item ';
      
      if (messageItem['messageType'] === 'input') {
        attrs += 'msg-input\'';
      }
      else if (messageItem['messageType'] === 'output') {
        attrs += 'msg-output\'';
      }
      else {
        return null;
      }
      return `<div ${ attrs }>${ content } ${ date }</div>`;
    }
    
  };
  
  function onConversationItem() {
    const ci = $(this).text();
    
    context.onConversationItem(ci);
  }
  
  function onDismiss() {
    context.pane.css('display', 'none');
    context.onDismiss();
  }
  
}

function Preferences() {
  
  this.setPreference = function(key, value) {
    Cookies.set(key, value, { expires: 365 * 10 });
  };
  
  this.getPreference = function(key, def) {
    const pref = Cookies.get(key);
    
    return (pref !== undefined) ? pref : def;
  };
  
}

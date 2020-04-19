/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

const menuManager = new MenuManager();
const uiManager = new UIManager();
const preferences = new Preferences();
let categoryManager = null;
let mode = null;
let order = null;
let isRequestOpen = false;
let isInitialized = false;

$(document).on('ready', onReady);
$(document).on('resize', onResize);
//$(window).on("beforeunload", onBeforeUnload);

$(document).ajaxError(function(event, jqxhr, settings, thrownError) {
  console.log('Error: ' + thrownError);
});

// ------------------------------  CALLBACKS  ------------------------------- //
function onReady() {
  const toolbar = $('#toolbar');
  const content = $('.content');
  const id = content.data('category');
  
  categoryManager = new CategoryManager(id, onLoadData);
  mode = preferences.getPreference('mode', 'game');
  order = preferences.getPreference('order', 'impartial');
  
  $('#action_options').click(onActionItem);
  $('#action_add').click(onActionItem);
  
  menuManager.setToolbar(toolbar);
  menuManager.setOnMenuShow(onMenuShow);
  menuManager.setOnMenuHide(onMenuHide);
  menuManager.setOnMenuItem(onMenuItem);
  menuManager.setOnSCShow(onSCShow);
  menuManager.setOnSubcategory(onSubcategory);
  
  //categoryManager.loadData();
}

function onResize() {
  $('#toolbar').css('height', getToolbarHeight() + 'px');
}

function onLoadData() {
  if (!isInitialized) {
    restoreState();
    isInitialized = true;
  }
  update();
}

function onActionItem() {
  const id = $(this).attr('id');
  
  switch (id) {
    case 'action_options':
      if (!menu.isMenuOpen) {
        menu.showMenu();
      }
      else {
        menu.hideMenu();
      }
      break;
    
    case 'action_add':
      if (!isRequestOpen) {
        showRequestPane();
      }
      else {
        hideRequestPane();
      }
      break;
  }
}

function onMenuItem(item) {
  switch (item) {
    case 'mode_game':
      mode = 'game';
      
      preferences.setPreference('mode', 'game');
      update();
      break;
    
    case 'mode_study':
      mode = 'study';
      
      preferences.setPreference('mode', 'study');
      update();
      break;
    
    case 'order_impartial':
      order = 'impartial';
      
      preferences.setPreference('order', 'impartial');
      categoryManager.filter(null);
      update();
      break;
    
    case 'order_subcategories':
      order = 'subcategories';
      
      preferences.setPreference('order', 'subcategories');
      break;
  }
}

function onMenuShow() {
  preferences.setPreference('menu', true);
}

function onMenuHide() {
  preferences.setPreference('menu', false);
}

function onSCShow() {
  const sc = preferences.getPreference('sc', categoryManager.subcategories[0], categoryManager.id);
  const scItem = $('[data-sc=\'' + sc + '\']');
  
  scItem.triggerHandler('click');
}

function onSubcategory(subcategory) {
  preferences.setPreference('sc', subcategory, categoryManager.id);
  categoryManager.filter(subcategory);
  update();
}

function onCorrectAnswer(id, fails) {
  const params = { 'category': categoryManager.id, 'pair': id, 'fails': fails };
  const request = $.post('ajax/check_point.php', params);
  
  request.done(function(data) {//console.log(data)
    const saveRequest = $.post('ajax/save_check_points.php');
    
    categoryManager.removePair(id);
    saveRequest.done(function(data) {
      console.log(data);
    });
  });
}

function onFinish() {
  if (order === 'impartial') {
    congrats();
  }
  else {
    nextSC();
  }
}

// ------------------------------  FUNCTIONS  ------------------------------- //
function restoreState() {
  const openMenu = preferences.getPreference('menu', 'false');
  const modeCb = (mode === 'game') ? $('#mode_game') : $('#mode_study');
  const orderCb = (order === 'impartial') ? $('#order_impartial') : $('#order_subcategories');
  
  if (openMenu === 'true') {
    menu.showMenu();
  }
  modeCb.triggerHandler('change');
  orderCb.triggerHandler('change');
}

function update() {
  if (!isInitialized) return;
  console.log('Updating');
  const pairs = categoryManager.getPairs();
  
  if (pairs.length === 0) {
    if (order === 'subcategories') {
      console.log('NextSC');
      nextSC();
    }
    else {
      congrats();
    }
    return;
  }
  manager.start(pairs, mode);
}

function nextSC() {
  console.log('NSC empty: ' + categoryManager.isEmpty());
  if (categoryManager.isEmpty()) {
    congrats();
    return;
  }
  categoryManager.nextSC();
  const scItem = $('[data-sc=\'' + categoryManager.subcategory + '\']');
  
  scItem.triggerHandler('click');
}

function showRequestPane() {
  const params = { 'category': categoryManager.id };
  const request = $.post('ajax/request_panel.php', params);
  const pane = $('#request_pane');
  isRequestOpen = true;
  
  pane.css('display', 'block');
  request.done(function(panel) {
    pane.html(panel);
    pane.css('opacity', '1');
    pane.css('transform', 'translateY(0%)');
    
    $('.close').click(function() {
      hideRequestPane();
    });
    
    $('.make-sample').click(function() {
      const field = pane.find('textarea').first();
      
      field.focus();
      field.val('bedroom-cuarto, living room-sala, kitchen-cocina');
    });
    
    $('#send_req').click(function() {
      const form = $('#request_form');
      const date = new Date();
      let current = date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear() + ' ';
      
      current += date.getHours() + ':' + date.getMinutes();
      form.attr('action', 'process/word_requests.php?date=' + current);
      form.submit();
    });
  });
}

function hideRequestPane() {
  const pane = $('#request_pane');
  isRequestOpen = false;
  
  pane.css('opacity', '0');
  pane.css('transform', 'translateY(-100%)');
  setTimeout(function() {
    pane.html('');
    pane.css('display', 'none');
  }, 800);
}

function getToolbarHeight() {
  return ($('body').width() <= 600) ? 56 : 64;
}

function congrats() {
  const request = $.post('ajax/congrats.php', { 'category': categoryManager.id });
  
  request.done(function(congrats) {
    $('.content').html(congrats);
    
    const back = $('.score-back');
    const score = $('.score');
    const width = back.height();
    
    back.css('width', width);
    score.css('width', width);
    
    back.css('transition', 'all 1s');
    back.css('transform', 'rotate(-360deg)');
    setTimeout(function() {
      back.css('transition', 'all 2s');
      animate();
    }, 1000);
    
    function animate() {
      let ang = -440;
      
      back.css('transform', 'rotate(' + ang + 'deg)');
      setInterval(function() {
        ang -= 180;
        back.css('transform', 'rotate(' + ang + 'deg)');
      }, 2000);
    }
  });
}

// -------------------------------  CLASSES  -------------------------------- //
function CategoryManager(id, onLoadData) {
  
  this.id = id;
  this.onLoadData = onLoadData;
  this.subcategories = null;
  this.subcategory = null;
  this.pairs = null;
  const context = this;
  
  this.loadData = function() {
    const params = { 'category': this.id };
    const request = $.post('ajax/category_retriver.php', params);
    
    request.done(function(data) {
      context.subcategories = data['subcategories'];
      context.pairs = data['pairs'];
      context.onLoadData();
    });
  };
  
  this.filter = function(subcategory) {
    this.subcategory = subcategory;
  };
  
  this.nextSC = function() {
    if (this.subcategory == null) {
      return;
    }
    let found = false;
    
    $.each(this.subcategories, function() {
      if (found) {
        context.subcategory = this;
        return;
      }
      if (this === context.subcategory) {
        found = true;
      }
    });
    if (!found) {
      context.subcategory = null;
    }
  };
  
  this.getPairs = function() {
    if (this.subcategory == null) {
      return this.pairs;
    }
    const filterPairs = [];
    
    $.each(this.pairs, function() {
      if (this['subcategory'] === context.subcategory) {
        filterPairs.push(this);
      }
    });
    return filterPairs;
  };
  
  this.removePair = function(id) {
    $.each(this.pairs, function(i) {
      if (this['id'] === id) {
        context.pairs.splice(i, 1);
        return false;
      }
    });
  };
  
  this.isEmpty = function() {
    return this.pairs.length === 0;
  };
  
}

function MenuManager() {
  
  this.toolbar = undefined;
  this.menu = undefined;
  this.isMenuOpen = false;
  this.isSCOpen = false;
  const context = this;
  
  this.setToolbar = function(toolbar) {
    this.toolbar = toolbar;
    this.menu = this.toolbar.find('.toolbar-menu');
    
    this.menu.find('#mode_game').change(onMenuItemClick);
    this.menu.find('#mode_study').change(onMenuItemClick);
    this.menu.find('#order_impartial').change(onMenuItemClick);
    this.menu.find('#order_subcategories').change(onMenuItemClick);
    $('.cell').each(function(i) {
      $(this).click(onSubcategoryClick);
    });
  };
  
  this.setOnMenuShow = function(onMenuShow) {
    this.onMenuShow = onMenuShow;
  };
  
  this.setOnMenuHide = function(onMenuHide) {
    this.onMenuHide = onMenuHide;
  };
  
  this.setOnSCShow = function(onSCShow) {
    this.onSCShow = onSCShow;
  };
  
  this.setOnSCHide = function(onSCHide) {
    this.onSCHide = onSCHide;
  };
  
  this.setOnMenuItem = function(onMenuItem) {
    this.onMenuItem = onMenuItem;
  };
  
  this.setOnSubcategory = function(onSubcategory) {
    this.onSubcategory = onSubcategory;
  };
  
  this.showMenu = function() {
    if (!this.isMenuOpen) {
      this.isMenuOpen = true;
      const toolbarHeight = this.getToolbarHeight() + this.menu.height();
      
      this.toolbar.css('height', toolbarHeight + 'px');
      this.menu.css('transform', 'translateY(0%)');
      
      if ($('#order_subcategories').prop('checked')) {
        setTimeout(function() {
          context.showSC();
        }, 300);
      }
    }
    if (context.onMenuShow !== undefined) {
      context.onMenuShow();
    }
  };
  
  this.showSC = function() {
    if (this.isMenuOpen) {
      this.isSCOpen = true;
      const menuHeight = this.menu.height();
      const toolbarHeight = this.getToolbarHeight() + menuHeight + 200;
      const pointY = 'calc(0% + ' + menuHeight + 'px)';
      const translate = 'translate(0%, ' + pointY + ')';
      
      this.toolbar.css('height', toolbarHeight + 'px');
      $('.subcategories').css('transform', translate);
    }
    if (context.onSCShow !== undefined) {
      context.onSCShow();
    }
  };
  
  this.hideMenu = function() {
    if (this.isMenuOpen) {
      if (this.isSCOpen) {
        this.hideSC();
        setTimeout(function() {
          context.hideMenu();
        }, 600);
        return;
      }
      this.isMenuOpen = false;
      
      this.toolbar.css('height', this.getToolbarHeight() + 'px');
      this.menu.css('transform', 'translateY(-100%)');
    }
    if (context.onMenuHide !== undefined) {
      context.onMenuHide();
    }
  };
  
  this.hideSC = function() {
    this.isSCOpen = false;
    const toolbarHeight = this.getToolbarHeight() + this.menu.height();
    
    this.toolbar.css('height', toolbarHeight + 'px');
    $('.subcategories').css('transform', 'translate(-100%, calc(-100% + 64px))');
    
    if (context.onSCHide !== undefined) {
      context.onSCHide();
    }
  };
  
  this.getToolbarHeight = function() {
    return ($('body').width() <= 600) ? 56 : 64;
  };
  
  // -----------------------------  LISTENERS  ------------------------------ //
  function onMenuItemClick() {
    const item = $(this);
    const id = item.prop('id');
    
    item.prop('checked', true);
    $('#' + item.data('group')).prop('checked', false);
    
    if (context.onMenuItem !== undefined) {
      context.onMenuItem(id);
    }
    if (id === 'order_impartial') {
      context.hideSC();
    }
    else if (id === 'order_subcategories') {
      context.showSC();
    }
  }
  
  function onSubcategoryClick() {
    const scItem = $(this);
    const subcategory = scItem.data('sc');
    
    $('.sc-selected').removeClass('sc-selected');
    
    scItem.addClass('sc-selected');
    if (context.onSubcategory !== undefined) {
      context.onSubcategory(subcategory);
    }
  }
  
}

function UIManager() {
  
  this.container = undefined;
  this.onCorrectAnswer = undefined;
  this.onFinish = undefined;
  this.mode = null;
  this.remaining = -1;
  const context = this;
  
  this.start = function(data, mode) {
    this.mode = mode;
    this.remaining = data.length;
    const html = (mode === 'game') ? Manager.getGameHTML(data) : Manager.getStudyHTML(data);
    
    this.container.html(html);
    ready(this.container, this.mode);
  };
  
  this.setContainer = function(container) {
    this.container = container;
  };
  
  this.setOnCorrectAnswer = function(onCorrectAnswer) {
    this.onCorrectAnswer = onCorrectAnswer;
  };
  
  this.setOnFinish = function(onFinish) {
    this.onFinish = onFinish;
  };
  
  function ready(container, mode) {
    if (mode === 'game') {
      const pairs = container.find('.pair');
      
      $.each(pairs, function(i) {
        const options = $(this).find('.option');
        
        $.each(options, function(i) {
          $(this).click(onOptionSelected);
        });
      });
    }
  }
  
  function onOptionSelected() {
    const option = $(this);
    const id = option.data('id');
    const pair = $('#' + id);
    
    if (option.data('correct')) {
      const wrongs = pair.find('[data-correct=false]');
      const fails = pair.data('fails');
      
      $.each(wrongs, function(i) {
        $(this).off('click');
        $(this).addClass('gone');
      });
      option.off('click');
      context.remaining--;
      context.onCorrectAnswer(id, fails);
      
      if (context.remaining === 0) {
        context.onFinish();
      }
    }
    else {
      pair.data('fails', pair.data('fails') + 1);
      option.css('transform', 'rotate(-0.6deg) scale(0.95, 0.95)');
      
      setTimeout(function() {
        option.css('transform', 'rotate(1.2deg)');
        setTimeout(function() {
          option.css('transform', 'rotate(0deg)');
        }, 200);
      }, 200);
    }
  }
  
  Manager.getGameHTML = function(data) {
    let pairs = '';
    
    $.each(data, function(i) {
      pairs += getPair(this);
    });
    return pairs;
    
    function getPair(data) {
      const spanish = '<span class=\'spanish\'>' + data['spanish'] + '</span>';
      const options = getOptions(data['id'], data['english'], data['wrongs']);
      let pairHTML = '<div id=\'' + data['id'] + '\' class=\'pair\' data-fails=\'0\'>';
      
      pairHTML += spanish + options + '</div>';
      return pairHTML;
    }
    
    function getOptions(id, correct, wrongs) {
      const pos = Math.floor((Math.random() * 3));
      let optionsHTML = '<div class=\'options\'>';
      let optionHTML = null;
      
      for (let i = 0, w = 0; i < 3; i++) {
        let attrs = 'class=\'card-panel option\' data-id=\'' + id + '\' ';
        
        if (pos === i) {
          attrs += 'data-correct=\'true\'';
          optionHTML = '<div ' + attrs + '><span class=\'center\'>' + correct + '</span></div>';
        }
        else {
          attrs += 'data-correct=\'false\'';
          optionHTML = '<div ' + attrs + '><span class=\'center\'>' + wrongs[w] + '</span></div>';
          w++;
        }
        optionsHTML += optionHTML;
      }
      optionsHTML += '</div>';
      return optionsHTML;
    }
  };
  
  Manager.getStudyHTML = function(data) {
    const items = [];
    const sc = [];
    let html = '';
    
    $.each(data, function(i) {
      const subcategory = this['subcategory'];
      const item = getItem(this);
      let scPos = $.inArray(subcategory, sc);
      
      if (scPos === -1) {
        sc.push(subcategory);
        scPos = $.inArray(subcategory, sc);
        items[scPos] = [];
      }
      items[scPos].push(item);
    });
    items.sort();
    
    $.each(sc, function(i) {
      const words = items[i];
      html += '<div class=\'study-sc\'><p>' + this + '</p>';
      
      $.each(words, function() {
        html += this;
      });
      html += '</div>';
    });
    //return html;
    return 'Working...';
    
    function getItem(data) {
      //var content = "<span>" + data["english"] + " - " + data["spanish"] + "<span>";
      const english = '<span class=\'english\'>' + data['english'] + '</span>';
      const spanish = '<span class=\'spanish\'>' + data['spanish'] + '</span>';
      let item = '<div class=\'study-item\'>';
      
      //item += content + "<div>";
      item += english + spanish + '</div>';
      return item;
      
    }
  };
  
}

function Preferences() {
  
  this.setPreference = function(key, value, place) {
    let cookieKey;
    
    if (place != null) {
      cookieKey = place + '_' + key;
    }
    else {
      cookieKey = key;
    }
    Cookies.set(cookieKey, value, { expires: 365 * 10 });
  };
  
  this.getPreference = function(key, def, place = null) {
    let pref;
    
    if (place != null) {
      pref = Cookies.get(place + '_' + key);
    }
    else {
      pref = Cookies.get(key);
    }
    return (pref !== undefined) ? pref : def;
  };
  
}

/*
 
 RESTORE
 Item 						Type access
 
 - Menu 						GLOBAL
 -
 
 */
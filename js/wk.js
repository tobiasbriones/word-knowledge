/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

const uiManager = new UIManager();
let category = -1;

$(document).ready(onReady);
$(window).on('resize', onResize);
$(window).on('beforeunload', onBeforeUnload);

// ------------------------------  CALLBACKS  ------------------------------- //
function onReady() {
  category = $('.content').data('category');
  
  uiManager.init(category);
  loadData();
}

function onResize() {
  if (!uiManager.toolbar.isMenuOpen) {
    uiManager.toolbar.toolbar.css('height', UIManager.getToolbarHeight() + 'px');
  }
}

function onBeforeUnload() {
  uiManager.pairsHandler.sendCPS();
}

// ------------------------------  FUNCTIONS  ------------------------------- //
function loadData() {
  const params = { 'category': category };
  const request = $.post('backend/ajax/get/wk/data.php', params);
  
  request.done(function(data) {
    uiManager.onLoadData(data);
  });
}

// -------------------------------  CLASSES  -------------------------------- //
function UIManager() {
  
  this.toolbar = new Toolbar();
  this.content = new Content();
  this.pairsHandler = new PairsHandler(this);
  this.mode = null;
  this.order = null;
  this.subcategory = null;
  this.categoryId = -1;
  const context = this;
  const preferences = new Preferences();
  const gameLoader = new GameLoader();
  
  this.init = function(categoryId) {
    const toolbar = $('#toolbar');
    const content = $('.container .content');
    this.categoryId = categoryId;
    
    this.pairsHandler.categoryId = categoryId;
    
    this.toolbar.init(toolbar);
    this.content.init(content);
    
    this.pairsHandler.onCorrect = onCorrect;
    this.pairsHandler.onFinish = onFinish;
    this.toolbar.onMenuShow = onMenuShow;
    this.toolbar.onMenuHide = onMenuHide;
    this.toolbar.onSCShow = onSCShow;
    this.toolbar.onModeChange = onModeChange;
    this.toolbar.onOrderChange = onOrderChange;
    this.toolbar.onSubcategory = onSubcategory;
    restore();
  };
  
  function restore() {
    const menuOpen = preferences.getPreference('menu', 'false', context.categoryId);
    const mode = preferences.getPreference('mode', 'game', context.categoryId);
    const order = preferences.getPreference('order', 'impartial', context.categoryId);
    const modeItem = (mode === 'game') ? $('#mode_game') : $('#mode_study');
    const orderItem = (order === 'impartial') ? $('#order_impartial') : $('#order_subcategories');
    
    if (menuOpen === 'true') {
      context.toolbar.showMenu();
    }
    modeItem.triggerHandler('change');
    orderItem.triggerHandler('change');
  }
  
  // -----------------------------  LISTENERS  ------------------------------ //
  this.onLoadData = function(data) {
    const gameContainer = context.content.gameContainer;
    const gameData = data['game'];
    const studyHTML = data['study'];
    this.pairsHandler.subcategories = gameData['subcategories'];
    
    gameLoader.init(gameContainer, this.pairsHandler, gameData);
    gameLoader.load(context.subcategory);
    
    context.content.studyContainer.html(studyHTML);
    context.content.setContentView(context.mode);
  };
  
  // Toolbar & Menu
  function onMenuShow() {
    preferences.setPreference('menu', 'true', context.categoryId);
  }
  
  function onMenuHide() {
    preferences.setPreference('menu', 'false', context.categoryId);
  }
  
  function onSCShow() {
    const subcategories = context.toolbar.sc;
    const def = subcategories.find('li')
                             .first()
                             .data('sc');
    const sc = preferences.getPreference('sc', def, context.categoryId);
    const scItem = subcategories.find('[data-sc=\'' + sc + '\']');
    
    scItem.triggerHandler('click');
  }
  
  function onModeChange(mode) {
    context.mode = mode;
    
    preferences.setPreference('mode', mode, context.categoryId);
    if (context.mode === 'game') {
      gameLoader.load(context.subcategory);
    }
    context.content.setContentView(context.mode);
  }
  
  function onOrderChange(order) {
    context.order = order;
    
    preferences.setPreference('order', order, context.categoryId);
    // If it's subcategories order, it will be load later
    // on 'onSubcategory'
    if (order === 'impartial') {
      context.subcategory = null;
      gameLoader.load(null);
    }
  }
  
  function onSubcategory(subcategory) {
    context.subcategory = subcategory;
    
    preferences.setPreference('sc', subcategory, context.categoryId);
    gameLoader.load(context.subcategory);
  }
  
  function onCorrect(id) {
    gameLoader.data['cps'].push(String(id));
  }
  
  function onFinish() {
    const params = { 'category': context.categoryId };
    const request = $.post('backend/ajax/get/wk/congrats.php', params);
    
    request.done(function(congratsHTML) {
      const gameContainer = context.content.gameContainer;
      
      gameContainer.html(congratsHTML);
      gameContainer.find('.cgt-opts button').click(function() {
        const params = { 'category': context.categoryId };
        const request = $.post('backend/ajax/wk/reset.php', params);
        
        request.done(function() {
          window.location.reload();
        });
      });
    });
  }
  
  // ---------------------------  STATIC METHODS  --------------------------- //
  UIManager.getToolbarHeight = function() {
    return ($('body').width() <= 600) ? 56 : 64;
  };
  
}

function GameLoader() {
  
  this.gameContainer = null;
  this.pairsHandler = null;
  this.data = null;
  
  this.init = function(gameContainer, pairsHandler, data) {
    this.gameContainer = gameContainer;
    this.pairsHandler = pairsHandler;
    this.data = data;
  };
  
  this.load = function(subcategory) {
    if (this.data == null) return;
    const pairs = this.data['pairs'];
    const cps = this.data['cps'];
    const selection = (subcategory == null) ? pairs : [];
    let pairsHTML = '';
    
    if (subcategory != null) {
      $.each(pairs, function() {
        if (this['subcategory'] === subcategory) {
          selection.push(this);
        }
      });
    }
    const length = selection.length;
    
    shuffle(selection);
    $.each(selection, function() {
      if ($.inArray(this['id'], cps) === -1) {
        pairsHTML += buildPair(this, selection, length);
      }
    });
    this.gameContainer.html(pairsHTML);
    this.pairsHandler.updateCallback(this.gameContainer.find('.pair'));
  };
  
  function shuffle(array) {
    let currentIndex = array.length;
    let temporaryValue;
    let randomIndex;
    
    // While there remain elements to shuffle...
    while (0 !== currentIndex) {
      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;
      
      // And swap it with the current element.
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }
    return array;
  }
  
  function buildPair(pair, selection, length) {
    let pairHTML = '<div class=\'pair\' data-id=\'' + pair['id'] + '\' data-fails=\'0\' data-done=\'false\'>';
    let optionsHTML = '<div class=\'pair-options\'>';
    const options = getOptions();
    const rightAnswer = String(pair['english']);
    
    pairHTML += '<span>' + pair['spanish'] + '</span>';
    $.each(options, function() {
      const correct = (String(this) === rightAnswer) ? 'true' : 'false';
      
      optionsHTML += '<div class=\'card-panel blue-grey unselectable\' data-correct=\'' + correct + '\'>';
      optionsHTML += '<span>' + this + '</span></div>';
    });
    console.log("...................");
    optionsHTML += '</div>';
    pairHTML += optionsHTML + '</div>';
    return pairHTML;
    
    function getOptions() {
      const options = [];
      const right = pair['english'];
      const rightPos = getRandomInt(0, 3);
      const wrongs = [];
      
      do {
        wrongs[0] = selection[getRandomInt(0, length)]['english'];
        wrongs[1] = selection[getRandomInt(0, length)]['english'];
      }
      while ((wrongs[0] === right) || (wrongs[0] === wrongs[1]));
      
      for (let i = 0, w = 0; i < 3; i++) {
        if (i === rightPos) {
          options[i] = right;
          continue;
        }
        options.push(wrongs[w]);
        w++;
      }
      return options;
    }
    
    // Max EXCLUDED
    function getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    }
    
  }
  
}

function Toolbar() {
  
  // toolbar = toolbar html element
  this.toolbar = null;
  this.menu = null;
  this.sc = null;
  this.isMenuOpen = false;
  this.isSCOpen = false;
  this.onMenuShow = null;
  this.onMenuHide = null;
  this.onSCShow = null;
  this.onSCHide = null;
  this.onModeChange = null;
  this.onOrderChange = null;
  this.onSubcategory = null;
  const context = this;
  
  this.init = function(toolbar) {
    this.toolbar = toolbar;
    this.menu = this.toolbar.find('.toolbar-menu');
    this.sc = $('#subcategories');
    
    this.toolbar.find('#action_options').click(onAction);
    this.toolbar.find('#action_add').click(onAction);
    this.menu.find('#mode_game').change(onMenuItem);
    this.menu.find('#mode_study').change(onMenuItem);
    this.menu.find('#order_impartial').change(onMenuItem);
    this.menu.find('#order_subcategories').change(onMenuItem);
    this.sc.find('li').each(function() {
      $(this).click(onSubcategory);
    });
  };
  
  this.showMenu = function() {
    if (this.isMenuOpen) return;
    this.isMenuOpen = true;
    const toolbarHeight = UIManager.getToolbarHeight() + this.menu.height();
    
    this.toolbar.css('height', toolbarHeight + 'px');
    this.menu.css('transform', 'translateY(0%)');
    
    if (isBig()) {
      this.sc.css('transform', 'translateY(110px)');
    }
    if (this.onMenuShow != null) {
      this.onMenuShow();
    }
  };
  
  this.showSC = function() {
    if (this.isSCOpen) return;
    this.isSCOpen = true;
    
    this.sc.css('display', 'block');
    if (this.onSCShow != null) {
      this.onSCShow();
    }
  };
  
  this.hideMenu = function() {
    if (!this.isMenuOpen) return;
    this.isMenuOpen = false;
    
    this.toolbar.css('height', UIManager.getToolbarHeight() + 'px');
    this.menu.css('transform', 'translateY(-100%)');
    this.sc.css('transform', 'translateY(0px)');
    
    if (this.onMenuHide != null) {
      this.onMenuHide();
    }
  };
  
  this.hideSC = function() {
    if (!this.isSCOpen) return;
    this.isSCOpen = false;
    
    this.sc.css('display', 'none');
    if (this.onSCHide != null) {
      this.onSCHide();
    }
  };
  
  // -----------------------------  LISTENERS  ------------------------------ //
  function onAction() {
    const id = $(this).prop('id');
    
    switch (id) {
      case 'action_options':
        if (!context.isMenuOpen) {
          context.showMenu();
        }
        else {
          context.hideMenu();
        }
        break;
    }
  }
  
  function onMenuItem() {
    const item = $(this);
    const id = item.prop('id');
    
    item.prop('checked', true);
    $('#' + item.data('group')).prop('checked', false);
    
    switch (id) {
      case 'mode_game':
        if (context.onModeChange != null) {
          context.onModeChange('game');
        }
        break;
      
      case 'mode_study':
        if (context.onModeChange != null) {
          context.onModeChange('study');
        }
        break;
      
      case 'order_impartial':
        if (context.onOrderChange != null) {
          context.onOrderChange('impartial');
        }
        context.hideSC();
        break;
      
      case 'order_subcategories':
        if (context.onOrderChange != null) {
          context.onOrderChange('subcategories');
        }
        context.showSC();
        break;
    }
  }
  
  function onSubcategory() {
    const scItem = $(this);
    const subcategory = scItem.data('sc');
    
    $('.sc-selected').removeClass('sc-selected');
    
    scItem.addClass('sc-selected');
    if (context.onSubcategory != null) {
      context.onSubcategory(subcategory);
    }
  }
  
  function isBig() {
    return $('body').width() >= 1300;
  }
  
}

function Content() {
  
  this.content = null;
  this.gameContainer = null;
  this.studyContainer = null;
  
  this.init = function(content) {
    this.content = content;
    this.gameContainer = this.content.find('.game');
    this.studyContainer = this.content.find('.study');
  };
  
  this.setContentView = function(contentView) {
    if (contentView === 'game') {
      this.studyContainer.css('display', 'none');
      this.gameContainer.css('display', 'block');
    }
    else {
      this.gameContainer.css('display', 'none');
      this.studyContainer.css('display', 'block');
    }
  };
  
}

function PairsHandler(uiManager) {
  
  this.uiManager = uiManager;
  this.subcategories = null;
  this.onCorrect = null;
  this.onFinish = null;
  this.categoryId = -1;
  const context = this;
  const cps = [];
  
  this.updateCallback = function(pairs) {
    if (pairs.length === 0) {
      onFinish();
      return;
    }
    pairs.each(function() {
      const options = $(this).find('.pair-options > div');
      
      options.each(function() {
        $(this).click(onOptionClick);
      });
    });
  };
  
  this.sendCPS = function() {
    if (cps.length === 0) return;
    const params = { 'category': this.categoryId, 'cps': cps };
    
    $.ajax(
      {
        type: 'POST',
        url: 'ajax/wk/save.php',
        data: params,
        async: false
      }
    );
  };
  
  // -----------------------------  LISTENERS  ------------------------------ //
  function onOptionClick() {
    const option = $(this);
    const pair = option.parent().parent();
    const isCorrect = option.data('correct');
    const fails = pair.data('fails');
    
    if (isCorrect === true) {
      const pairId = pair.data('id');
      
      pair.find('.pair-options > div').each(function() {
        const optionItem = $(this);
  
        optionItem.off('click');
        if (optionItem.data('correct')) {
          optionItem.addClass('correct');
        }
        else {
          optionItem.addClass('gone');
        }
      });
      pair.attr('data-done', 'true');
      save(pairId, fails);
      context.onCorrect(pairId);
    }
    else {
      pair.data('fails', fails + 1);
      option.css('transform', 'rotate(-0.5deg)');
      
      setTimeout(function() {
        option.css('transform', 'rotate(1deg)');
        
        setTimeout(function() {
          option.css('transform', 'rotate(0deg)');
        }, 200);
      }, 200);
    }
    const remaining = $('.pair[data-done=false]');
    
    if (remaining.length === 0) {
      onFinish();
    }
  }
  
  function onFinish() {
    const currentSC = this.uiManager.subcategory;
    
    if (currentSC == null) {
      sendCPS(function() {
        context.onFinish();
      });
    }
    else {
      let found = false;
      let nextSC = null;
      
      $.each(context.subcategories, function() {
        if (found) {
          nextSC = this;
          return false;
        }
        if (this === currentSC) {
          found = true;
        }
      });
      
      if (nextSC == null) {
        console.log('finish');
      }
      else {
        const sc = this.uiManager.toolbar.sc;
        const scItem = sc.find('li[data-sc=\'' + nextSC + '\']');
        
        scItem.triggerHandler('click');
      }
    }
  }
  
  function save(pairId, fails) {
    const cp = { 'pair': pairId, 'fails': fails };
    
    cps.push(cp);
  }
  
  function sendCPS(callback) {
    const params = { 'category': this.categoryId, 'cps': cps };
    const request = $.post('backend/ajax/wk/save.php', params);
    
    request.done(function() {
      callback();
    });
  }
  
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
  
  this.getPreference = function(key, def, place) {
    let pref;
    
    if (place !== undefined) {
      pref = Cookies.get(place + '_' + key);
    }
    else {
      pref = Cookies.get(key);
    }
    return (pref !== undefined) ? pref : def;
  };
  
}

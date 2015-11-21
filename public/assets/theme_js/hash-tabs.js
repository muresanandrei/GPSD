/*! hash-tabs - v1.0.0 - 2014-06-09
* https://github.com/srsgores/hash-tabs
* Copyright (c) 2014 Sean Goresht; Licensed MIT */
(function(){var a=[].slice;!function(b,c){var d;return d=function(){function d(a,c){if(this.options=b.extend({},this.defaults,c),this.$selector=b(a),this.$selector.length<1)throw new ReferenceError("The selector passed in does not contain any items");this.generateTabs(this.$selector),this.options.debug===!0&&console.dir(this.$selector)}return d.prototype.defaults={tabPanelSelector:"section",tabNavSelector:"nav",tabButtonSelector:"a",initialTabIndex:0,initialTabId:null,tabContainerClass:"hash-tabs",keyboard:!0,smoothScroll:{enabled:!1,offset:100,duration:1e3},history:!0,debug:!1},d.prototype.generateTabs=function(a){var c;return a.addClass(this.options.tabContainerClass),this.$tabNav=a.find(this.options.tabNavSelector).attr({role:"tablist"}),this.$contentPanes=a.find(this.options.tabPanelSelector),c=this,this.$tabButtons=this.$tabNav.find(this.options.tabButtonSelector).each(function(a){var d;return b(this).attr({id:a,role:"tab","aria-selected":!1,"aria-expanded":!1,"aria-controls":b(this)[0].hash,"tab-index":-1}),d=c.$contentPanes.filter(b(this)[0].hash),d[0].correspondingTabButton=b(this),b(this)[0].index=a,b(this)[0].correspondingTabContent=d}),this.tabsLength=this.$tabButtons.length,this.$tabPanes=a.find(this.options.tabPanelSelector).hide().each(function(){return b(this).attr({role:"tabpanel","aria-labeledby":b(this)[0].correspondingTabButton[0].id})}),this.$activeTab=this.$tabPanes.eq(this.options.initialTabToShow),this.$activeTabButton=this.$tabButtons.eq(this.options.initialTabToShow),this.listenClick(this.$tabButtons),this.updateHash(),this.options.keyboard===!0&&this.listenKeyboard(),this.options.history===!0?this.enableHistory():void 0},d.prototype.listenClick=function(a){var d;return d=this,a.on("click",function(){var a,e;return d.options.debug===!0&&(console.log("Active tab is "),d.options.debug===!0&&console.dir(d.$activeTab)),d.$previousTab=d.$activeTab.hide(),d.$previousTabButton=d.$activeTabButton.removeClass("active").attr({"tab-index":-1,"aria-selected":!1,"aria-expanded":!1}),b(this).addClass("active").attr({"tab-index":0,"aria-selected":!0,"aria-expanded":!0}),d.$activeTabButton=b(this),d.$activeTab=null!=(e=b(this)[0].correspondingTabContent)?e.show():void 0,d.options.smoothScroll.enabled===!0&&b("html, body").stop().animate({scrollTop:d.$tabNav.offset().top-d.options.smoothScroll.offset},d.options.smoothScroll.duration),d.options.keyboard===!0?(b(this)[0].href==="#"+(null!=d.options.initialTabId)||b(this)[0].index===d.options.initialTabIndex,a=b(this)[0].href,console.log("Pushed state "+a),null!=c.history&&d.options.history===!0?history.pushState(d.options,"HashTabs",a):c.location.hash=a.split("#")[1],!1):void 0})},d.prototype.updateHash=function(){var a;return a=document.location.hash,""!==a?this.triggerTab(a):null!=this.options.initialTabId?this.triggerTab(this.options.initialTabId):this.triggerTabByIndex(this.options.initialTabIndex)},d.prototype.enableHistory=function(){return b(c).on("popstate",function(a){return function(b){var c;return a.options.debug===!0&&console.dir(b),null!=b.originalEvent.state?(c=location.hash,a.options.debug===!0&&console.log("Pushing url "+c),a.triggerTab(c)):void 0}}(this))},d.prototype.triggerTab=function(a){return this.$tabButtons.filter("[href*="+a+"]").trigger("click")},d.prototype.triggerTabByIndex=function(a){var b;switch(b=null,this.options.debug===!0&&console.log("Triggering tab with index "+a),b){case 0>a:b="is a negative number, and you cannot trigger a tab with a negative index.  Please choose an index within";break;case a>this.tabsLength:b="is larger than";break;default:b="is either not a non-negative integer or is outside of"}if(a>this.tabsLength||0>a||!/^\d+$/.test(a))throw new Error("Cannot show tab of index "+a+", as it "+b+" the current amount of tabs ("+this.tabsLength+").");return this.$tabButtons.eq(a).trigger("click")},d.prototype.listenKeyboard=function(){var a;return a=this,this.$tabButtons.on("keydown",function(b){switch(a.options.debug===!0&&console.log("Pressed key "+b.keyCode),b.keyCode){case 37:return a.selectPrevious();case 39:return a.selectNext();default:if(a.options.debug===!0)return console.log("keypress of "+b.keyCode+" was false")}})},d.prototype.selectPrevious=function(){var a;return a=this.$activeTabButton[0].index-1,this.triggerTabByIndex(-1===a?this.tabsLength-1:a)},d.prototype.selectNext=function(){var a;return this.options.debug===!0&&console.dir([this.$activeTabButton,this.$activeTabButton[0].index]),a=this.$activeTabButton[0].index+1,this.triggerTabByIndex(a===this.tabsLength?0:a)},b.fn.extend({hashTabs:function(){var c,e;return e=arguments[0],c=2<=arguments.length?a.call(arguments,1):[],this.each(function(){var a,f;return a=b(this),f=a.data("hashTabs"),f||a.data("hashTabs",f=new d(this,e)),"string"==typeof e?f[e].apply(f,c):void 0})}}),d}()}(window.jQuery,window)}).call(this);
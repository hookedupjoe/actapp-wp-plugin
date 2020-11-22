(function ($) {


  var tmpBody = $('body');     
  if( tmpBody.length == 0 ){
      //console.log('App Only Init - No Body Found - Aborting Init');
      return;
  } 
  var tmpPluginNames = [];
  setup(false, tmpPluginNames, false);

  ActionAppCore = ActionAppCore || window.ActionAppCore;

  
  function setup(thePages, thePlugins, theUseLayout) {
    try {
      var siteMod = ActionAppCore.module('site');
      ThisApp = new siteMod.CoreApp();
      if( theUseLayout !== false ){
          theUseLayout = true;
      }

      var tmpSetAlert = true;
      var tmpAlertEl = $('body');
      //--- See if we have full semantic loaded with modal function
      //   if not, do not replace the standard alert
      //console.log("typeof(tmpAlertEl.modal)",typeof(tmpAlertEl.modal))
      if( typeof(tmpAlertEl.modal) != 'function'){
//        console.log("no set")
        tmpSetAlert = false;
      }

      //--- Items to load when the application loads
      var tmpRequired = {}
      var tmp
      //--- Use tmpRequiredSpecs to preload more using that example
      ThisApp.init({ setAlert: tmpSetAlert, layout: false, pages: thePages, plugins: thePlugins, required: tmpRequired }).then(function (theReply) {
        ThisApp.getByAttr$({ appuse: "app-loader" }).remove();

        ThisApp.common.adaptive = {
          status: 'live',
          numLookup: ["zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen"],
          onResize: ActionAppCore.debounce(function () {
                ThisApp.common.adaptive.resizeLayoutProcess();
                ThisApp.publish('resized');
            }, 200).bind(this)  
        }
      
        ThisApp.common.adaptive.minCardSizeSm = 210;
        ThisApp.common.adaptive.minCardSize = 255;
        ThisApp.common.adaptive.maxCardSizeSm = 365;
        ThisApp.common.adaptive.maxCardSize = 315;
        ThisApp.common.adaptive.currentCardCount = 0;
        ThisApp.common.adaptive.cutOffSmall = 668;
        ThisApp.common.adaptive.cutOffLarge = 9999;
      
      
        ThisApp.common.adaptive.resizeLayoutProcess = function (theForce) {
          try {
            //--- On layout resize ...
            var tmpEl = ThisApp.getByAttr$({appuse:'grid-16'});
            ThisApp.grid16.resizeGrid({
              parent: tmpEl
            });
            var tmpTW = tmpEl.innerWidth();
            this.currentWidth = tmpTW;
        
            var tmpCardCount = 4;
        
            var tmpCards = ThisApp.getSpot('cards-area');
            var tmpIW = tmpCards.innerWidth();
            var tmpMin = this.minCardSizeSm;
            if (this.mode != "S") {
              tmpMin = this.minCardSize;
            }
            var tmpMax = this.maxCardSizeSm;
            if (this.mode != "S") {
              tmpMax = this.maxCardSize;
            }
        
        
            this.lastTW = tmpTW;
            this.lastIW = tmpIW;
        
            var tmpEach = parseInt(tmpIW / tmpMin);
            tmpCardCount = tmpEach;
        
            if (tmpCardCount > 10) {
              tmpCardCount = 10;
            }
        
        
           
        //console.log("tmpCards",tmpCards)
        
            var tmpCardsLen = tmpCards.length;
            if (tmpCards && tmpCardsLen > 0) {
              //console.log("tmpCardsLen",tmpCardsLen)
              for (var iPos = 0; iPos < tmpCardsLen; iPos++) {
                var tmpCardsEl = $(tmpCards[iPos]);
                
                if (tmpCardsEl && tmpCardsEl.is(":visible")) {
                  //console.log('tmpCardsEl',tmpCardsEl)
                  var tmpCardEntryEls = tmpCardsEl.find('.card.ui');
                  if (this.mode == 'S') {
                    tmpCardEntryEls.css('max-width', this.maxCardSizeSm + 'px');
                  } else {
                    tmpCardEntryEls.css('max-width', this.maxCardSize + 'px');
                  }
                  var tmpCurrCards = tmpCardEntryEls.length;
                  var tmpMaxCards = tmpCurrCards;
                  //---
                  //console.log('tmpCardCount',tmpCardCount)
                  if (tmpCardCount > tmpMaxCards) {
                    tmpCardCount = tmpMaxCards;
                  }
                  //console.log('tmpCardCount2',tmpCardCount)
        
                  if (tmpCurrCards == 4 && tmpCardCount == 3) {
                    if (tmpTW < 800) {
                      tmpCardCount = 2;
                    } else {
                      tmpCardCount = 4;
                    }
                  }
        
                  var tmpToRemove = '';
                  if (this.currentCardCount) {
                    tmpToRemove = this.numLookup[this.currentCardCount];
                  }
                  this.currentCardCount = tmpCardCount;
                  var tmpToAdd = this.numLookup[this.currentCardCount];
        
        
                  if (theForce || (tmpToRemove != tmpToAdd)) {
                    if (tmpToRemove) {
                      tmpCards.removeClass(tmpToRemove);
                    }
                    if (tmpToAdd) {
                      tmpCards.addClass(tmpToAdd);
                    }
                  }
                }
              }
            }
        
            //--- end layout resize
        
          } catch (ex) {
            console.error("Error on refresh ", ex);
          }
        };
      
        window.addEventListener('resize', ThisApp.common.adaptive.onResize );


        ThisApp.common.adaptive.resizeLayoutProcess();
        

        //--- Extend common with your app specific stuff
        $.extend(ThisApp.common, {
          
        })
        
      });
    } catch (ex) {
      console.error("Unexpected Error " + ex);
    }
  }





})(jQuery);
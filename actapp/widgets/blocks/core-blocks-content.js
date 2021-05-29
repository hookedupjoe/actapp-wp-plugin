/**
 * Action App Blocks - Client Side Entrypoint: core-bloack.js
 * 
 * Copyright (c) 2021 Joseph Francis / hookedup, inc. 
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Joseph Francis
 * @package actapp
 * @since actapp 1.0.22
 */

( function ( wp,  ActionAppCore) {
    
    var BlocksController = {};

    function init(){
        var tmpBaseURL = ActionAppCore.BlockManagerConfig.catalogURL;
       
        ActionAppCore.common = ActionAppCore.common || {};
        ActionAppCore.common.blocks = ActionAppCore.common.blocks || {};

        //--- Create entry point from Action App entrypoint
        ActionAppCore.common.blocks.Controller = BlocksController;
        
        window.ActAppBlocksController = BlocksController;

        
        BlocksController.getCatalogTemplate = function(theName){
            var tmpMap = {};
            tmpMap[theName] = theName;
            return ThisApp.loadResources({
                templates: {
                    baseURL: ActionAppCore.BlockManagerConfig.catalogURL + '/templates/',
                    map: tmpMap
                }
            })
        }
        BlocksController.getCatalogPanel = function(theName){
            var tmpMap = {};
            tmpMap[theName] = theName;
            return ThisApp.loadResources({
                panels: {
                    baseURL: ActionAppCore.BlockManagerConfig.catalogURL + '/panels/',
                    map: tmpMap
                }
            })
        }
        BlocksController.getCatalogControl = function(theName){
            var tmpMap = {};
            tmpMap[theName] = theName;
            return ThisApp.loadResources({
                controls: {
                    baseURL: ActionAppCore.BlockManagerConfig.catalogURL + '/controls/',
                    map: tmpMap
                }
            })
        }
        BlocksController.getCatalogHTML = function(theName){
            var tmpMap = {};
            tmpMap[theName] = theName;
            return ThisApp.loadResources({
                html: {
                    baseURL: ActionAppCore.BlockManagerConfig.catalogURL + '/html/',
                    map: tmpMap
                }
            })
        }

        
    }


    

    //--- Initialize common block functionality for the editor
    init();

} )( window.wp, window.ActionAppCore );

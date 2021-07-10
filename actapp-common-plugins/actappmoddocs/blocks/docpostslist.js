/**
 * Block Widget: docpostslist.js - List of Docs
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
 * This button and all notices must be kept intact.
 *
 * @author Joseph Francis
 * @package actapp
 * @since actapp 1.0.22
 */

 ( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var BlockEditor = ActionAppCore.common.blocks.Editor;

    var info = {
        name: 'docpostslist',
        title: 'Docs List',
        example: {
            
        },
        category: 'actappdocposts',
        atts: {}
    };
    const iconEl = BlockEditor.getControlIcon(info.name);

    BlockEditor.addBooleanAtts(info.atts,['showdate']);
    BlockEditor.addStringAtts(info.atts,['category']);

    
    function getContent(theProps, theIsEditMode){
        var tmpAtts = theProps.attributes;
        var tmpContent = (el('div',{},'Docs List'));
        return tmpContent;
    }
    function getClass(theProps, theIsEditMode){
        return '';
    }
    wp.blocks.registerBlockType( info.category + '/' + info.name, {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {
            var tmpAtts = props.attributes;
            var tmpContent = getContent(props, true);
            return el(
                'div',
                useBlockProps(),
                [
                    tmpContent
                ]
            );
        },
 
       
    } );
} )( window.wp, window.ActionAppCore );



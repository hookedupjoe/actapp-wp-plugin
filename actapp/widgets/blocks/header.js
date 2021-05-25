/**
 * Block Widget: header.js - Semantic UI Header
 * 
 * Copyright (c) 2020 Joseph Francis / hookedup, inc. www.hookedup.com
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
 * @since actapp 1.0.21
 */

( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var BlockEditor = ActionAppCore.blocks.Editor;

    var info = {
        name: 'header',
        title: 'Header',
        example: {
            attributes: {color: 'blue',text: 'Header Text', size: 'large'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon(info.name);
    BlockEditor.addStringAtts(info.atts,['text','color','size', 'subtext', 'attached', 'alignment']);
    BlockEditor.addBoolAtts(info.atts,['dividing','block','inverted']);
    var tmpClassSpecs = {
        boolean: ['dividing','block','inverted'],
        string: ['color','size', 'attached', 'alignment']
    }
    
    function getContent(theProps, theIsEditMode){
        var tmpAtts = theProps.attributes;
        var tmpContent = [];
        if( tmpAtts.subtext != '' ){
            tmpContent.push( BlockEditor.el('div','sub header',tmpAtts.subtext) );
        }
        return tmpContent;
    }
    function getClass(theProps, theIsEditMode){
        var tmpCN = BlockEditor.getStandardClass( 'ui header', tmpClassSpecs, theProps, theIsEditMode);
        return tmpCN;
    }
    wp.blocks.registerBlockType( info.category + '/' + info.name, {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {
            var InspectorControls = wp.editor.InspectorControls;
            var PanelBody = wp.components.PanelBody;
          
            
            var tmpAtts = props.attributes;
            var tmpCN = getClass(props, true);
            console.log('tmpCN',tmpCN)

            var tmpContent = getContent(props, true);
            
            var tmpText = tmpAtts.text;
            if(  (!(tmpAtts.text || tmpAtts.subtext))){
                tmpText = 'Blank Header: Enter details on the sidebar **';
            }

            return el(
                'div',
                useBlockProps(),
                el(
                    InspectorControls,
                    null,
                    wp.element.createElement(PanelBody, {
                        title: 'Message Options',
                        initialOpen: true,                    
                    },
                        [
                            BlockEditor.getStandardProperty(props,'text', 'Header Text'),
                            BlockEditor.getStandardProperty(props,'subtext', 'Sub Text' ),
                            BlockEditor.getStandardProperty(props,'color', 'Header Color', 'color' ),
                            BlockEditor.getStandardProperty(props,'size', 'Size', 'size' ),
                            BlockEditor.getStandardProperty(props,'inverted', 'Inverted', 'checkbox' ),
                            BlockEditor.getStandardProperty(props,'dividing', 'Line at bottom', 'checkbox' ),
                            BlockEditor.getStandardProperty(props,'block', 'Show as block', 'checkbox' ),
                            BlockEditor.getStandardProperty(props,'attached', 'Attached', 'attached' ),
                            BlockEditor.getStandardProperty(props,'alignment', 'Alignment', 'alignment' ),
                        ]
                    )
                ),
               
                el('div',{className:tmpCN},[tmpText,tmpContent]),
            );
        },
 
        save: function ( props ) {
            var tmpCN = getClass(props, false);
            var tmpContent = getContent(props, false);
            return el('div',{className:tmpCN},props.attributes.text,tmpContent);
        },
    } );
} )( window.wp, window.ActionAppCore );


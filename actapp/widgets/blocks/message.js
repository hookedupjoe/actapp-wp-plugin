/**
 * Block Widget: message.js - Semantic UI Message  
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
    var tmpAE = BlockEditor.el;

    function getDisplayValue(theProps,theIsEditMode){
        var tmpAtts = theProps.attributes;
        var props = theProps;

        var tmpCN = 'ui message';
        var tmpAtts = props.attributes;
        if( tmpAtts.color ){
            tmpCN += ' ' + tmpAtts.color
        }
        if( tmpAtts.size ){
            tmpCN += ' ' + tmpAtts.size
        }

        var tmpClass = 'ui message ' + tmpCN;
        

        if( theIsEditMode ){
            return BlockEditor.el('div', tmpClass,  [el( wp.blockEditor.InnerBlocks )]);
        } else {
            return BlockEditor.el('div', tmpClass, el( wp.blockEditor.InnerBlocks.Content ));
        }
        
    }
    var info = {
        name: 'message',
        title: 'Message Box',
        example: {
            attributes: {color: 'blue'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon(info.name);

    BlockEditor.addStringAtts(info.atts,['color','size']);
    
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
                            BlockEditor.getOptionLabel('Message Color'),
                            BlockEditor.getColorListControl(tmpAtts.color, function ( theEvent ) {
                                props.setAttributes( { color: theEvent.target.value } )
                            }),
                            BlockEditor.getOptionSep(),

                            BlockEditor.getOptionLabel('Size'),
                            BlockEditor.getSizeListControl(tmpAtts.size, function ( theEvent ) {
                                props.setAttributes( { size: theEvent.target.value } )
                            }),
                            BlockEditor.getOptionSep(),
                        ]
                    )
                ),
               
                getDisplayValue(props,true)
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpCN = 'ui message';
            var tmpAtts = props.attributes;
            if( tmpAtts.color ){
                tmpCN += ' ' + tmpAtts.color
            }
            if( tmpAtts.size ){
                tmpCN += ' ' + tmpAtts.size
            }
            return el(
                'div',                
                blockProps,
                [
                    getDisplayValue(props,false)
                ]
            );
        },
    } );
} )( window.wp, window.ActionAppCore );



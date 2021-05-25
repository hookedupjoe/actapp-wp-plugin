/**
 * Block Widget: cards.js - Semantic UI Cards Container
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
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var BlockEditor = ActionAppCore.blocks.Editor;
    
    var info = {
        name: 'cards',
        title: 'UI Card Container',
        example: {
            attributes: {color: 'green'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = BlockEditor.getControlIcon(info.name);

    BlockEditor.addNumberAtts(info.atts,['maxImageHeight']);
    BlockEditor.addStringAtts(info.atts,['columns','color']);

    var tmpClassSpecs = {
        boolean: [],
        string: ['color']
    }
    function getClass(theProps, theIsEditMode){
        return BlockEditor.getStandardClass( 'ui card', tmpClassSpecs, theProps, theIsEditMode);
    }
	function getDisplayValue(theProps,theIsEditMode){
        var props = theProps;
        var tmpClass = getClass(props, true);

       

        if( theIsEditMode ){
        var tmpUIColor = props.attributes.color || '';
        var tmpHeaderMsg = 'CARDS CONTAINER:';
        if( props.attributes.columns ){
            tmpHeaderMsg += " (" + props.attributes.columns + " columns)";
        } else {
            tmpHeaderMsg += " (columns auto-adjust )";
        }
        var tmpHdr = el('div',{className:'ui label fluid large ' + tmpUIColor},tmpHeaderMsg);
        return el('div', {className:'ui segment ' + theProps.attributes.color || ''},null, 
        tmpHdr ,    
        el('div',{className:'edit-cards' + props.attributes.color + ' ' + props.attributes.columns},
        [
            el(wp.blockEditor.InnerBlocks),
        ]
        ))
           // return BlockEditor.el('div', tmpClass,  [el( wp.blockEditor.InnerBlocks )]);
        } else {
            return BlockEditor.el('div', tmpClass, el( wp.blockEditor.InnerBlocks.Content ));
        }
        
    }

    wp.blocks.registerBlockType( 'actappui/cards', {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {

            var tmpStandardProperties = [
                BlockEditor.getStandardProperty(props,'color', 'All Cards Color', 'color' ),
                BlockEditor.getStandardProperty(props,'columns', 'Columns', 'columns' ),
                BlockEditor.getStandardProperty(props,'maxImageHeight', 'Max Image Height', 'number' ),
            ];
            var tmpSidebarPanels = [
                BlockEditor.getSidebarPanel('Cards Container Options', tmpStandardProperties)
            ];

            var tmpSidebarControls = BlockEditor.getSidebarControls(tmpSidebarPanels);

            var tmpDisplayObject = getDisplayValue(props,true);

            return el(
                'div',
                useBlockProps(),
                [
                    tmpSidebarControls,               
                    tmpDisplayObject
                ]
            );

            // function onChangeColor( theEvent ) {
            //     props.setAttributes( { color: theEvent.target.value } );
            //     BlockEditor.refreshBlockEditor();
            // }
            // function onChangeColumn( theEvent ) {
            //     props.setAttributes( { columns: theEvent.target.value } );
            //     BlockEditor.refreshBlockEditor();
            // }
            // function onChangeMaxImageHeight( theEvent ) {
            //     var tmpVal = parseInt(theEvent.target.value);
            //     if( !(tmpVal)){
            //         tmpVal = 0;
            //     }
            //     props.setAttributes( { maxImageHeight: tmpVal } );
            //     BlockEditor.refreshBlockEditor();
            // }
            
            // var BlockEditor = ActionAppCore.blocks.Editor;

            // var InspectorControls = wp.editor.InspectorControls;
            // var PanelBody = wp.components.PanelBody;
            // var tmpUIColor = props.attributes.color || '';
            // var tmpHeaderMsg = 'CARDS:';
            // if( props.attributes.columns ){
            //     tmpHeaderMsg += " (" + props.attributes.columns + " columns)";
            // } else {
            //     tmpHeaderMsg += " (columns auto-adjust )";
            // }
            // var tmpHdr = el('div',{className:'ui label fluid large ' + tmpUIColor},tmpHeaderMsg);
            // var ALLOWED_BLOCKS = ['actappui/card'];
            // return el(
            //     'div',
            //     useBlockProps(),
            //     el(
            //         InspectorControls,
            //         null,
            //         wp.element.createElement(PanelBody, {
            //             title: 'Look and Feel Options',
            //             initialOpen: true,                    
            //         },
                    
            //         el('div',{className:'ui segment basic slim'},[
            //                 BlockEditor.getOptionLabel('Cards Color'),
            //                 BlockEditor.getColorListControl(props.attributes.color,onChangeColor),
            //                 BlockEditor.getOptionSep(),

            //                 BlockEditor.getOptionLabel('Columns'),
            //                 BlockEditor.getColumnListControl(props.attributes.columns,onChangeColumn),
            //                 BlockEditor.getOptionSep(),

            //                 BlockEditor.getOptionLabel('Max Image Height'),
            //                 BlockEditor.getOptionNote('In pixels (use 0 for no cropping)'),
            //                 BlockEditor.getTextControl(props.attributes.maxImageHeight,onChangeMaxImageHeight)
                            
            //                 ])
            //         )
            //     ),
            //     el('div', {className:'ui segment ' + tmpUIColor},null, tmpHdr ,    el('div',{className:'edit-cards' + props.attributes.color + ' ' + props.attributes.columns},
            //     [
            //         el(wp.blockEditor.InnerBlocks, {REM_BREAKS_ON_DRAG_allowedBlocks: ALLOWED_BLOCKS}),
            //     ]
            //     ))
            // );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            
            if( props.attributes.columns == '' ){
                blockProps["auto-adapt"] = "cards";
            } else {
                blockProps["columns"] = props.attributes.columns;
            }


            var tmpClasses = 'ui cards';
            if( props.attributes.color != ''){
                tmpClasses += ' ' + props.attributes.color;
            }
            if( props.attributes.columns != ''){
                tmpClasses += ' stackable ' + props.attributes.columns;
            }

            blockProps.className += ' ' + tmpClasses;

            return el(
                'div',                
                blockProps,                               
                el( wp.blockEditor.InnerBlocks.Content )
                
            );
        },
    } );
} )( window.wp, window.ActionAppCore );



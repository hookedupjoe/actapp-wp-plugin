/**
 * Block Widget: segment.js - Semantic UI Segment
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
    var BlockEditor = ActionAppCore.common.blocks.Editor;

    var info = {
        name: 'segment',
        title: 'UI Segment',
        example: {
            attributes: {color: 'blue'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = BlockEditor.getControlIcon(info.name);

    BlockEditor.addStringAtts(info.atts,['color','size']);
    BlockEditor.addBooleanAtts(info.atts,['raised','stacked','vertical']);
    var tmpClassSpecs = {
        boolean: ['raised','stacked','vertical'],
        string: ['color','size']
    }    
    function getClass(theProps, theIsEditMode){
        return BlockEditor.getStandardClass( 'ui segment', tmpClassSpecs, theProps, theIsEditMode);
    }
    function getDisplayValue(theProps,theIsEditMode){
        var props = theProps;
        var tmpClass = getClass(props, true);
        var tmpAtts = {className:tmpClass};
        tmpAtts.spot = 'segmentspot';
        if( theIsEditMode ){
            return el('div', tmpAtts,  [el( wp.blockEditor.InnerBlocks )]);
        } else {
            return el('div', tmpAtts, el( wp.blockEditor.InnerBlocks.Content ));
        }
        
    }

    wp.blocks.registerBlockType( info.category + '/' + info.name, {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {
            var tmpStandardProperties = [
                BlockEditor.getStandardProperty(props,'color', 'Segment Color', 'color' ),
                BlockEditor.getStandardProperty(props,'size', 'Size', 'size' ),
                BlockEditor.getStandardProperty(props,'attached', 'Attached', 'attached' ),
                BlockEditor.getStandardProperty(props,'raised', 'Raised', 'checkbox' ),
                BlockEditor.getStandardProperty(props,'stacked', 'Stacked', 'checkbox' ),
                BlockEditor.getStandardProperty(props,'vertical', 'Vertical', 'checkbox' ),
            ];
            var tmpSidebarPanels = [
                BlockEditor.getSidebarPanel('Segment Options', tmpStandardProperties)
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
        },
 
        save: function ( props ) {
            return getDisplayValue(props,false);
        },
    } );
} )( window.wp, window.ActionAppCore );



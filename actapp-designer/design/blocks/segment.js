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
    var gSelectedAddItem = '';
    var gToolbarSelection = '';

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

    BlockEditor.addStringAtts(info.atts,['color','size','attached','basic', 'spotname','spotsourcetype','spotsourcename','spotsourcepartname']);
    BlockEditor.addBooleanAtts(info.atts,['raised','stacked','vertical']);
    var tmpClassSpecs = {
        boolean: ['raised','stacked','vertical','basic'],
        string: ['color','size','attached']
    }    
    function getClass(theProps, theIsEditMode){
        return BlockEditor.getStandardClass( 'ui segment', tmpClassSpecs, theProps, theIsEditMode);
    }
    function getDisplayValue(theProps,theIsEditMode){
        var props = theProps;
        var tmpClass = getClass(props, true);
        var tmpAtts = {className:tmpClass};
        var tmpPropAtts = theProps.attributes;
        
        var tmpEls = [];
        if( tmpPropAtts.spotname  && tmpPropAtts.spotname != ''){
            var tmpSpotTopAtts = {spot:tmpPropAtts.spotname};
            if( tmpPropAtts.spotsourcetype ){
                //console.log('tn',tmpPropAtts.spotsourcetype)
                tmpSpotTopAtts.sourcetype = tmpPropAtts.spotsourcetype;
                tmpSpotTopAtts.appuse = 'blockmarkup';
            }
            if( tmpPropAtts.spotsourcename ){
                //console.log('ts',tmpPropAtts.spotsourcename)
                tmpSpotTopAtts.sourcename = tmpPropAtts.spotsourcename;                
            }
            if( tmpPropAtts.spotsourcepartname ){
                //console.log('ts',tmpPropAtts.spotsourcename)
                tmpSpotTopAtts.sourcepartname = tmpPropAtts.spotsourcepartname;                
            }
            
    
            tmpEls.push(el('div',tmpSpotTopAtts,''));
        }

        
        if( theIsEditMode ){
            tmpEls.push(el( wp.blockEditor.InnerBlocks ));
        } else {
            tmpEls.push(el( wp.blockEditor.InnerBlocks.Content ));
        }

        
        return el('div', tmpAtts, tmpEls);
        
    }

    wp.blocks.registerBlockType( info.category + '/' + info.name, {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {
            
            var tmpPropAtts = props.attributes;
            if( tmpPropAtts.spotname ){

            }
            var tmpStandardProperties = [
                BlockEditor.getStandardProperty(props,'color', 'Segment Color', 'color' ),
                BlockEditor.getStandardProperty(props,'size', 'Size', 'size' ),
                BlockEditor.getStandardProperty(props,'basic', 'No Border', 'checkbox' ),
                BlockEditor.getStandardProperty(props,'attached', 'Attached', 'attached' ),
                BlockEditor.getStandardProperty(props,'raised', 'Raised', 'checkbox' ),
                BlockEditor.getStandardProperty(props,'stacked', 'Stacked', 'checkbox' ),
                BlockEditor.getStandardProperty(props,'vertical', 'Vertical', 'checkbox' ),
            ];
            var tmpDevProperties = [
                BlockEditor.getStandardProperty(props,'spotname', 'Spot Name', 'text' ),
                !(tmpPropAtts.spotname !='') ? '' : BlockEditor.getStandardProperty(props,'spotsourcetype', 'Spot Source Type', 'text' ),
                !(tmpPropAtts.spotname !='') ? '' : BlockEditor.getStandardProperty(props,'spotsourcename', 'Spot Source Name', 'text' ),
                !(tmpPropAtts.spotname !='') ? '' : BlockEditor.getStandardProperty(props,'spotsourcepartname', 'Part Name (Optional)', 'text' ),

                !(tmpPropAtts.spotsourcename !='') ? '' : el('div',{className: 'ui button circular blue fluid', action:'updatePreview'},'Refresh Preview'),
            ];

            var tmpSidebarPanels = [
                BlockEditor.getSidebarPanel('Segment Options', tmpStandardProperties),
                BlockEditor.getSidebarPanel('Developer Options', tmpDevProperties),
            ];

            var tmpSidebarControls = BlockEditor.getSidebarControls(tmpSidebarPanels);

            var tmpDisplayObject = getDisplayValue(props,true);
           
            var tmpOnAddSelect = function(theEvent){
                var tmpThis = wp.data.select( 'core/block-editor' ).getSelectedBlock();
                var tmpPos = 0;
                if( tmpThis.innerBlocks && tmpThis.innerBlocks.length ){
                    tmpPos = tmpThis.innerBlocks.length;
                }
                var tmpItemToAdd = theEvent.nativeEvent.target.value || '';
                var tmpToAddElement = BlockEditor.getCommonBlock(tmpItemToAdd);
                wp.data.dispatch('core/editor').insertBlocks(tmpToAddElement,tmpPos,tmpThis.clientId) 
            }
            var tmpToolbarAdds = el(
                wp.blockEditor.BlockControls,
                { key: 'controls' },
                [
                    gToolbarSelection
                ]
            );

            gToolbarSelection =  BlockEditor.getCommonBlocksListControl(gSelectedAddItem,tmpOnAddSelect);
            return el(
                'div',
                useBlockProps(),
                [
                    //tmpToolbarAdds,
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



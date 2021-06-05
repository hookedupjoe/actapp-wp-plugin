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

    BlockEditor.addBooleanAtts(info.atts,['raised','stacked','vertical','clearing']);
    BlockEditor.addStringAtts(info.atts,['color','size','attached','alignment','basic', 'spotname','spotsourcetype','spotsourcename','spotsourcepartname']);

    var tmpClassSpecs = {
        boolean: ['raised','stacked','vertical','basic','clearing'],
        string: ['color','size','attached','alignment']
    }    
    function getClass(theProps, theIsEditMode){
        return BlockEditor.getStandardClass( 'ui segment', tmpClassSpecs, theProps, theIsEditMode);
    }
    function getDisplayValue(theProps,theIsEditMode){
        var props = theProps;
        var tmpClass = getClass(props, true);
        if( theIsEditMode  ){ //&& !props.isSelected 
            tmpClass += ' actapp-block-box';
        }
        var tmpAtts = {className:tmpClass};
        var tmpPropAtts = theProps.attributes;
        
        var tmpEls = [];
        if( tmpPropAtts.spotname  && tmpPropAtts.spotname != ''){
            var tmpSpotTopAtts = {spot:tmpPropAtts.spotname};
            if( tmpPropAtts.spotsourcetype ){
                tmpSpotTopAtts.sourcetype = tmpPropAtts.spotsourcetype;
                tmpSpotTopAtts.appuse = 'blockmarkup';
            }
            if( tmpPropAtts.spotsourcename ){
                tmpSpotTopAtts.sourcename = tmpPropAtts.spotsourcename;                
            }
            if( tmpPropAtts.spotsourcepartname ){
                tmpSpotTopAtts.sourcepartname = tmpPropAtts.spotsourcepartname;                
            }
            
            tmpEls.push(el('div',tmpSpotTopAtts,''));
        }

        
        if( theIsEditMode ){
            var tmpMe = wp.data.select( 'core/block-editor' ).getBlock(props.clientId);
            var tmpChildren = tmpMe.innerBlocks;
            if(!(tmpChildren && tmpChildren.length )){
                //--- This assures the drag and drop feature allows a drop in a new unselected segment
                var tmpToAddElement = BlockEditor.getCommonBlock('coreparagraph'); 
                wp.data.dispatch('core/editor').insertBlocks(tmpToAddElement,0,props.clientId) 
            }
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
                BlockEditor.getStandardProperty(props,'clearing', 'Contain Floaters', 'checkbox' )
            ];
            var tmpFormatProperties = [
                //(tmpAtts.alignment) ? '' : BlockEditor.getStandardProperty(props,'float', 'Float', 'floatleftright' ),
                BlockEditor.getStandardProperty(props,'alignment', 'Alignment', 'alignment' )
            ];

            var tmpDevProperties = [
                BlockEditor.getStandardProperty(props,'spotname', 'Spot Name', 'text' ),
                !(tmpPropAtts.spotname !='') ? '' : BlockEditor.getStandardProperty(props,'spotsourcetype', 'Spot Source Type', 'text' ),
                !(tmpPropAtts.spotname !='') ? '' : BlockEditor.getStandardProperty(props,'spotsourcename', 'Spot Source Name', 'text' ),
                !(tmpPropAtts.spotname !='') ? '' : BlockEditor.getStandardProperty(props,'spotsourcepartname', 'Part Name (Optional)', 'text' ),
                !(tmpPropAtts.spotsourcename !='') ? '' : el('div',{className: 'ui button circular blue fluid', action:'updatePreview'},'Refresh Preview')
            ];

            var tmpSidebarPanels = [
                BlockEditor.getSidebarPanel('Segment Options', tmpStandardProperties),
                BlockEditor.getSidebarPanel('Formatting Options', tmpFormatProperties),                
                BlockEditor.getSidebarPanel('Developer Options', tmpDevProperties)
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

            var tmpBtnBar = '';
            if( props.isSelected ){
                var tmpBarContent = [];
                //tmpBarContent.push(el('div',{className:'ui fluid label blue mar5'},'UI Segment')),
                tmpBarContent.push(el('div',{className:'ui compact button blue basic ',action:'beAddElement', elementname: 'header'}, 'Header'));
                tmpBarContent.push(el('div',{className:'ui compact button blue basic ',action:'beAddElement', elementname:'message'}, 'Message'));
                tmpBarContent.push(el('div',{className:'ui compact button blue basic ',action:'beAddElement', elementname:'image'}, 'Image'));
                tmpBarContent.push(el('div',{className:'ui compact button blue basic ',action:'beAddElement', elementname:'cards'}, 'Cards'));
                tmpBtnBar = el('div',{},[el('div',{className:'ui fluid label blue mar5'},'UI Segment'),el('div',{className:'ui segment raised slim'},tmpBarContent,el('div',{className:'endfloat'}))]);
            }
            
            return el(
                'div',
                useBlockProps(),
                [
                    tmpBtnBar,
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



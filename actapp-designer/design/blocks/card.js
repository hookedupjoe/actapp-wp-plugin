/**
 * Block Widget: card.js - Semantic UI Card  
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
        name: 'card',
        title: 'UI Card',
        example: {
            attributes: {text: 'This is some more card text',title:'What a card'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = BlockEditor.getControlIcon(info.name);

    BlockEditor.addNumberAtts(info.atts,['parentMaxImgHeight', 'mediaID']);
    BlockEditor.addBooleanAtts(info.atts,['fluid', 'raised']);
    BlockEditor.addStringAtts(info.atts,['text','title', 'subtitle', 'color', 'parentColor', 'url', 'mediaURL']);

    var tmpClassSpecs = {
        boolean: ['fluid','raised'],
        string: []
    }
    function getClass(theProps, theIsEditMode){
        return BlockEditor.getStandardClass( 'ui card', tmpClassSpecs, theProps, theIsEditMode);
    }
	
    var newEl = BlockEditor.el;

    function getDisplayValue(theProps,theIsEditMode){
        var tmpAtts = theProps.attributes;
        var props = theProps;

        var tmpContent = [];
        var tmpClass = getClass(theProps,theIsEditMode);
        var tmpTitle = '';
        var tmpAtt = props.attributes;
        
        if( tmpAtts.parentColor != '' ){
            tmpClass += ' ' + tmpAtts.parentColor;
        } else if( tmpAtt.color ){
            tmpClass += ' ' + tmpAtt.color;
        }
        if( tmpAtt.title ){
            tmpTitle = tmpAtt.title;
        }
        if( tmpAtt.mediaURL ){
            var tmpMediaAtts = {src:tmpAtt.mediaURL};
           if( tmpAtts.parentMaxImgHeight > 0 ){
                tmpMediaAtts.style = {"max-height":tmpAtts.parentMaxImgHeight,"min-height":tmpAtts.parentMaxImgHeight,"object-fit": "cover"}
            }
             
            tmpContent.push( newEl('div','image',el('img',tmpMediaAtts) )  );
        }
        if( theIsEditMode && tmpTitle == '' && tmpAtt.mediaURL == '' && tmpAtt.subtitle == ''  && tmpAtt.text == '' ){
            //EDIT ONLY
            tmpTitle = '** EDIT DETAILS ON SIDEBAR **';
        }
        var tmpMainContent = [];
        if( tmpTitle ){
            tmpMainContent.push( newEl('div','header',tmpTitle) );
        }
        if( tmpAtt.subtitle ){
            tmpMainContent.push( newEl('div','meta',tmpAtt.subtitle) );
        }
        if( tmpAtt.text ){
            tmpMainContent.push( newEl('div','description',tmpAtt.text) );
        }
        tmpContent.push( newEl('div','content',tmpMainContent) );
        
        var tmpExtraContent = [];
        
        if( tmpAtt.url && !theIsEditMode){
            return el('a',{className:tmpClass,href:tmpAtt.url},tmpContent);
        } else {
            return newEl('div',tmpClass,tmpContent);
        }


    }
 
    wp.blocks.registerBlockType( 'actappui/card', {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {
            var tmpParentAttributes = BlockEditor.getParentAttributes(props.clientId);
            props.attributes.parentColor = tmpParentAttributes.color || '';
            props.attributes.parentMaxImgHeight = tmpParentAttributes.maxImageHeight || 0;

            var tmpParentColor = tmpParentAttributes.color || '';

            var tmpStandardProperties = [
                BlockEditor.getStandardProperty(props,'title', 'Card Title'),
                BlockEditor.getStandardProperty(props,'subtitle', 'Subtitle' ),
                BlockEditor.getStandardProperty(props,'text', 'Text' ),
                tmpParentColor ? '' : BlockEditor.getStandardProperty(props,'color', 'Card Color', 'color' ),
                BlockEditor.getStandardProperty(props,'url', 'Target Content or Link', 'url' ),
                BlockEditor.getStandardProperty(props,{mediaID:'mediaID',mediaURL:'mediaURL'}, 'Card Image', 'image' ),
            ];

            var tmpSidebarPanels = [
                BlockEditor.getSidebarPanel('Card Options', tmpStandardProperties)
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
            //not using blockProps, need clean HTML
            var tmpEl = getDisplayValue(props,false)
            return tmpEl;
        },

    } );
} )( window.wp, window.ActionAppCore );



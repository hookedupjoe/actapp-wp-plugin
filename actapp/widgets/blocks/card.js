/**
 * Block Widget: card.js - Semantic UI Card  
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
 * @since actapp 1.0.22
 */
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var BlockEditor = ActionAppCore.blocks.Editor;
    
    var info = {
        name: 'card',
        title: 'Card',
        example: {
            attributes: {text: 'This is some more card text',title:'What a card'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon(info.name);

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
	var MediaUpload = wp.editor.MediaUpload;
	

    var tmpAE = BlockEditor.el;

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
             
            tmpContent.push( tmpAE('div','image',el('img',tmpMediaAtts) )  );
        }
        if( theIsEditMode && tmpTitle == '' && tmpAtt.mediaURL == '' && tmpAtt.subtitle == ''  && tmpAtt.text == '' ){
            //EDIT ONLY
            tmpTitle = '** EDIT DETAILS ON SIDEBAR **';
        }
        var tmpMainContent = [];
        if( tmpTitle ){
            tmpMainContent.push( tmpAE('div','header',tmpTitle) );
        }
        if( tmpAtt.subtitle ){
            tmpMainContent.push( tmpAE('div','meta',tmpAtt.subtitle) );
        }
        if( tmpAtt.text ){
            tmpMainContent.push( tmpAE('div','description',tmpAtt.text) );
        }
        tmpContent.push( tmpAE('div','content',tmpMainContent) );
        
        var tmpExtraContent = [];

        if( tmpAtt.url && !theIsEditMode){
            return el('a',{className:tmpClass,href:tmpAtt.url},tmpContent);
        } else {
            return tmpAE('div',tmpClass,tmpContent);
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

            //or use temp parent id
            var tmpParentColor = tmpParentAttributes.color || '';
            
            function onChangeURL( theURL, thePost ) {
                props.setAttributes( { url: theURL } );
            }
            

            var onSelectImage = function( media ) {
				return props.setAttributes( {
					mediaURL: media.url,
					mediaID: media.id,
				} );
			};

            var onRemoveImage = function(){
                return props.setAttributes( {
					mediaURL: '',
					mediaID: 0,
				} );
            }

            

            
            var tmpStandardProperties = [
                            //BlockEditor.getOptionLabel('Card Title'),
                            // BlockEditor.getTextControl(props.attributes.title,onChangeTitle),
                            // BlockEditor.getOptionSep(),
                            // BlockEditor.getOptionLabel('Card Sub Title'),
                            // BlockEditor.getTextControl(props.attributes.subtitle,onChangeSubTitle),
                            // BlockEditor.getOptionSep(),
                            // BlockEditor.getOptionLabel('Card Text'),
                            // BlockEditor.getTextControl(props.attributes.text,onChangeText),
                            // BlockEditor.getOptionSep(),
                            // tmpParentColor ? '' : BlockEditor.getOptionLabel('Card Color'),
                            // tmpParentColor ? '' : BlockEditor.getColorListControl(props.attributes.color,onChangeColor),
                            // tmpParentColor ? '' : BlockEditor.getOptionSep(),                            
                            BlockEditor.getStandardProperty(props,'title', 'Card Title'),
                            BlockEditor.getStandardProperty(props,'subtitle', 'Subtitle' ),
                            BlockEditor.getStandardProperty(props,'text', 'Text' ),
                            tmpParentColor ? '' : BlockEditor.getStandardProperty(props,'color', 'Card Color', 'color' ),
                            BlockEditor.getStandardProperty(props,'url', 'Target Content or Link', 'url' ),
                                        
                            // el('div',{className:'ui label black fluid'},'Link URL'),
                            // el(wp.editor.URLInput, {onChange: onChangeURL, value: props.attributes.url || ''},'Browse for Link'),
                            // BlockEditor.getOptionSep(), 
                            
                           
                            el('div',{className:'ui label black fluid'},'Card Image'),
                                el( MediaUpload, {
                                    onSelect: onSelectImage,
                                    type: 'image',
                                    value: props.attributes.mediaID,
                                    render: function( obj ) {
                                        
                                        if( !props.attributes.mediaID ){
                                            return el('div',{className:'pad2'},
                                                el('div', {className:'ui button blue basic', onClick: obj.open}, 'Set Card Image')
                                            )
                                        } else {
                                            return el('div',{className:'pad2'},
                                            el('div', {className:'ui button blue basic', onClick: obj.open}, 'Replace'),
                                            el('div', {className:'ui button blue basic', onClick: onRemoveImage}, 'Remove'),                                            
                                                el('div',{className:'pad2'}),
                                                el('img',{className:'ui image rounded fluid', src:props.attributes.mediaURL})
                                            )
                                        }
                                    }
                                } )

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
            //var blockProps = useBlockProps.save();
            var tmpEl = getDisplayValue(props,false)
            return tmpEl;
        },

    } );
} )( window.wp, window.ActionAppCore );



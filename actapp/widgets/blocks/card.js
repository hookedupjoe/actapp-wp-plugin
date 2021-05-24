// Card control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var BlockEditor = ActionAppCore.blocks.Editor;

    var useBlockProps = wp.blockEditor.useBlockProps;

	var MediaUpload = wp.editor.MediaUpload;
	

    function tmpAE(theType,theClass,theContent,theOptionalAtts){
        var tmpAtts = theOptionalAtts || {};
        if( theClass ){
            tmpAtts.className = theClass;
        }
        if( theContent ){
            return el(theType,tmpAtts,theContent);
        }
        return el(theType,tmpAtts);
    }

    function getDisplayValue(theProps,theIsEditMode){
        var tmpAtts = theProps.attributes;
        var props = theProps;

        var tmpContent = [];
        var tmpClass = theIsEditMode ? 'ui card' : 'ui card';
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
        if( theIsEditMode && tmpTitle == '' && tmpAtt.mediaURL == '' && tmpAtt.subTitle == ''  && tmpAtt.text == '' ){
            //EDIT ONLY
            tmpTitle = '** EDIT DETAILS ON SIDEBAR **';
        }
        var tmpMainContent = [];
        if( tmpTitle ){
            tmpMainContent.push( tmpAE('div','header',tmpTitle) );
        }
        if( tmpAtt.subTitle ){
            tmpMainContent.push( tmpAE('div','meta',tmpAtt.subTitle) );
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

        //return tmpAE('div',tmpClass,tmpContent);

    }
 
    //--- How to use a SVG for the icon
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon('card');

    wp.blocks.registerBlockType( 'actappui/card', {
        title: 'Card',
        icon: iconEl,
        category: 'actappui',
        example: {
            attributes: {text: 'This is some more card text',title:'What a card'}
        },
        attributes: {
            text: {
                type: 'string',
                default: '',
            },         
            title: {
                type: 'string',
                default: '',
            },         
            subTitle: {
                type: 'string',
                default: '',
            },
            color: {
                type: 'string',
                default: '',
            },
            parentColor: {
                type: 'string',
                default: '',
            },
            url: {
                type: 'string',
                default: '',
            },
            parentMaxImgHeight: {
                type: 'number',
                default: 0,
            },
            mediaID: {
				type: 'number'
			},
			mediaURL: {
				type: 'string',
                default: ''
			}
        },
        edit: function ( props ) {
            var tmpParentAttributes = BlockEditor.getParentAttributes(props.clientId);
            props.attributes.parentColor = tmpParentAttributes.color || '';
            props.attributes.parentMaxImgHeight = tmpParentAttributes.maxImageHeight || 0;

            //or use temp parent id
            var tmpParentColor = tmpParentAttributes.color || '';
            //var tmpParentMaxHeight = tmpParentAttributes.maxImageHeight || 0;
            
            //todo: Set the style based on this
            function onChangeColor( theEvent ) {
                props.setAttributes( { color: theEvent.target.value } );
            }
            
            function onChangeTitle( theEvent ) {
                props.setAttributes( { title: theEvent.target.value } );
            }
            function onChangeSubTitle( theEvent ) {
                props.setAttributes( { subTitle: theEvent.target.value } );
            }
            function onChangeText( theEvent ) {
                props.setAttributes( { text: theEvent.target.value } );
            }
            function onChangeURL( theURL, thePost ) {
                props.setAttributes( { url: theURL } );
            }
            

            var InspectorControls = wp.editor.InspectorControls;
            var PanelBody = wp.components.PanelBody;

            var attributes = props.attributes;

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

            

            // var tmpContent = [];
            // var tmpClass = 'ui card';
            // var tmpTitle = '';
            // var tmpAtt = props.attributes;
            // if( tmpAtt.color ){
            //     tmpClass += ' ' + tmpAtt.color
            // }
            // if( tmpAtt.title ){
            //     tmpTitle = tmpAtt.title;
            // }
            // if( tmpAtt.mediaURL ){
            //     tmpContent.push( tmpAE('div','image',el('img',{src:tmpAtt.mediaURL})));
            // }
            // if( tmpTitle == '' && tmpAtt.mediaURL == '' && tmpAtt.subTitle == ''  && tmpAtt.text == '' ){
            //     //EDIT ONLY
            //     tmpTitle = '** EDIT DETAILS ON SIDEBAR **';
            // }
            // var tmpMainContent = [];
            // if( tmpTitle ){
            //     tmpMainContent.push( tmpAE('div','header',tmpTitle) );
            // }
            // if( tmpAtt.subTitle ){
            //     tmpMainContent.push( tmpAE('div','meta',tmpAtt.subTitle) );
            // }
            // if( tmpAtt.text ){
            //     tmpMainContent.push( tmpAE('div','description',tmpAtt.text) );
            // }
            // tmpContent.push( tmpAE('div','content',tmpMainContent) );
            // var tmpExtraContent = [];

            // var tmpShowEl = tmpAE('div',tmpClass,tmpContent);
           
            var tmpShowEl = getDisplayValue(props,true);


            
            

            return el(
                'div',
                useBlockProps(),
                el(
                    InspectorControls,
                    null,
                    wp.element.createElement(PanelBody, {
                        title: 'Control Properties',
                        initialOpen: true,                    
                    },
                        [
                            BlockEditor.getOptionLabel('Card Title'),
                            BlockEditor.getTextControl(props.attributes.title,onChangeTitle),
                            BlockEditor.getOptionSep(),
                            BlockEditor.getOptionLabel('Card Sub Title'),
                            BlockEditor.getTextControl(props.attributes.subTitle,onChangeSubTitle),
                            BlockEditor.getOptionSep(),
                            BlockEditor.getOptionLabel('Card Text'),
                            BlockEditor.getTextControl(props.attributes.text,onChangeText),
                            BlockEditor.getOptionSep(),
                            
                            tmpParentColor ? '' : BlockEditor.getOptionLabel('Card Color'),
                            tmpParentColor ? '' : BlockEditor.getColorListControl(props.attributes.color,onChangeColor),
                            tmpParentColor ? '' : BlockEditor.getOptionSep(),                            
                            
                            el( 'div', {},
                            
                            el('div',{className:'ui label black fluid'},'Link URL'),
                            el(wp.editor.URLInput, {onChange: onChangeURL, value: props.attributes.url || ''},'Browse for Link'),
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
                            ),
                        ]
                    )
                ),
               
//                el('div',{className:'ui label fluid black'},'HEADER'),

                //el('div',{className:'ui card ' + props.attributes.color},props.attributes.text || '** ENTER TEXT ON SIDEBAR **')
                tmpShowEl
            );
        },
 
        save: function ( props ) {
            //var blockProps = useBlockProps.save();
            var tmpEl = getDisplayValue(props,false)
            return tmpEl;
        },

    } );
} )( window.wp, window.ActionAppCore );



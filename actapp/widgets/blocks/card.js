// Card control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;

	var MediaUpload = wp.editor.MediaUpload;
	var IconButton = wp.components.IconButton;

 
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
            mediaID: {
				type: 'number'
			},
			mediaURL: {
				type: 'string',
                default: ''
			}
        },
        edit: function ( props ) {
            function onChangeColor( theEvent ) {
                props.setAttributes( { color: theEvent.target.value } );
            }
            function onChangeText( theEvent ) {
                props.setAttributes( { text: theEvent.target.value } );
            }
            
            var BlockEditor = ActionAppCore.blocks.Editor;

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
                            BlockEditor.getOptionLabel('Card Text'),
                            BlockEditor.getTextControl(props.attributes.text,onChangeText),
                            BlockEditor.getOptionSep(),
                            BlockEditor.getOptionLabel('Card Color'),
                            BlockEditor.getColorListControl(props.attributes.color,onChangeColor),
                            BlockEditor.getOptionSep(),

                            el( 'div', {},
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
                                        // return el( IconButton, {                                            
                                        //     className: attributes.mediaID ? '' : 'ui button large blue',
                                        //     onClick: obj.open
                                        //     },
                                        //     ! attributes.mediaID ? 'Upload Image' : el( 'img', { src: attributes.mediaURL } )
                                        // );
                                        
                                    }
                                } )
                            ),
                        ]
                    )
                ),
               
//                el('div',{className:'ui label fluid black'},'HEADER'),

                el('div',{className:'ui card ' + props.attributes.color},props.attributes.text || '** ENTER TEXT ON SIDEBAR **')
            );
        },
 
        save: function ( props ) {
            return el('div',{className:'ui card ' + props.attributes.color},props.attributes.text)
        },

    } );
} )( window.wp, window.ActionAppCore );



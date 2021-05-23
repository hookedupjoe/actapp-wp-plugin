// Card control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
 
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
            color: {
                type: 'string',
                default: '',
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



// Header control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
 
    //--- How to use a SVG for the icon
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon('header');

    wp.blocks.registerBlockType( 'actappui/header', {
        title: 'Header',
        icon: iconEl,
        category: 'actappui',
        example: {
            attributes: {color: 'blue',text: 'Header Text', size: 'large'}
        },
        attributes: {
            text: {
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
                            BlockEditor.getOptionLabel('Header Text'),
                            BlockEditor.getTextControl(props.attributes.text,onChangeText),
                            BlockEditor.getOptionSep(),
                            BlockEditor.getOptionLabel('Header Color'),
                            BlockEditor.getColorListControl(props.attributes.color,onChangeColor),
                        ]
                    )
                ),
               
//                el('div',{className:'ui label fluid black'},'HEADER'),
                el('div',{className:'ui header ' + props.attributes.color},props.attributes.text)
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpHeader = '';
            
            return el(
                'div',                
                blockProps,
                el('div',{className:'ui header ' + props.attributes.color},props.attributes.text)
            );
        },

    } );
} )( window.wp, window.ActionAppCore );



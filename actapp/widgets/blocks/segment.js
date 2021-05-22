// segment control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
 
    //--- How to use a SVG for the icon
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon('segment');

    wp.blocks.registerBlockType( 'actappui/segment', {
        title: 'Content Segment',
        icon: iconEl,
        category: 'actappui',
        example: {
            attributes: {color: 'black'}
        },
        attributes: {
            color: {
                type: 'string',
                default: '',
            }            
        },
        edit: function ( props ) {
            function onChangeColor( theEvent ) {
                props.setAttributes( { color: theEvent.target.value } );
            }
            var ThisApp = window.ThisApp;
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
                        'Segment Color: ',
                        ActionAppCore.blocks.Editor.getColorListControl(props.attributes.color,onChangeColor)
                        ]
                    )
                ),
               
                el('div',{className:'ui segment ' + props.attributes.color},
                [
                    el(wp.blockEditor.InnerBlocks),
                ]
                )
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpHeader = '';
            
            return el(
                'div',                
                blockProps,
                [
                    el('div'),tmpHeader,
                        el('div',{className:'ui segment ' + props.attributes.color},                        [                    
                            el( wp.blockEditor.InnerBlocks.Content )
                        ]
                    )
                ]
            );
        },
    } );
} )( window.wp, window.ActionAppCore );



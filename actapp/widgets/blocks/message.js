// Message control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
 
    //--- How to use a SVG for the icon
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon('message');

    wp.blocks.registerBlockType( 'actappui/message', {
        title: 'Message Box',
        icon: iconEl,
        category: 'actappui',
        example: {
            attributes: {color: 'blue'}
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
          
            function onSetupClick(theEvent){
                ThisApp.input("What is the color?", "The Color", "Set Color", props.attributes.color || '')
                .then(function (theValue) {
                    if (!(theValue)) { return };
                    props.attributes.color = theValue;
                    BlockEditor.refreshBlockEditor();
                })
            }

            return el(
                'div',
                useBlockProps(),
                el('div',{onClick: onSetupClick, className:'ui button green basic fluid'},'Setup Details'),
                
                el(
                    InspectorControls,
                    null,
                    wp.element.createElement(PanelBody, {
                        title: 'Color',
                        initialOpen: true,                    
                    },
                        [
                        'Box Color: ',
                        ActionAppCore.blocks.Editor.getColorListControl(props.attributes.color,onChangeColor)
                        ]
                    )
                ),
               
                el('div',{className:'ui message ' + props.attributes.color},
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
                        el('div',{className:'ui message ' + props.attributes.color},                        [                    
                            el( wp.blockEditor.InnerBlocks.Content )
                        ]
                    )
                ]
            );
        },
    } );
} )( window.wp, window.ActionAppCore );



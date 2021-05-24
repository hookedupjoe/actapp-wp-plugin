// Message control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var BlockEditor = ActionAppCore.blocks.Editor;

    var info = {
        name: 'message',
        title: 'Message Box',
        example: {
            attributes: {color: 'blue'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon(info.name);

    BlockEditor.addStringAtts(info.atts,['color','size']);
    
    wp.blocks.registerBlockType( info.category + '/' + info.name, {
        title: info.title,
        icon: iconEl,
        category: info.category,
        example: info.example,
        attributes: info.atts,
        edit: function ( props ) {
            var InspectorControls = wp.editor.InspectorControls;
            var PanelBody = wp.components.PanelBody;
          
            
            var tmpAtts = props.attributes;

            var tmpCN = 'ui message';
            var tmpAtts = props.attributes;
            if( tmpAtts.color ){
                tmpCN += ' ' + tmpAtts.color
            }
            if( tmpAtts.size ){
                tmpCN += ' ' + tmpAtts.size
            }

            return el(
                'div',
                useBlockProps(),
                el(
                    InspectorControls,
                    null,
                    wp.element.createElement(PanelBody, {
                        title: 'Message Options',
                        initialOpen: true,                    
                    },
                        [
                            BlockEditor.getOptionLabel('Message Color'),
                            BlockEditor.getColorListControl(tmpAtts.color, function ( theEvent ) {
                                props.setAttributes( { color: theEvent.target.value } )
                            }),
                            BlockEditor.getOptionSep(),
                            BlockEditor.getOptionLabel('Size'),
                            BlockEditor.getSizeListControl(tmpAtts.size, function ( theEvent ) {
                                props.setAttributes( { size: theEvent.target.value } )
                            }),
                            BlockEditor.getOptionSep(),
                        ]
                    )
                ),
               
                el('div',{className:tmpCN},
                [
                    el(wp.blockEditor.InnerBlocks,{className: 'ui segment'}),
                ]
                )
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpCN = 'ui message';
            var tmpAtts = props.attributes;
            if( tmpAtts.color ){
                tmpCN += ' ' + tmpAtts.color
            }
            if( tmpAtts.size ){
                tmpCN += ' ' + tmpAtts.size
            }
            return el(
                'div',                
                blockProps,
                [
                    el('div',{className:tmpCN},[
                        el( wp.blockEditor.InnerBlocks.Content )
                    ]),
                ]
            );
        },
    } );
} )( window.wp, window.ActionAppCore );



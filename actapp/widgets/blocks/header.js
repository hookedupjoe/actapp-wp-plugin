// Message control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var BlockEditor = ActionAppCore.blocks.Editor;

    var info = {
        name: 'header',
        title: 'Header',
        example: {
            attributes: {color: 'blue',text: 'Header Text', size: 'large'}
        },
        category: 'actappui',
        atts: {}
    };
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon(info.name);
    BlockEditor.addStringAtts(info.atts,['text','color','size']);
    
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
            var tmpCN = 'ui header';
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
                            BlockEditor.getOptionLabel('Header Text'),
                            BlockEditor.getTextControl(tmpAtts.text,function ( theEvent ) {
                                props.setAttributes( { text: theEvent.target.value } )
                            }),
                            BlockEditor.getOptionSep(),

                            BlockEditor.getOptionLabel('Header Color'),
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
               
                el('div',{className:tmpCN},props.attributes.text),
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpCN = 'ui header';
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
                    el('div',{className:tmpCN},props.attributes.text),
                ]
            );
        },
    } );
} )( window.wp, window.ActionAppCore );


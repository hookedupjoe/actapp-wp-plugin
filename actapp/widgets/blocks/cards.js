// cards control from Semantic UI
( function ( wp, ActionAppCore ) {
    
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
 
    //--- How to use a SVG for the icon
    const iconEl = ActionAppCore.blocks.Editor.getControlIcon('cards');

    wp.blocks.registerBlockType( 'actappui/cards', {
        title: 'Cards Container',
        icon: iconEl,
        category: 'actappui',
        example: {
            attributes: {color: 'green'}
        },
        attributes: {
            columns: {
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
            function onChangeColumn( theEvent ) {
                props.setAttributes( { columns: theEvent.target.value } );
            }
            
            var BlockEditor = ActionAppCore.blocks.Editor;

            var InspectorControls = wp.editor.InspectorControls;
            var PanelBody = wp.components.PanelBody;
            var tmpUIColor = props.attributes.color || '';
            var tmpHeaderMsg = 'CARDS:';
            if( props.attributes.columns ){
                tmpHeaderMsg += " (" + props.attributes.columns + " columns)";
            } else {
                tmpHeaderMsg += " (columns auto-adjust )";
            }
            var tmpHdr = el('div',{className:'ui label fluid large ' + tmpUIColor},tmpHeaderMsg);
            var ALLOWED_BLOCKS = ['actappui/card'];
            return el('div', {className:'ui segment ' + tmpUIColor},null, tmpHdr ,el(
                'div',
                useBlockProps(),
                
                el(
                    InspectorControls,
                    null,
                    wp.element.createElement(PanelBody, {
                        title: 'Look and Feel Options',
                        initialOpen: true,                    
                    },
                        el('div',{className:'ui segment basic slim'},[
                            BlockEditor.getOptionLabel('Cards Color'),
                            BlockEditor.getColorListControl(props.attributes.color,onChangeColor),
                            BlockEditor.getOptionSep(),
                            BlockEditor.getOptionLabel('Columns'),
                            BlockEditor.getColumnListControl(props.attributes.columns,onChangeColumn)
                            ])
                    )
                ),
               
                el('div',{className:'edit-cards' + props.attributes.color + ' ' + props.attributes.columns},
                [
                    el(wp.blockEditor.InnerBlocks, {allowedBlocks: ALLOWED_BLOCKS}),
                ]
                )
            )
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpProps = {};

            if( props.attributes.columns == '' ){
                tmpProps["auto-adapt"] = "cards";
            } else {
                tmpProps["columns"] = props.attributes.columns;
            }


            var tmpClasses = 'ui cards';
            if( props.attributes.color != ''){
                tmpClasses += ' ' + props.attributes.color;
            }
            if( props.attributes.columns != ''){
                tmpClasses += ' ' + props.attributes.columns;
            }

            tmpProps.className = tmpClasses;

            return el(
                'div',                
                blockProps,
                el('div',tmpProps,
                el( wp.blockEditor.InnerBlocks.Content )
                )
            );
        },
    } );
} )( window.wp, window.ActionAppCore );





( function ( blocks, blockEditor, element, richText, data, ServerSideRender) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var AlignmentToolbar = blockEditor.AlignmentToolbar;
    var BlockControls = blockEditor.BlockControls;
    var useBlockProps = blockEditor.useBlockProps;
 
    const iconEl = el('svg', { width: 20, height: 20 },
        el('path', { d: "M12.5,12H12v-0.5c0-0.3-0.2-0.5-0.5-0.5H11V6h1l1-2c-1,0.1-2,0.1-3,0C9.2,3.4,8.6,2.8,8,2V1.5C8,1.2,7.8,1,7.5,1 S7,1.2,7,1.5V2C6.4,2.8,5.8,3.4,5,4C4,4.1,3,4.1,2,4l1,2h1v5c0,0-0.5,0-0.5,0C3.2,11,3,11.2,3,11.5V12H2.5C2.2,12,2,12.2,2,12.5V13 h11v-0.5C13,12.2,12.8,12,12.5,12z M7,11H5V6h2V11z M10,11H8V6h2V11z" } )
    );

    blocks.registerBlockType( 'gutenberg-examples/example-04-controls', {
        title: 'Message Box',
        icon: iconEl,
        category: 'actappui',
        attributes: {
            content: {
                type: 'array',
                source: 'children',
                selector: 'p',
            },
            alignment: {
                type: 'string',
                default: 'none',
            },
            message: {
                type: 'string',
                default: '',
            }
        },
        edit: function ( props ) {
            var content = props.attributes.content;
            var alignment = props.attributes.alignment;
 
            function onChangeContent( newContent ) {
                props.setAttributes( { content: newContent } );
            }

            function onChangeMessage( theEvent ) {
                props.setAttributes( { message: theEvent.target.value } );
            }
 
            function onChangeAlignment( newAlignment ) {
                props.setAttributes( {
                    alignment:
                        newAlignment === undefined ? 'none' : newAlignment,
                } );
            }

            var InspectorControls = wp.editor.InspectorControls;
            var PanelBody = wp.components.PanelBody;

            var tmpHeader = '';
            if( props.attributes.message != ''){
                tmpHeader = el('div',{className:'ui header blue'},['' + props.attributes.message]);
            }

          
            return el(
                'div',
                useBlockProps(),
                
            wp.element.createElement(
                InspectorControls,
                null,
                wp.element.createElement(PanelBody, {
                    title: 'Example Control Options',
                    initialOpen: true,                    
                },['Title: ',wp.element.createElement('input',{value: '' + props.attributes.message, onChange: onChangeMessage})])
            ),
                el(
                    BlockControls,
                    { key: 'controls' },
                    [
                        el( AlignmentToolbar, {
                        value: alignment,
                        onChange: onChangeAlignment,
                        })
                    ]   
                ),
                el('div'),
                tmpHeader,
                el('div',{className:'ui message blue'},[el( RichText, {
                    key: 'richtext',
                    tagName: 'p',
                    style: { textAlign: alignment },
                    onChange: onChangeContent,
                    value: content,
                } ),
                el(wp.blockEditor.InnerBlocks),
            
            ]
            
            )
            );
        },
 
        save: function ( props ) {
            var blockProps = useBlockProps.save();
            var tmpHeader = '';
            if( props.attributes.message != ''){
                tmpHeader = el('div',{className:'ui header blue'},['' + props.attributes.message]);
            }

            
            return el(
                'div',                
                blockProps,
                [el('div'),tmpHeader,
                    el('div',{className:'ui message blue'},[
                    el( RichText.Content, {
                    tagName: 'p',
                    className:
                        'gutenberg-examples-align-' +
                        props.attributes.alignment,
                    value: props.attributes.content,
                } ),
                el( window.wp.blockEditor.InnerBlocks.Content )
            ])]
            );
        },
    } );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element );





//====


( function ( blocks, element, blockEditor ) {
    var el = element.createElement;
    var InnerBlocks = blockEditor.InnerBlocks;
    var useBlockProps = blockEditor.useBlockProps;
 
    blocks.registerBlockType( 'gutenberg-examples/example-06', {
        title: 'Example: Inner Blocks',
        category: 'actappui',
 
        edit: function () {
            var blockProps = useBlockProps();
 
            return el('div',{className:'ui segment green'},[el( 'div', blockProps, el( InnerBlocks ) )]);
        },
 
        save: function () {
            var blockProps = useBlockProps.save();
            return el( 'div', blockProps, [el('div'),el('div',{className:'ui segment green'},[el( InnerBlocks.Content )])] );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor );





( function ( blocks, element, blockEditor ) {
    var el = element.createElement;
    var InnerBlocks = blockEditor.InnerBlocks;
    var useBlockProps = blockEditor.useBlockProps;
 
    blocks.registerBlockType( 'actapp/sem-cards', {
        title: 'Cards',
        category: 'actappui',
 
        edit: function () {
            var blockProps = useBlockProps();
            return el('div',{className:'ui cards three'},[el( 'div', blockProps, el( InnerBlocks ) )]);
        },
 
        save: function () {
            var blockProps = useBlockProps.save();
            var tmpClassName = 'ui cards';
            tmpClassName += ' three';
            return el( 'div', blockProps, [el('div'),el('div',{className:tmpClassName},[el( InnerBlocks.Content )])] );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor );





//===





( function ( blocks, element, data, blockEditor ) {
    var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        withSelect = data.withSelect,
        InnerBlocks = blockEditor.InnerBlocks,
        useBlockProps = blockEditor.useBlockProps;
 
    registerBlockType( 'actapp/dynocard', {
        apiVersion: 2,
        title: 'Card',
        icon: 'megaphone',
        category: 'actappui',
        edit: function () {
            var blockProps = useBlockProps();
            return el('div',{className:'card'},[el( 'div', blockProps, el( InnerBlocks ) )]);
        }
        
    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);





//-----







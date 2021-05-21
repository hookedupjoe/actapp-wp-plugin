wp.blocks.registerBlockType( 'actapp/who', {
    title: 'Who',
    category: 'common',
    icon: 'admin-users',
    attributes: {
        who: {
            type: 'string',
            selector: 'p',
            attribute: 'who',
        },
    },
    edit: function( props ) {
        var attributes = props.attributes,
            setAttributes = props.setAttributes,
            className = props.className,
            id = props.id;

        // Set default “who” attribute value.
        if ( ! attributes.hasOwnProperty( 'who' ) ) {
            setAttributes( { who: 'Roy' } );
        }

        // Change event for form input
        var whoChange = function( event ) {
            setAttributes( { who: event.target.value } );
        };

        // Create block UI using WordPress createElement
        return React.createElement(
            'div',
            { className: className },
            [

                React.createElement(
                    'p',
                    {
                        who: attributes.who
                    },
                    'Who' + ': ' + attributes.who
                ),
                React.createElement(
                    'div',
                    {

                    },
                    [
                        React.createElement(
                            'label',
                            {
                                for: id + '-control'
                            },
                            'Who: '
                        ),
                        React.createElement(
                            'input',
                            {
                                id: id + '-control',
                                value: attributes.who,
                                onChange: whoChange
                            }
                        ),
                    ]

                ),

            ]
        );
    },
    save: function( props, className ) {
        var attributes = props.attributes;
        var who = attributes.who || 'no one at all';
        return React.createElement(
            'p',
            {
                className:className,
                who: attributes.who
            },
            'Who' + ': ' + who,
        );
    }
} );













//==================================================














( function ( blocks, blockEditor, element ) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var AlignmentToolbar = blockEditor.AlignmentToolbar;
    var BlockControls = blockEditor.BlockControls;
    var useBlockProps = blockEditor.useBlockProps;
 
    blocks.registerBlockType( 'gutenberg-examples/example-04-controls', {
        title: 'Example: Controls',
        icon: 'universal-access-alt',
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
                default: 'none',
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
                el(wp.blockEditor.InnerBlocks)
            ])
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


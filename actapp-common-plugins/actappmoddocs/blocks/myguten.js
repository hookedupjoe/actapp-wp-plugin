( function ( wp ) {
    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var TextControl = wp.components.TextControl;
    var useSelect = wp.data.useSelect;
    var useEntityProp = wp.coreData.useEntityProp;
    var useBlockProps = wp.blockEditor.useBlockProps;
 
    registerBlockType( 'myguten/meta-block', {
        title: 'Meta Block',
        icon: 'smiley',
        category: 'text',
 
        edit: function ( props ) {
            var blockProps = useBlockProps();
            var postType = useSelect( function ( select ) {
                return select( 'core/editor' ).getCurrentPostType();
            }, [] );
            var entityProp = useEntityProp( 'postType', postType, 'meta' );
            var meta = entityProp[ 0 ];
            var setMeta = entityProp[ 1 ];
 
            var metaFieldValue = meta[ 'myguten_meta_block_field' ];
            function updateMetaValue( newValue ) {
                setMeta(
                    Object.assign( {}, meta, {
                        myguten_meta_block_field: newValue,
                    } )
                );
            }
 
            return el(
                'div',
                blockProps,
                el( TextControl, {
                    label: 'Meta Block Field',
                    value: metaFieldValue,
                    onChange: updateMetaValue,
                } )
            );
        },
 
        // No information saved to the block
        // Data is saved to post meta via attributes
        save: function () {
            return null;
        },
    } );
} )( window.wp );
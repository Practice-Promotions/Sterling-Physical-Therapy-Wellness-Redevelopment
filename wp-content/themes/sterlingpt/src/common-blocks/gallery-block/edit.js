import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {

    return (
        <div {...useBlockProps({ className: 'alignfull' })}>
            <InnerBlocks
                template={[
                    ['core/gallery', {
                        columns: 3,
                        imageCrop: false,
                        linkTo: 'media',
                        className: 'gallery-with-popup',
                    },
                    ],
                ]}
            />
        </div>
    );
}
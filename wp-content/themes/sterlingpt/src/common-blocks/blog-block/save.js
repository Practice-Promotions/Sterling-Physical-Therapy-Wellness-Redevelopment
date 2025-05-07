import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

import './style.scss';

export default function save({ attributes }) {
    const { postUrl } = attributes;

    return (
        <div {...useBlockProps.save()} className="alignwide">
           	<InnerBlocks.Content />
        </div>
    );
}

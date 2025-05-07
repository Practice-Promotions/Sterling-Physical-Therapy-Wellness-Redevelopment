import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit() {
    const allowedBlocks = ['core/site-title'];  // Restrict to the wp:site-title block

    return (
        <div {...useBlockProps()} className="copyright-site-title">
            <p>© <InnerBlocks allowedBlocks={allowedBlocks} /> 2024</p>
        </div>
    );
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit({}) {

    return (
        <div {...useBlockProps()} className="alignfull header-notification">
           <h2> Header Address Bar Goes Here </h2>
        </div>
    );
}

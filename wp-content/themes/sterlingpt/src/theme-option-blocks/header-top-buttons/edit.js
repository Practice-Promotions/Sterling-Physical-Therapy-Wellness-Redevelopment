import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit({}) {

    return (
        <div {...useBlockProps()}>
            <ul class="header-button">
                <li><a href="javascript:void(0);" class="wp-block-button__link" role="button">Call Now</a></li>
                <li><a href="javascript:void(0);" class="wp-block-button__link" role="button" target="_blank">Pay Now</a></li>
                <li><a href="javascript:void(0);" class="wp-block-button__link" role="button">Review Us</a></li>
                <li><a href="javascript:void(0);" class="wp-block-button__link" role="button">Request Appointment</a></li>
            </ul>
        </div>
    );
}

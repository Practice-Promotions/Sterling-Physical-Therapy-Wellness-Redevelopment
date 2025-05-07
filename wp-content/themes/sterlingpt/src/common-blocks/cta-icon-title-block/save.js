import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

//import './style.scss';

export default function save({ attributes }) {

	const { columnUrl, alignment, borderstyle } = attributes;

    const setAlignmentClass = (alignment) => {
        switch (alignment) {
            case 'left':
                return 'align-left';
            case 'center':
                return 'align-center';
            case 'right':
                return 'align-right';
            default:
                return '';
        }
    };

    return (
        <div { ...useBlockProps.save({ className: `cta-item ${setAlignmentClass(alignment)}` }) }>
            {columnUrl ? (
                <a href={ columnUrl } className="cta-item-inner">
                    <InnerBlocks.Content />
                </a>
            ) : (
                <div className="cta-item-inner">
                     <InnerBlocks.Content />
                </div>
            )}
        </div>
    );
}

import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {

	const { columnUrl, alignment } = attributes;

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
        <div { ...useBlockProps.save({ className: `alignfull ${setAlignmentClass(alignment)}` }) }>
            {columnUrl ? (
                <a href={ columnUrl } className="cta-link">
                    <InnerBlocks.Content />
                </a>
            ) : (
                <InnerBlocks.Content />
            )}
        </div>
    );
}

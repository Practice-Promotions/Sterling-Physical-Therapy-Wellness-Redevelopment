import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { alignment } = attributes;

    const blockClassName = `section-header ${alignment ? 'center-align-mobile' : ''}`.trim();

    return (
		<div {...useBlockProps.save()} className={blockClassName}>
			<InnerBlocks.Content />
		</div>
    );
}

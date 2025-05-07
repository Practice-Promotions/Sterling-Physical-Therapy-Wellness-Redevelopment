import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function deprecatedSave({ attributes }) {

	const { columnUrl } = attributes;

	return (
		<div { ...useBlockProps.save({ className: 'alignfull' }) }>
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

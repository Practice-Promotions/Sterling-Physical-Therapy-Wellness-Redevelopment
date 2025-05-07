import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<h3>Block: Job Listing</h3>
			<p>The Job Listing has been successfully added. You can preview the design on the frontend page.</p>
		</div>
	);
}

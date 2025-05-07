import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<h3>Block: Recent Post Listing</h3>
			<p>This Is a Recent Post Listing Block</p>
		</div>
	);
}

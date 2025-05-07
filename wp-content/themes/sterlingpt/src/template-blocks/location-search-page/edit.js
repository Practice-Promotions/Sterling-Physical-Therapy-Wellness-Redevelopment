import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<h3>Block: Location Search Page</h3>
			<p>The location search has been successfully added. After</p>
			<p>publishing the page, you can view the results on the front end of the site.</p>
		</div>
	);
}

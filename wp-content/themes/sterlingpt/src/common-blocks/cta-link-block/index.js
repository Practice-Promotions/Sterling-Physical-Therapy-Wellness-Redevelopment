// index.js
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import save from './save';
import deprecatedSave from './deprecated';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: Edit,
	save,
	deprecated: [
		{
			attributes: {
				linkType: {
					type: 'string',
					default: ''
				},
				pageLink: {
					type: 'string',
					default: ''
				},
				externalLink: {
					type: 'string',
					default: ''
				}
			},
			save: deprecatedSave,
		}
	]
});

// index.js
import { registerBlockType } from '@wordpress/blocks';

import './style.scss';
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
				columnUrl: {
					type: 'string',
					default: ''
				},
				alignment: {
					type: 'string',
					default: ''
				},
				borderstyle: {
					type: 'string',
					default: ''
				}
			},
			save: deprecatedSave,
		}
	]
});

import { registerBlockType } from '@wordpress/blocks';

import './style.scss';

import Edit from './edit';
import save from './save';
import deprecatedSave from './deprecated';
import metadata from './block.json';

// registerBlockType( metadata.name, {
// 	/**
// 	 * @see ./edit.js
// 	 */
// 	edit: Edit,
// 	/**
// 	 * @see ./save.js
// 	 */
// 	save,
// 	example :{}
// } );

registerBlockType(metadata.name, {
	edit: Edit,
	save,
	deprecated: [
		{
			save: deprecatedSave, // Older version save function
			attributes: {
				columnUrl: {
					type: 'string',
					default: '',
				},
			},
			supports: {
				html: false,
			},
		},
	],
});

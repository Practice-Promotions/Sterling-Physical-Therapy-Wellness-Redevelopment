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
				items: {
					type: 'array',
					default: [
						{
							title: 'New Title',
							content: 'New Content'
						}
					]
				},
				layout: {
					type: 'string',
					default: 'single'
				}
			},
			save: deprecatedSave,
		}
	]
});

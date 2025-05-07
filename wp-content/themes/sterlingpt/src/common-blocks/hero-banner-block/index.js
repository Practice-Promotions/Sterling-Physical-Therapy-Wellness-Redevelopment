import { registerBlockType } from '@wordpress/blocks';

import './style.scss';

import Edit from './edit';
import save from './save';
import deprecatedSave from './deprecated';
import metadata from './block.json';

registerBlockType( metadata.name, {
    ...metadata,
    edit: Edit,
    save: save,
    deprecated: [
        {
            attributes: {
                content: {
                    type: 'string',
                    default: '',
                },
                className: {
                    type: 'string',
                },
                style: {
                    type: 'object',
                }
            },
            save: deprecatedSave,
        }
    ]
});

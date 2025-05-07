import { registerBlockType } from '@wordpress/blocks';

import Edit from './edit';
import save from './save';
import deprecatedVersion1 from './deprecated'; // Import deprecated version
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
            save: deprecatedVersion1,
        }
    ]
});

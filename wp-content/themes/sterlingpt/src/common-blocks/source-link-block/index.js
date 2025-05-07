import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';  
import './editor.scss';

registerBlockType('ppcoreblocks/source-link-block', {
    edit: Edit,
    save: Save,
});

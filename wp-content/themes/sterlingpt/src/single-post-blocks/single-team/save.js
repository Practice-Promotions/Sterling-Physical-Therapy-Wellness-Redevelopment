import { __ } from '@wordpress/i18n';

import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
    return (
        <div { ...useBlockProps.save() } className={ 'alignwide' }>
            <div className="staff-member-list">
                {/* InnerBlocks content will be rendered here dynamically on the server-side */}
                <InnerBlocks.Content />
            </div>
        </div>
    );
}

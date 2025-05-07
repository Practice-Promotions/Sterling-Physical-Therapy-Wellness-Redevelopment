import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function DeprecatedSaveV1() {
    return (
        <div { ...useBlockProps.save({ className: 'alignfull' }) }>
            <InnerBlocks.Content />
        </div>
    );
}

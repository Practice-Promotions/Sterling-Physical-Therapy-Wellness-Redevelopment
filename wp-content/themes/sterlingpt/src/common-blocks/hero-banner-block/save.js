import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save() {
	return (
		<section { ...useBlockProps.save() } className={ 'alignfull hero-banner-section' }>
            <InnerBlocks.Content />
        </section>
	);
}

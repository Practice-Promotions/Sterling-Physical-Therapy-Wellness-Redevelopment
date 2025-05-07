import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {

	const { linkType, pageLink, externalLink } = attributes;

    // Determine the final URL to be used
    let linkUrl = '';
    let linkTarget = '';

    if (linkType === 'page' && pageLink) {
        linkUrl = pageLink;  // Use selected page link
    } else if (linkType === 'external' && externalLink) {
        linkUrl = externalLink;  // Use the external URL
        linkTarget = '_blank';  // Set target to _blank for external links
    }

    return (
        <div { ...useBlockProps.save() }>
            {linkUrl ? (
                <a href={linkUrl} className="cta-link" target={linkTarget}>
                    <InnerBlocks.Content />
                </a>
            ) : (
                <a href="javascript:void(0);" className="cta-link">
                     <InnerBlocks.Content />
                </a>
            )}
        </div>
    );
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { linkType, pageLink, externalLink, selectionType, popupId } = attributes;

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
        <div {...useBlockProps.save({ className: 'cta-item' })}>
            {selectionType === 'popup' ? (
                // If "popup" is selected, show the popup link
                popupId ? (
                    <a href={`#${popupId}`} className="cta-link cta-link-popup">
                        <InnerBlocks.Content />
                    </a>
                ) : (
                    <a href="javascript:void(0);" className="cta-link">
                        <InnerBlocks.Content />
                    </a>
                )
            ) : selectionType === 'page-or-link' ? (
                // If "page-or-link" is selected, show the link based on linkType
                linkUrl ? (
                    <a href={linkUrl} className="cta-link" target={linkTarget}>
                        <InnerBlocks.Content />
                    </a>
                ) : (
                    <a href="javascript:void(0);" className="cta-link">
                        <InnerBlocks.Content />
                    </a>
                )
            ) : (
                // Default case (if none of the above)
                <a href="javascript:void(0);" className="cta-link">
                    <InnerBlocks.Content />
                </a>
            )}
        </div>
    );
}

import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit({ attributes, context: { postId, postType: postTypeSlug }, setAttributes }) {
    const blockProps = useBlockProps(); // Get block props for applying block-specific styles and attributes

    const post = useSelect((select) => {
        return select('core').getEntityRecord('postType', postTypeSlug, postId);
    }, [postTypeSlug, postId]);

    // Ensure the post is loaded and has meta data
    const newsletterUrl = post?.meta?._newsletter_url || ''; // If _newsletter_url is undefined, use an empty string
    const postLink = post?.link || ''; // If post.link is undefined, use an empty string

    // If newsletterUrl is blank, set it to the postLink
    const finalNewsletterUrl = newsletterUrl || postLink;

    // Set the final newsletter URL in attributes if it is different from the current one
    if (finalNewsletterUrl !== attributes.newsletter_url) {
        setAttributes({ newsletter_url: finalNewsletterUrl });
    }

    // Placeholder value for the button
    const NewsletterButton = __('Newsletter Button', 'sterlingpt');

    // Render the block editor UI
    return (
        <div {...blockProps}>
            <a href="#" class="wp-block-button__link wp-element-button">{NewsletterButton}</a>
        </div>
    );
}

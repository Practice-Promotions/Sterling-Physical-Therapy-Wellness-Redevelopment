import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function Edit({ attributes, context: { postId, postType: postTypeSlug }, setAttributes }) {

    const blockProps = useBlockProps();
    
    const post = useSelect((select) => {
        return select('core').getEntityRecord('postType', postTypeSlug, postId);
    }, [postTypeSlug, postId]);

    const team_education = post?.team_education;

    // Update block attributes if the fetched 'team_education' differs from current attributes
    if (team_education !== undefined && team_education !== attributes.team_education) {
        setAttributes({ team_education });
    } else if (team_education === undefined && attributes.team_education !== '') {
        // Set team_education to an empty string if it's undefined
        setAttributes({ team_education: '' });
    }

    // Render the block editor UI
    return (
        <div {...blockProps}>
          <RichText
              tagName="p" // Specify the tag name
              value={attributes.team_education} // Use block attribute for value
              style={{ textAlign: attributes.align }}
          />
        </div>
    );
}
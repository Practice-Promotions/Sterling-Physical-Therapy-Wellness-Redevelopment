import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps} from '@wordpress/block-editor';

export default function Edit({ attributes, context: { postId, postType: postTypeSlug }, setAttributes }) {
    const blockProps = useBlockProps();

    const post = useSelect((select) => {
        return select('core').getEntityRecord('postType', postTypeSlug, postId);
    }, [postTypeSlug, postId]);

    const team_education = post?.team_education;

    // Update block attributes if the fetched values differ from current attributes
    if (team_education !== undefined && team_education !== attributes.team_education) {
        setAttributes({ team_education });
    } else if (team_education === undefined && attributes.team_education !== '') {
        setAttributes({ team_education: '' });
    }
    // Placeholder values
    const TeamDesignation = __('Team Designation', 'sterlingpt');

    // Render the block editor UI
    return (
        <div {...blockProps}>

              {TeamDesignation ? (
                <p>
                {TeamDesignation}
            </p>
            ) : (
                <p>
                    {TeamDesignation}
                </p>
            )}
        </div>
    );
}

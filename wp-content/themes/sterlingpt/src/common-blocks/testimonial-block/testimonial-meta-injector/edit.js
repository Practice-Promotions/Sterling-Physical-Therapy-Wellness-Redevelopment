import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';

import { useBlockProps } from '@wordpress/block-editor';

import { PanelBody, ToggleControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';


export default function Edit({ attributes, context: { postId, postType: postTypeSlug }, setAttributes }) {

    const post = useSelect((select) => {
        return select('core').getEntityRecord('postType', postTypeSlug, postId);
    }, [postTypeSlug, postId]);

    const {
        _testimonial_title: testimonial_title,
    } = post?.meta || {};

    // Update block attributes if the fetched 'testimonial_title' differs from current attributes
    if (testimonial_title !== undefined && testimonial_title !== attributes.testimonial_title) {
        setAttributes({ testimonial_title });
    } else if (testimonial_title === undefined && attributes.testimonial_title !== '') {
        // Set testimonial_title to an empty string if it's undefined
        setAttributes({ testimonial_title: '' });
    }

    const { enable_testimonial_title } = attributes;

    const onToggleEnableTitle = (newValue) => {
        setAttributes({ enable_testimonial_title: newValue });
    };

    // Render the block editor UI
    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Icon Style Settings', 'sterlingpt')}>
                    <ToggleControl
                        label={__('Enable Testimonial Title', 'sterlingpt')}
                        checked={enable_testimonial_title}
                        onChange={onToggleEnableTitle}
                    />
                </PanelBody>
            </InspectorControls>
            <div className='quote-title'>
                {enable_testimonial_title && (
                    <p className="testimonial-title">
                        {testimonial_title ? testimonial_title : 'Custom Testimonial Title'}
                    </p>
                )}
            </div>
        </>
    );
}

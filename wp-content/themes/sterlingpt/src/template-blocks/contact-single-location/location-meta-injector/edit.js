import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

export default function Edit({ attributes, context: { postId, postType: postTypeSlug }, setAttributes }) {

    const blockProps = useBlockProps(); // Get block props for applying block-specific styles and attributes

    const post = useSelect((select) => {
        return select('core').getEntityRecord('postType', postTypeSlug, postId);
    }, [postTypeSlug, postId]);

    // Destructure the relevant keys from the post object
    const {
        _location_custom_title: location_custom_title,
        _location_phone_number: location_phone_number,
        _location_fax_number: location_fax_number,
        _location_email: location_email,
        _location_address: location_address,
        _location_map_link: location_map_link,
        _location_working_hours: location_working_hours,
        _location_map_iframe: location_map_iframe
    } = post?.meta || {};

    const location_link = post.link;
    const location_title = post.title.raw;

    // Update block attributes if the fetched 'location_custom_title' differs from current attributes
    if (location_map_iframe !== undefined && location_map_iframe !== attributes.location_map_iframe) {
        setAttributes({ location_map_iframe });
    } else if (location_map_iframe === undefined && attributes.location_map_iframe !== '') {
        // Set location_map_iframe to an empty string if it's undefined
        setAttributes({ location_map_iframe: '' });
    }

    // Update block attributes if the fetched 'location_custom_title' differs from current attributes
    if (location_custom_title !== undefined && location_custom_title !== attributes.location_custom_title) {
        setAttributes({ location_custom_title });
    } else if (location_custom_title === undefined && attributes.location_custom_title !== '') {
        // Set location_custom_title to an empty string if it's undefined
        setAttributes({ location_custom_title: '' });
    }

    // Update block attributes if the fetched 'location_phone_number' differs from current attributes
    if (location_phone_number !== undefined && location_phone_number !== attributes.location_phone_number) {
        setAttributes({ location_phone_number });
    } else if (location_phone_number === undefined && attributes.location_phone_number !== '') {
        // Set location_phone_number to an empty string if it's undefined
        setAttributes({ location_phone_number: '' });
    }

    // Update block attributes if the fetched 'location_fax_number' differs from current attributes
    if (location_fax_number !== undefined && location_fax_number !== attributes.location_fax_number) {
        setAttributes({ location_fax_number });
    } else if (location_fax_number === undefined && attributes.location_fax_number !== '') {
        // Set location_fax_number to an empty string if it's undefined
        setAttributes({ location_fax_number: '' });
    }

    // Update block attributes if the fetched 'location_email' differs from current attributes
    if (location_email !== undefined && location_email !== attributes.location_email) {
        setAttributes({ location_email });
    } else if (location_email === undefined && attributes.location_email !== '') {
        // Set location_email to an empty string if it's undefined
        setAttributes({ location_email: '' });
    }

    // Update block attributes if the fetched 'location_address' differs from current attributes
    if (location_address !== undefined && location_address !== attributes.location_address) {
        setAttributes({ location_address });
    } else if (location_address === undefined && attributes.location_address !== '') {
        // Set location_address to an empty string if it's undefined
        setAttributes({ location_address: '' });
    }

    // Update block attributes if the fetched 'location_map_link' differs from current attributes
    if (location_map_link !== undefined && location_map_link !== attributes.location_map_link) {
        setAttributes({ location_map_link });
    } else if (location_map_link === undefined && attributes.location_map_link !== '') {
        // Set location_map_link to an empty string if it's undefined
        setAttributes({ location_map_link: '' });
    }

    // Update block attributes if the fetched 'location_working_hours' differs from current attributes
    if (location_working_hours !== undefined && location_working_hours !== attributes.location_working_hours) {
        setAttributes({ location_working_hours });
    } else if (location_working_hours === undefined && attributes.location_working_hours !== '') {
        // Set location_working_hours to an empty string if it's undefined
        setAttributes({ location_working_hours: '' });
    }

    // Set location_link and location_title in attributes
    if (location_link !== undefined && location_link !== attributes.location_link) {
        setAttributes({ location_link });
    } else if (location_link === undefined && attributes.location_link !== '') {
        setAttributes({ location_link: '' });
    }

    if (location_title !== undefined && location_title !== attributes.location_title) {
        setAttributes({ location_title });
    } else if (location_title === undefined && attributes.location_title !== '') {
        setAttributes({ location_title: '' });
    }

    // Render the block editor UI
    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Label Visibility Settings', 'parksidephysio')}>
                    <ToggleControl
                        label={__('Show Address', 'parksidephysio')}
                        checked={attributes.enable_address_label}
                        onChange={(value) => setAttributes({ enable_address_label: value })}
                    />
                    <ToggleControl
                        label={__('Show Business Hours', 'parksidephysio')}
                        checked={attributes.enable_working_hours_label}
                        onChange={(value) => setAttributes({ enable_working_hours_label: value })}
                    />
                </PanelBody>
                <PanelBody title={__('Meta Visibility Settings', 'parksidephysio')}>
                    <ToggleControl
                        label={__('Show Custom Title Or Title', 'parksidephysio')}
                        checked={attributes.enable_location_title}
                        onChange={(value) => setAttributes({ enable_location_title: value })}
                    />
                    <ToggleControl
                        label={__('Show Map', 'parksidephysio')}
                        checked={attributes.enable_location_map}
                        onChange={(value) => setAttributes({ enable_location_map: value })}
                    />
                    <ToggleControl
                        label={__('Show Email', 'parksidephysio')}
                        checked={attributes.enable_location_email}
                        onChange={(value) => setAttributes({ enable_location_email: value })}
                    />
                    <ToggleControl
                        label={__('Show Phone Number', 'parksidephysio')}
                        checked={attributes.enable_location_phone_number}
                        onChange={(value) => setAttributes({ enable_location_phone_number: value })}
                    />
                    <ToggleControl
                        label={__('Show Fax Number', 'parksidephysio')}
                        checked={attributes.enable_location_fax_number}
                        onChange={(value) => setAttributes({ enable_location_fax_number: value })}
                    />
                    <ToggleControl
                        label={__('Show Address', 'parksidephysio')}
                        checked={attributes.enable_location_address}
                        onChange={(value) => setAttributes({ enable_location_address: value })}
                    />
                    <ToggleControl
                        label={__('Show Business Hours', 'parksidephysio')}
                        checked={attributes.enable_location_working_hours}
                        onChange={(value) => setAttributes({ enable_location_working_hours: value })}
                    />
                    <ToggleControl
                        label={__('Show Map Link', 'parksidephysio')}
                        checked={attributes.enable_location_map_link}
                        onChange={(value) => setAttributes({ enable_location_map_link: value })}
                    />
                </PanelBody>
            </InspectorControls>
            {/* Render the block UI */}
            <div {...blockProps}>
                <div className='address'>
                    {attributes.enable_address_label && (
                        <h5 className='label'> Address </h5>
                    )}                    
                    {attributes.enable_location_title && location_custom_title && (
                        <div className="location-map">
                           <h2>{location_custom_title}</h2>
                        </div>
                    )}
                    {attributes.enable_location_map && location_map_iframe && (
                        <div className="location-map">
                            <iframe src={location_map_iframe} title="locations-map"></iframe>
                        </div>
                    )}
                    {attributes.enable_location_email && location_email && (
                        <p className="icon-envelop">
                            <a rel="noreferrer" href={`mailto:${location_email}`} target="_blank" aria-label="Location Email (opens in a new tab)">
                                {location_email}
                            </a>
                        </p>
                    )}
                    {attributes.enable_location_phone_number && location_phone_number && (
                        <p className="icon-phone">
                            <a href={`tel:${location_phone_number.replace(/[^0-9]/g, '')}`}>
                                {location_phone_number}
                            </a>
                        </p>
                    )}
                    {attributes.enable_location_fax_number && location_fax_number && (
                        <p className="icon-fax">
                            <a href={`tel:${location_fax_number.replace(/[^0-9]/g, '')}`}>
                                {location_fax_number}
                            </a>
                        </p>
                    )}
                    {attributes.enable_location_address && location_address && (
                        <p className="icon-pin">
                            <a rel="noreferrer" href={location_map_link} target="_blank" aria-label="Location Address (opens in a new tab)">
                                {location_address}
                            </a>
                        </p>
                    )}
                    {attributes.enable_location_working_hours && location_working_hours && (
                        <div className="business-hours">
                            {attributes.enable_working_hours_label && (
                                <h5 className='label'> Business Hours </h5>
                            )}
                            <p className="icon-timer">
                                <span className=''>{location_working_hours}</span>
                            </p>
                        </div>
                    )}
                    {attributes.enable_location_map_link && location_link && (
                        <div className="location-action">
                            <a href={location_link} title={location_title} className="btn-link" aria-label="Location Info">
                                {__('Location Info', 'parksidephysio')}
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
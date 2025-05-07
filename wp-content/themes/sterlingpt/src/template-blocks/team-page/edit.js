import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useEffect } from 'react';


export default function Edit({ attributes, setAttributes }) {
    const { teamSelectType } = attributes;

    // Set default value if not set
    useEffect(() => {
        if (!teamSelectType) {
            setAttributes({ teamSelectType: 'team-category-listing' });
        }
    }, [teamSelectType, setAttributes]);

    const handleChange = (value) => {
        setAttributes({ teamSelectType: value });
    };


	const themeUrl = `${window.location.origin}/wp-content/themes/sterlingpt`;

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('Team Layout Type', 'sterlingpt')}>
                    <SelectControl
                        label={__('Select Team Type', 'sterlingpt')}
                        value={teamSelectType}
                        options={[
                            { label: __('Team Category Listing', 'sterlingpt'), value: 'team-category-listing' },
                            { label: __('Team Category Filter', 'sterlingpt'), value: 'team-category-filter' },
                            { label: __('Team Location Filter', 'sterlingpt'), value: 'team-location-filter' },
                        ]}
                        onChange={handleChange}
                    />
                </PanelBody>
            </InspectorControls>

            {teamSelectType === 'team-category-listing' && (
                <div className="team-listing">
                    <div className="team-layout-item">
                        <h4>Team Category Listing</h4>
						<div className="team-layout-thumb">
                            <img src={`${themeUrl}/src/template-blocks/team-page/media/placeholder-team-listing.png`} alt="Team Category Listing" />
                        </div>
                    </div>
                </div>
            )}

            {teamSelectType === 'team-category-filter' && (
                <div className="team-listing">
                    <div className="team-layout-item">
                        <h4>Team Category Filter</h4>
						<div className="team-layout-thumb">
                            <img src={`${themeUrl}/src/template-blocks/team-page/media/placeholder-team-filter.png`} alt="Team Category Filter" />
                        </div>
                    </div>
                </div>
            )}

            {teamSelectType === 'team-location-filter' && (
                <div className="team-listing">
                    <div className="team-layout-item">
                        <h4>Team Location Filter</h4>
						<div className="team-layout-thumb">
                            <img src={`${themeUrl}/src/template-blocks/team-page/media/placeholder-team-location.png`} alt="Team Location Filter" />
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useEffect } from 'react';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { locationType } = attributes;

    // Set default value if not set
    useEffect(() => {
        if (!locationType) {
            setAttributes({ locationType: 'single-location' });
        }
    }, [locationType, setAttributes]);

    const handleChange = (value) => {
        setAttributes({ locationType: value });
    };

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('Location Type', 'sterlingpt')}>
                    <SelectControl
                        label={__('Select Location Type', 'sterlingpt')}
                        value={locationType}
                        options={[
                            { label: __('Single Location', 'sterlingpt'), value: 'single-location' },
                            { label: __('Multiple Location', 'sterlingpt'), value: 'multi-location' },
                        ]}
                        onChange={handleChange}
                    />
                </PanelBody>
            </InspectorControls>

            {locationType === 'multi-location' && (
                <div className="footer-location-listing">
                    <div className="footer-location-item">
                        <h4>Location title</h4>
                        <p className="has-icon">email@domain.com</p>
                        <div className="footer-location-wrap">
                            <p className="has-icon">000-000-0000</p>
                            <p className="has-icon fax">000-000-0000</p>
                        </div>
                        <p className="has-icon">Address Goes Here</p>
                        <div className="footer-location-goto"><a className="wp-element-button" href="javascript:void(0);" title="Dorchester 4">Locati	on Info</a></div>
                    </div>
					<div className="footer-location-item">
                        <h4>Location title</h4>
                        <p className="has-icon">email@domain.com</p>
                        <div className="footer-location-wrap">
                            <p className="has-icon">000-000-0000</p>
                            <p className="has-icon fax">000-000-0000</p>
                        </div>
                        <p className="has-icon">Address Goes Here</p>
                        <div className="footer-location-goto"><a className="wp-element-button" href="javascript:void(0);" title="Dorchester 4">Locati	on Info</a></div>
                    </div>
                    <div className="footer-location-item">
                        <h4>Location title</h4>
                        <p className="has-icon">email@domain.com</p>
                        <div className="footer-location-wrap">
                            <p className="has-icon">000-000-0000</p>
                            <p className="has-icon fax">000-000-0000</p>
                        </div>
                        <p className="has-icon">Address Goes Here</p>
                        <div className="footer-location-goto"><a className="wp-element-button" href="javascript:void(0);" title="Dorchester 4">Location Info</a></div>
                    </div>
                </div>
            )}

            {locationType === 'single-location' && (
                <div className="footer-location-single">
                    <div className="footer-location-address">
                        <h4>Location</h4>
                        <p className="has-icon"><span>Address Goes Here</span></p>
                    </div>
                    <div className="footer-location-contact">
                        <h4>Contact</h4>
                        <p className="has-icon">Email</p>
                        <p className="has-icon">Phone</p>
                        <p className="has-icon fax">Fax</p>
                    </div>
                </div>
            )}
        </div>
    );
}

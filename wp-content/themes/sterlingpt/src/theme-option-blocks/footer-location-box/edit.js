import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useEffect } from 'react';
import './editor.scss';

export default function Edit() {

    return (
        <div {...useBlockProps()}>
          <div className="footer-location-listing">
                <div className="footer-location-item">
                    <h4>Location title</h4>
                    <p className="has-icon">Address Goes Here</p>
                    <p className="has-icon">000-000-0000</p>
                </div>
                <div className="footer-location-item">
                    <h4>Location title</h4>
                    <p className="has-icon">Address Goes Here</p>
                    <p className="has-icon">000-000-0000</p>
                </div>
                <div className="footer-location-item">
                    <h4>Location title</h4>
                    <p className="has-icon">Address Goes Here</p>
                    <p className="has-icon">000-000-0000</p>
                </div>
            </div>
           
        </div>
    );
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
    const { VideoChannelID } = attributes;

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('Video Channel', 'youtube-player-box')} initialOpen={true}>
                    <TextControl
                        label={__('Video Channel ID', 'youtube-player-box')}
                        value={VideoChannelID}
                        onChange={(value) => setAttributes({ VideoChannelID: value })}
                        placeholder="e.g., youtube player key"
                    />
                </PanelBody>
            </InspectorControls>

            <div className="footer-location-single">
                <div className="footer-location-address">
                    <h4>YouTube video player will display videos here using the Player ID.</h4>
                </div>
            </div>
        </div>
    );
}

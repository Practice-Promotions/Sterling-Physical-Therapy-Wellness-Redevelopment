import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { TextControl, PanelBody } from '@wordpress/components';
import { useState } from '@wordpress/element';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { columnUrl } = attributes;

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __('Column Settings', 'sterlingpt') }>
                    <TextControl
                        label={ __('Column Link URL', 'sterlingpt') }
                        value={ columnUrl }
                        onChange={(value) => setAttributes({ columnUrl: value })}
                        placeholder="https://example.com"
                    />
                </PanelBody>
            </InspectorControls>
            <div { ...useBlockProps({ className: 'alignfull' }) }>
                <InnerBlocks
                    template={[
						['core/column', {
								align: 'full',
								className: 'icon-box-layout-two',
								style: {
									spacing: {
										margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
									},
								},
                            },
                            [
                                ['core/image', {
									className: 'cta-icon',
	                                sizeSlug: 'medium',
	                                style: {
	                                    spacing: {
	                                        margin: { bottom: '24px', top: '0px', right: '0px', left: '0px' }
	                                    }
	                                }
	                            }],
                                ['core/heading', {
                                    level: 5,
                                    placeholder: 'CTA Heading',
                                    content: '',
                                    style: {
                                        color: { text: 'var(--wp--preset--color--black)' },
                                        typography: {
                                            fontWeight: 600,
                                            textTransform: 'capitalize',
                                        },
                                        spacing: {
                                            margin: { bottom: '8px', top: '0px', right: '0px', left: '0px' },
                                            padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                        }
                                    },
                                }],
                                ['core/paragraph', {
                                    placeholder: 'Lorem ipsum dolor ',
                                    style: {
                                        color: { text: 'var(--wp--preset--color--gray-400)' },
                                        spacing: { margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' } }
                                    }
                                }],
                            ],
                        ],
                    ]}
                />
            </div>
        </>
    );
}

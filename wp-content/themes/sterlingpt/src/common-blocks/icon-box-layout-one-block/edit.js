import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { TextControl, PanelBody } from '@wordpress/components';

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
                                className: 'icon-box-layout-one',
                                style: {
                                    color: { background: 'var(--wp--preset--color--white)' },
                                    border: { radius: 'var(--wp--custom--settings-key--border-radius-lg)', color: 'var(--wp--preset--color--primary-100)', width: '1px', style: 'solid' },
                                    spacing: {
                                        padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' }
                                    }
                                }
                            },
                            [
								['core/image', {
									className: 'cta-icon',
									sizeSlug: 'medium',
									style: {
										spacing: {
											margin: { bottom: '0px', top: '0px', right: '24px', left: '0px' }
										}
									}
								}],
								['core/group', {
									   className: 'cta-icon-content',
									   style: {
										   spacing: { margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' } }
									   }
								   },
                                    [
                                        ['core/heading', {
                                            level: 5,
                                            placeholder: 'CTA Heading',
                                            content: '',
                                            style: {
                                                color: { text: 'var(--wp--preset--color--black)' },
                                                typography: { fontWeight: 500, textTransform: 'capitalize' },
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
                            ],
                        ],
	                ]}
	            />
	        </div>
		</>
    );
}

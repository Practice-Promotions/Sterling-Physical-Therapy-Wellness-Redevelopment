import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { TextControl, PanelBody, RadioControl } from '@wordpress/components';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {

    const { columnUrl, alignment} = attributes;

    const setAlignmentClass = (alignment) => {
        switch (alignment) {
            case 'left':
                return 'align-left';
            case 'center':
                return 'align-center';
            case 'right':
                return 'align-right';
            default:
                return '';
        }
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Column Settings', 'sterlingpt')}>
                    <TextControl
                        label={__('Column Link URL', 'sterlingpt')}
                        value={columnUrl}
                        onChange={(value) => setAttributes({ columnUrl: value })}
                        placeholder="https://example.com"
                    />
                    <RadioControl
                        label={__('Text Alignment', 'sterlingpt')}
                        selected={alignment}
                        options={[
                            { label: __('Left', 'sterlingpt'), value: 'left' },
                            { label: __('Center', 'sterlingpt'), value: 'center' },
                            { label: __('Right', 'sterlingpt'), value: 'right' },
                        ]}
                        onChange={(value) => setAttributes({ alignment: value })}
                    />
                </PanelBody>
            </InspectorControls>
            <div {...useBlockProps({ className: `alignfull ${setAlignmentClass(alignment)}` })}>
                <InnerBlocks
                    template={[
                        ['core/group', {
                            className: 'cta-item-group',
                        },
                            [
                                ['ppcoreblocks/svg-embed', {
                                    className: 'cta-icon',
                                    sizeSlug: 'medium',
                                    style: {
                                        spacing: {
                                            margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                        }
                                    }
                                }],
                                ['core/heading', {
                                    level: 5,
                                    placeholder: 'CTA Heading',
                                    content: '',
                                    className: 'cta-item-title',
                                    style: {
                                        color: { text: 'var(--wp--preset--color--black)' },
                                        typography: {
                                            fontWeight: 500,
                                            textTransform: 'capitalize',
                                        },
                                        spacing: {
                                            margin: { bottom: '0px', top: '9px', right: '0px', left: '0px' },
                                            padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                        }
                                    },
                                }],
                            ],
                        ],
                    ]}
                />
            </div>
        </>
    );
}

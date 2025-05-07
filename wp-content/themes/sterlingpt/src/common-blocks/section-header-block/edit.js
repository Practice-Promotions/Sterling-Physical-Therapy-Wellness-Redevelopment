import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl } from '@wordpress/components';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { alignment } = attributes;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Block Settings', 'sterlingpt')}>
                    <CheckboxControl
                        label={__('Enable Center Alignment in Mobile', 'sterlingpt')}
                        checked={alignment}
                        onChange={(value) => setAttributes({ alignment: value })}
                    />
                </PanelBody>
            </InspectorControls>

            <div {...useBlockProps()}>
                <InnerBlocks
                    template={[
                        [
                            'core/columns', 
                            { align: 'wide' },
                            [
                                [
                                    'core/column', 
                                    { width: '100%' },
                                    [
                                        [
                                            'core/heading', 
                                            { level: 2, placeholder: 'Heading goes here...' }
                                        ],
                                        [
                                            'core/heading', 
                                            { level: 3, placeholder: 'Subheading goes here...' }
                                        ],
                                        [
                                            'core/paragraph', 
                                            { placeholder: 'Paragraph goes here...' }
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]}
                />
            </div>
        </>
    );
}


import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {

    return (
        <div {...useBlockProps({ className: 'alignfull' })}>
            <InnerBlocks
                template={[
                    ['core/cover', {
                            className: 'inner-banner',
                            align: 'full',
                            dimRatio: 70,
                            customOverlayColor: 'var(--wp--preset--color--primary-100)',
                            style: {
                                spacing: {  
                                    padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                }
                            }
                        },
                        [
                            ['core/columns', {
                                align: 'full',
                                className: 'inner-banner-content',
                                style: {
                                    spacing: {
                                        margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                        padding: { bottom: '0px', top: '0px' }
                                    }
                                }
                            },
                                [
                                    ['core/column', {
                                        width: '100%',
                                        style: {}
                                    },
                                        [
                                            ['core/paragraph', {
                                                content: '[site-breadcrumb]',
                                                style: {
                                                    color: { text: 'var(--wp--preset--color--white)' },
                                                    typography: { fontWeight: 500, fontSize: '24px' },
                                                    spacing: {}
                                                }
                                            }],

                                            ['core/heading', {
                                                level: 1,
                                                placeholder: 'Inner Banner Heading',
                                                content: '{{POST_TITLE}}',
                                                style: {
                                                    color: { text: 'var(--wp--preset--color--white)' },
                                                    typography: { textTransform: 'capitalize' },
                                                    spacing: {
                                                        margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                                        padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                                    }
                                                }
                                            }],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],

                    // Insurance Partner Banner Inject
                    ['core/block', {
                        ref: 5944
                    }],

                ]}
            />
        </div>
    );
}

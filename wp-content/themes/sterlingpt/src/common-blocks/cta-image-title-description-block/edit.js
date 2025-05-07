import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

import './editor.scss';
import './style.scss';

export default function Edit() {
    return (
        <div { ...useBlockProps({ className: 'alignfull' }) }>
            <InnerBlocks
                template={[
                    ['core/column', {
                            className: 'cta-column',
                            style: {
                                color: { background: 'var(--wp--preset--color--primay-200)' },
                                border: { radius: 'var(--wp--custom--settings-key--border-radius)' },
                                spacing: {
                                    padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                }
                            }
                        },
                        [
                            ['core/image', {
                                className: 'cta-image',
								aspectRatio: '4/3',
                                sizeSlug: 'full',
                                style: {
									border: { radius: { topLeft: 'var(--wp--custom--settings-key--border-radius)', topRight: 'var(--wp--custom--settings-key--border-radius)' } },
									spacing: {
                                        margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                    }
                                }
                            }],
                            ['core/group', {
                                className: 'cta-image-content',
                                style: {
                                    color: { background: 'var(--wp--preset--color--gray-100)' },
                                    border: { radius: { bottomLeft: 'var(--wp--custom--settings-key--border-radius)', bottomRight: 'var(--wp--custom--settings-key--border-radius)' } },
                                    spacing: {
                                        margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                        padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' }
                                    }
                                }
                            },
                            [
                                ['core/heading', {
                                    level: 5,
                                    placeholder: 'CTA Heading',
                                    content: '',
                                    style: {
                                        color: { text: 'var(--wp--preset--color--black)' },
                                        typography: { fontSize: '24px', fontWeight: 500, textTransform: 'capitalize' },
                                        spacing: {
                                            margin: { bottom: '8px', top: '0px', right: '0px', left: '0px' },
                                            padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                        }
                                    },
                                }],
                                ['core/paragraph', {
                                    placeholder: 'Lorem ipsum dolor ',
                                    content: '',
                                    style: {
                                        color: { text: 'var(--wp--preset--color--gray-400)' },
                                        spacing: { margin: { bottom: '18px', top: '0px', right: '0px', left: '0px' } }
                                    }
                                }],
                                ['core/button', {
                                    className: 'cta-btn-link',
                                    placeholder: 'Read More',
                                    style: {
                                        color: { text: 'var(--wp--preset--color--primary-100)', background: 'transparent' },
                                        typography: { fontSize: '16px', fontWeight: 500, textTransform: 'capitalize' },
                                        spacing: {
                                            padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                        },
                                        border: { color: 'transparent', width: '0px', style: 'solid' }
                                    }
                                }],
                            ]],
                        ],
                    ],
                ]}
            />
        </div>
    );
}

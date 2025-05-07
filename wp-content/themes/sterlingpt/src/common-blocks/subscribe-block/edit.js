import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import './editor.scss';
import './style.scss';

export default function Edit() {
    return (
        <div { ...useBlockProps({ className: 'alignfull' }) }>
            <InnerBlocks
                template={[
                    ['core/columns', {
                        className: 'subscribe-block',
                        style: {
                            color: { background: 'var(--wp--preset--color--white)' },
                        },
                    },
                        [
                            ['core/column', {
                                width: '83%',
                                className: 'subscribe-inner',
                                style: {
                                    color: { background: 'var(--wp--preset--color--primary-100)' },
                                    border: { radius: 'var(--wp--custom--settings-key--border-radius)' },
                                    spacing: {
                                        padding: { bottom: '48px', top: '48px', right: '48px', left: '48px' }
                                    },
                                },
                            },
                                [
                                    ['core/heading', {
                                        level: 4,
                                        placeholder: __('Subscribe Heading', 'sterlingpt'),
                                        style: {
                                            color: { text: 'var(--wp--preset--color--white)' },
                                            typography: {
                                                fontWeight: 600,
                                            },
                                            spacing: {
                                                margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                            },
                                        },
                                    }],
                                    ['core/shortcode', {}],
                                ],
                            ],
                        ],
                    ],
                ]}
            />
        </div>
    );
}

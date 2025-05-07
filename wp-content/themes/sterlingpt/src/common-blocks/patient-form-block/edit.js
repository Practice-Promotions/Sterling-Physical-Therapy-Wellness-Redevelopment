import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps({
        className: 'alignfull'
    });

    return (
        <div { ...blockProps }>
            <InnerBlocks
                template={[
                    [
                        'core/group', {
                            className: 'patientinfo text-center',
                            style: {
                                color: { background: 'var(--wp--preset--color--white-100)' },
                                border: { radius: 'var(--wp--custom--settings-key--border-radius-lg)' },
                                spacing: {
                                    padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
                                }
                            }
                        },
                        [
                            ['core/image', {
                                className: 'patientinfo-media p-30',
                                sizeSlug: 'thumbnail'
                            }],
                            [
                                'core/group', {
                                    className: 'patientinfo-body',
                                    style: {
                                        color: { background: '#E7F5FB' },
                                        border: { radius: { bottomLeft: '8px', bottomRight: '8px' }, color: '#E7F5FB', width: '1px', style: 'solid' },
                                        spacing: {
                                            margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                            padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' }
                                        }
                                    }
                                },
                                [
                                    ['core/heading', {
                                        level: 2,
                                        placeholder: 'Heading goes here...',
                                        content: 'Heading goes here...',
                                        style: {
                                            color: { text: 'var(--wp--preset--color--primary-100)' },
                                            typography: { fontSize: '24px', fontWeight: 500, textTransform: 'capitalize' },
                                            spacing: {
                                                margin: { bottom: '15px', top: '0px', right: '0px', left: '0px' },
                                                padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                            }
                                        },
                                    }],
                                    ['core/paragraph', {
                                        placeholder: 'Description goes here...',
                                        content: 'Description goes here...',
                                        style: {
                                            color: { text: 'var(--wp--preset--color--black)' },
                                            spacing: {
                                                margin: { bottom: '15px', top: '0px', right: '0px', left: '0px' },
                                                padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                                            }
                                        },
                                    }],
                                    ['core/button', {
                                        className: 'patientinfo-action',
                                        placeholder: 'Button',
                                        text: 'Download',
                                    }],
                                ]
                            ],
                        ],
                    ],
                ]}
            />
        </div>
    );
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, InnerBlocks } from '@wordpress/block-editor';
import { RadioControl, TextControl, PanelBody, SelectControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

export default function Edit({ attributes, setAttributes }) {
    const { linkType, pageLink, externalLink } = attributes;

    const [pages, setPages] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    // Fetch all pages from WordPress
    useEffect(() => {
        setIsLoading(true);
        apiFetch({ path: '/wp/v2/pages?per_page=100' }) // Adjust per_page if needed
            .then((response) => {
                const pageOptions = response.map((page) => ({
                    label: page.title.rendered,
                    value: page.link, // Use page link here for simplicity
                }));
                setPages(pageOptions);
                setIsLoading(false);
            })
            .catch(() => {
                setPages([]);
                setIsLoading(false);
            });
    }, []);

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Column Settings', 'sterlingpt')}>
                    {/* Radio buttons for Link Type */}
                    <RadioControl
                        label={__('Select Link Type', 'sterlingpt')}
                        selected={linkType}
                        options={[
                            { label: __('Page Link Selection', 'sterlingpt'), value: 'page' },
                            { label: __('Third Party Link', 'sterlingpt'), value: 'external' },
                        ]}
                        onChange={(value) => setAttributes({ linkType: value })}
                    />

                    {/* Page Link Selection */}
                    {linkType === 'page' && (
                        <>
                            {isLoading ? (
                                <p>{__('Loading pages...', 'sterlingpt')}</p>
                            ) : (
                                <SelectControl
                                    label={__('Select Page', 'sterlingpt')}
                                    value={pageLink}
                                    options={[
                                        { label: __('Select a page', 'sterlingpt'), value: '' },
                                        ...pages,
                                    ]}
                                    onChange={(value) => setAttributes({ pageLink: value })}
                                />
                            )}
                        </>
                    )}

                    {/* Third Party Link Input */}
                    {linkType === 'external' && (
                        <TextControl
                            label={__('Third Party Link URL', 'sterlingpt')}
                            value={externalLink}
                            onChange={(value) => setAttributes({ externalLink: value })}
                            placeholder="https://example.com"
                        />
                    )}
                </PanelBody>
            </InspectorControls>

            <div {...useBlockProps({ className: 'alignfull' })}>
                 <InnerBlocks />
            </div>
        </>
    );
}

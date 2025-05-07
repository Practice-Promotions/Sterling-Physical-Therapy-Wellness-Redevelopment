import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, RadioControl } from '@wordpress/components';
import { useEffect } from 'react';

export default function Edit({ attributes, setAttributes }) {
    const { faqSelectType, faqLayoutType } = attributes;

    // Set default values if not set
    useEffect(() => {
        if (!faqSelectType) {
            setAttributes({ faqSelectType: 'faq-normal-listing' });
        }
        if (!faqLayoutType) {
            setAttributes({ faqLayoutType: 'single-column' });
        }
    }, [faqSelectType, faqLayoutType, setAttributes]);

    const handleFaqTypeChange = (value) => {
        setAttributes({ faqSelectType: value });
    };

    const handleLayoutChange = (value) => {
        setAttributes({ faqLayoutType: value });
    };

    const themeUrl = `${window.location.origin}/wp-content/themes/sterlingpt`;

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('FAQ Layout Type', 'sterlingpt')}>
                    <SelectControl
                        label={__('Select FAQ Type', 'sterlingpt')}
                        value={faqSelectType}
                        options={[
                            { label: __('FAQ Normal Listing', 'sterlingpt'), value: 'faq-normal-listing' },
                            { label: __('FAQ Category Filter', 'sterlingpt'), value: 'faq-category-filter' },
                        ]}
                        onChange={handleFaqTypeChange}
                    />
                    {faqSelectType === 'faq-normal-listing' && (
                        <RadioControl
                            label={__('Select Layout', 'sterlingpt')}
                            selected={faqLayoutType}
                            options={[
                                { label: __('Single Column', 'sterlingpt'), value: 'single-column' },
                                { label: __('Two Column', 'sterlingpt'), value: 'two-column' },
                            ]}
                            onChange={handleLayoutChange}
                        />
                    )}
                </PanelBody>
            </InspectorControls>

            {faqSelectType === 'faq-normal-listing' && (
                <div className={`faq-listing ${faqLayoutType}`}>
                    <div className="faq-layout-item">
                        <h4 className="text-center">
                            {faqLayoutType === 'single-column' 
                                ? 'FAQ Single-Column layout' 
                                : 'FAQ Two-Column layout'
                            }
                        </h4>    
                        <div className="faq-layout-thumb">
                            <img
                                src={`${themeUrl}/src/template-blocks/faq-page/media/placeholder-${faqLayoutType === 'single-column' ? 'single-column' : 'two-column'}.jpg`}
                                alt="FAQ Category Listing"
                            />
                        </div>
                    </div>
                </div>
            )}

            {faqSelectType === 'faq-category-filter' && (
                <div className="faq-listing">
                    <div className="faq-layout-item">
                        <h4>FAQ Category Filter</h4>
                        <div className="faq-layout-thumb">
                            <img
                                src={`${themeUrl}/src/template-blocks/faq-page/media/placeholder-faq-filter.jpg`}
                                alt="FAQ Category Filter"
                            />
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}

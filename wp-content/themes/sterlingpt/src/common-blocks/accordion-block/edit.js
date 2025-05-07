import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { Button, TextControl, RadioControl, PanelBody, TextareaControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {

    const { items = [], layout = 'single' } = attributes;

    const updateItemTitle = (newTitle, index) => {
        const updatedItems = [...items];
        updatedItems[index].title = newTitle;
        setAttributes({ items: updatedItems });
    };

    const updateItemContent = (newContent, index) => {
        const updatedItems = [...items];
        updatedItems[index].content = newContent;
        setAttributes({ items: updatedItems });
    };

    const addItem = () => {
        const newItem = { title: '', content: '' };
        setAttributes({ items: [...items, newItem] });
    };

    const removeItem = (index) => {
        const updatedItems = items.filter((item, i) => i !== index);
        setAttributes({ items: updatedItems });
    };

    const updateLayout = (newLayout) => {
        setAttributes({ layout: newLayout });
    };

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Accordion Layout', 'sterlingpt')} initialOpen={true}>
                    <RadioControl
                        label={__('Select option to display layout on the front side', 'sterlingpt')}
                        selected={layout}
                        options={[
                            { label: __('Single Column', 'sterlingpt'), value: 'single' },
                            { label: __('Two Column', 'sterlingpt'), value: 'two' },
                        ]}
                        onChange={updateLayout}
                    />
                </PanelBody>
            </InspectorControls>

            <div {...useBlockProps({ className: `accordion-block` })}>
                <div className="accordion-list">
                    {items.map((item, index) => (
                        <div className="accordion-item" key={index}>
                            <Fragment>
                                <TextControl
                                    label={__(`Accordion ${index + 1}`, 'sterlingpt')}
                                    value={item.title}
                                    onChange={(value) => updateItemTitle(value, index)}
                                    placeholder={__('Accordion title...', 'sterlingpt')}
                                />
                                <TextareaControl
                                    label={__('Accordion Content', 'sterlingpt')}
                                    value={item.content}
                                    onChange={(value) => updateItemContent(value, index)}
                                    placeholder={__('Accordion Content...', 'sterlingpt')}
                                    help={__('Enter HTML content such as <ul>, <li>, <p>, etc.', 'sterlingpt')}
                                />
                                <Button className="action-icon delete" isDestructive onClick={() => removeItem(index)}>
                                    <span className="delete-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30.849" height="30.849" viewBox="0 0 30.849 30.849">
                                            <path id="Icon_metro-cross" data-name="Icon metro-cross" d="M33.138,26.711h0l-9.358-9.358,9.358-9.358h0a.966.966,0,0,0,0-1.363L28.717,2.21a.967.967,0,0,0-1.363,0h0L18,11.568,8.637,2.21h0a.966.966,0,0,0-1.363,0L2.852,6.631a.966.966,0,0,0,0,1.363h0l9.358,9.358L2.852,26.711h0a.966.966,0,0,0,0,1.363l4.421,4.421a.966.966,0,0,0,1.363,0h0L18,23.136l9.358,9.358h0a.966.966,0,0,0,1.363,0l4.421-4.421a.966.966,0,0,0,0-1.363Z" transform="translate(-2.571 -1.928)" />
                                        </svg>
                                    </span>
                                </Button>
                            </Fragment>
                        </div>
                    ))}
                </div>
                <Button isPrimary onClick={addItem}>
                    {__('Add Item', 'sterlingpt')}
                </Button>
            </div>
        </Fragment>
    );
}
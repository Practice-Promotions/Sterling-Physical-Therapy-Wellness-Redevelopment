import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function deprecatedSave({ attributes }) {

    const { items = [], layout = 'single' } = attributes;

    return (
        <div {...useBlockProps.save()} className={`alignwide accordion-list ${layout}-column`}>
            {items.map((item, index) => (
                <div className="accordion-item" key={index}>
                    <div
                        className="accordion-title"
                        aria-expanded="false"
                    >
                        <h5>{item.title}</h5>
                        <span></span>
                    </div>
                    <div className="accordion-content" style={{ display: 'none' }}>
                        <RichText.Content tagName="p" value={item.content} />
                    </div>
                </div>
            ))}
        </div>
    );
}
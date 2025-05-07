import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { paragraphs = [] } = attributes;

    const updateAnchorLink = (value, index) => {
        const newParagraphs = [...paragraphs];
        newParagraphs[index].link = value;
        setAttributes({ paragraphs: newParagraphs });
    };

    const addParagraph = () => {
        setAttributes({
            paragraphs: [...paragraphs, { link: '' }],
        });
    };

    const removeParagraph = (index) => {
        const newParagraphs = [...paragraphs];
        newParagraphs.splice(index, 1);
        setAttributes({ paragraphs: newParagraphs });
    };

    return (
        <div {...useBlockProps()}>
            <ul className="source-link-block is-style-checkmark-list">
                <h3>Source Links</h3>
                {paragraphs.map((paragraph, index) => (
                    <li key={index} className="source-link-item">
                        <input
                            type="text"
                            value={paragraph.link}
                            onChange={(e) => updateAnchorLink(e.target.value, index)}
                            placeholder={__('Enter link URL', 'sterlingpt')}
                            className="link-input"
                        />
                        <Button
                            isDestructive
                            onClick={() => removeParagraph(index)}
                            className="remove-link"
                        >
                            {__('Remove', 'sterlingpt')}
                        </Button>
                    </li>
                ))}
            </ul>
            <Button
                isPrimary
                onClick={addParagraph}
                className="add-link"
            >
                {__('Add', 'sterlingpt')}
            </Button>
        </div>
    );
}

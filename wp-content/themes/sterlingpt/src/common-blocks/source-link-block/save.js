import { __ } from '@wordpress/i18n';
import './style.scss';

export default function save({ attributes }) {
    const { paragraphs = [] } = attributes;

    if (!paragraphs.length) {
        return null;
    }

    return (
        <div className="source-link-block">
            <h5>{__('Sources:', 'sterlingpt')}</h5>
            <ul className="is-style-checkmark-list">
                {paragraphs.map((paragraph, index) => {
                    const link = paragraph.link;
                    return link ? (
                        <li key={index}>
                            <a
                                href={link}
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {link}
                            </a>
                        </li>
                    ) : null;
                })}
            </ul>
        </div>
    );
}

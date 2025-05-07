import { useBlockProps } from '@wordpress/block-editor';

export default function DeprecatedSaveV1({ attributes }) {
    const { className } = attributes;

    return (
        <div {...useBlockProps.save({ className: `${className} alignfull` })}>
            <div className="hero-banner-list">
                <div className="hero-banner-item">
                    <div className="hero-banner-content">
                        <h6 style={{ color: 'var(--wp--preset--color--white)', fontWeight: 400, fontSize: '18px', marginBottom: '6px' }}>
                            {attributes.subHeading || 'Banner Sub Heading'}
                        </h6>
                        <h1 style={{ color: 'var(--wp--preset--color--white)', fontWeight: 600 }}>
                            {attributes.mainHeading || 'Banner heading'}
                        </h1>
                        <p style={{ color: 'var(--wp--preset--color--white)', fontSize: '16px', fontWeight: 400 }}>
                            {attributes.paragraphContent || 'Lorem ipsum dolor'}
                        </p>
                        <div className="buttons" style={{ marginTop: '40px' }}>
                            <a
                                href={attributes.buttonUrl || '#'}
                                style={{
                                    background: 'transparent',
                                    color: 'var(--wp--preset--color--white)',
                                    border: '1px solid var(--wp--preset--color--white)',
                                    textTransform: 'uppercase',
                                    padding: '10px 20px',
                                    textDecoration: 'none',
                                }}
                            >
                                {attributes.buttonText || 'Learn More'}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

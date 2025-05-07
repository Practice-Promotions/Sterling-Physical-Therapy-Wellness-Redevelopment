import { registerBlockType } from '@wordpress/blocks';
import { MediaUpload } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('ppcoreblocks/svg-embed', {
  attributes: {
    svgContent: {
      type: 'string',
      default: '',
    },
  },
  edit({ attributes, setAttributes }) {
    const { svgContent } = attributes;

    const handleSelectSVG = (media) => {
      if (media && media.url.endsWith('.svg')) {
        fetch(media.url)
          .then((response) => response.text())
          .then((svgText) => {
            setAttributes({ svgContent: svgText });
          });
      }
    };

    const handleRemoveSVG = () => {
      setAttributes({ svgContent: '' });
    };

    return (
      <div {...useBlockProps()}>
        <div className="svg-embed-backend">
        <div class="components-placeholder__label"><span class="dashicon dashicons dashicons-format-image"></span>SVG Embed</div>
            <p className="components-placeholder__instructions">{svgContent ? '' : 'Upload an SVG file by selecting one from your media library.'}</p>
            <div className="svg-embed-backend-buttons">
              <MediaUpload
                onSelect={handleSelectSVG}
                allowedTypes={['image/svg+xml']}
                render={({ open }) => (
                  <>
                    <Button onClick={open} isPrimary>
                      {svgContent ? 'Replace SVG' : 'Upload SVG'}
                    </Button>
                    {svgContent && (
                      <Button onClick={handleRemoveSVG} isSecondary>
                        Remove SVG
                      </Button>
                    )}
                  </>
                )}
              />
            </div>
            {svgContent && (
              <div
                style={{
                  position: 'relative',
                  overflow: 'hidden',
                }}
                dangerouslySetInnerHTML={{
                  __html: svgContent,
                }}
              />
            )}
        </div>
      </div>
    );
  },
  save({ attributes }) {
    const { svgContent } = attributes;
    return (
      <div className="svg-embed"
        dangerouslySetInnerHTML={{
          __html: svgContent,
        }}
      />
    );
  },
});

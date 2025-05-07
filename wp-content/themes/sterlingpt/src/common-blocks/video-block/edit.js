import { __ } from '@wordpress/i18n';
import { useBlockProps, MediaUpload, InspectorControls } from '@wordpress/block-editor';
import { Button, PanelBody, SelectControl, TextControl } from '@wordpress/components';
import './style.scss';

export default function Edit({ attributes, setAttributes }) {
    const { videoType, videoUrl, videoId, coverImage } = attributes;

    const youtubeThumbnail = videoType === 'youtube' && videoId ? `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg` : null;

    const updateVideoType = (value) => setAttributes({ videoType: value, videoUrl: '', videoId: '', coverImage: '' });
    const updateVideoId = (value) => setAttributes({ videoId: value });
    const SelectMedia = (media) => setAttributes({ videoUrl: media.url });
    const removeMedia = () => setAttributes({ videoUrl: '' });
    const SelectCoverImage = (media) => setAttributes({ coverImage: media.url });
    const removeCoverImage = () => setAttributes({ coverImage: '' });

    const themeUrl = `${window.location.origin}/wp-content/themes/sterlingpt`;
    const FileName = (url) => url?.split('/').pop() || '';

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('Video Settings', 'sterlingpt')}>
                    <SelectControl
                        label={__('Video Type', 'sterlingpt')}
                        value={videoType}
                        options={[
                            { label: __('Select Video Type', 'sterlingpt'), value: '' },
                            { label: __('YouTube', 'sterlingpt'), value: 'youtube' },
                            { label: __('Vimeo', 'sterlingpt'), value: 'vimeo' },
                            { label: __('Upload', 'sterlingpt'), value: 'upload' },
                        ]}
                        onChange={updateVideoType}
                    />

                    {(videoType === 'youtube' || videoType === 'vimeo') && (
                        <TextControl
                            label={__(`${videoType.charAt(0).toUpperCase() + videoType.slice(1)} Video ID`, 'sterlingpt')}
                            value={videoId}
                            onChange={updateVideoId}
                        />
                    )}

                    {videoType === 'upload' && (
                        <>
                            <MediaUpload
                                onSelect={SelectMedia}
                                allowedTypes={['video']}
                                render={({ open }) => (
                                    <Button onClick={open} isPrimary aria-label={__('Upload or change video', 'sterlingpt')}>
                                        {videoUrl ? __('Change Video', 'sterlingpt') : __('Upload Video', 'sterlingpt')}
                                    </Button>
                                )}
                            />
                            {videoUrl && (
                                <div className="remove-item">
                                    <p><strong>{FileName(videoUrl)}</strong></p>
                                    <Button className="isDestructive icon-close" onClick={removeMedia} aria-label={__('Remove video', 'sterlingpt')}></Button>
                                </div>
                            )}
                        </>
                    )}
                </PanelBody>

                <PanelBody title={__('Cover Image', 'sterlingpt')}>
                    <MediaUpload
                        onSelect={SelectCoverImage}
                        allowedTypes={['image']}
                        render={({ open }) => (
                            <Button onClick={open} isPrimary aria-label={__('Upload cover image', 'sterlingpt')}>
                                {coverImage ? __('Change Cover Image', 'sterlingpt') : __('Upload Cover Image', 'sterlingpt')}
                            </Button>
                        )}
                    />
                    {coverImage && (
                        <div className="remove-item">
                            <p><strong>{FileName(coverImage)}</strong></p>
                            <Button onClick={removeCoverImage} className="isDestructive icon-close" aria-label={__('Remove cover image', 'sterlingpt')}></Button>
                        </div>
                    )}
                </PanelBody>
            </InspectorControls>

            <div className="video-preview">
                <div className="cover-image">
                    <img 
                        src={coverImage || youtubeThumbnail || `${themeUrl}/assets/images/placeholder-video-image.jpg`} 
                        alt={__('Cover Image', 'sterlingpt')} 
                        className="cover-img" 
                    />
                    <span className="icon-play" aria-hidden="true"></span>
                </div>
            </div>
        </div>
    );
}

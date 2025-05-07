import { __ } from '@wordpress/i18n';
import './style.scss';

export default function save({ attributes }) {
    const { videoType, videoUrl, videoId, coverImage } = attributes;
    const themeUrl = `${window.location.origin}/wp-content/themes/sterlingpt`;
    
    const videoLinks = {
        youtube: videoId ? `https://www.youtube.com/watch?v=${videoId}` : '#',
        vimeo: videoId ? `https://player.vimeo.com/video/${videoId}` : '#',
        upload: videoUrl ? (typeof videoUrl === 'object' ? videoUrl.url : videoUrl) : '#',
    };

    const coverImgSrc = coverImage || (videoType === 'youtube' && videoId ? `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg` : `${themeUrl}/assets/images/placeholder-video-image.jpg`);

    return videoId || videoUrl ? (
        <div className="video-preview">
            <div className="cover-image">
                <a 
                    data-fancybox 
                    data-toolbar="false" 
                    data-arrows="false"
                    data-small-btn="true"
                    href={videoLinks[videoType] || '#'}
                    aria-label={__('Play video', 'sterlingpt')}
                >
                    <figure>
                        <img src={coverImgSrc} alt={__('Cover Image', 'sterlingpt')} className="cover-img" />
                    </figure>
                    <span className="icon-play" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    ) : <p>{__('No video selected.', 'sterlingpt')}</p>;
}

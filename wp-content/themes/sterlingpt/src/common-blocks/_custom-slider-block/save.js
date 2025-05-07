import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const {
		enableSlider,
		slidesToShow,
		slidesToScroll,
		navigationEnabled,
		paginationEnabled,
	} = attributes;

	const classes = [
		'custom-slider-grid',
		enableSlider ? 'swiper mySwiper' : 'grid-layout',
		enableSlider ? `slides-show-${slidesToShow}` : '',
	].join(' ');

	return (
		<div {...useBlockProps.save({ className: classes })}>
			<InnerBlocks.Content />
			{enableSlider && (
				<>
					{paginationEnabled && <div className="swiper-pagination"></div>}
					{navigationEnabled && (
						<>
							<div className="swiper-button-prev"></div>
							<div className="swiper-button-next"></div>
						</>
					)}
				</>
			)}
		</div>
	);
}

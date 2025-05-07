import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const {
		enableCarousel,
		enableLoop,
		enableAutoplay,
		autoplayDelay,
		slidesPerView,
		slidesPerGroup,
		effect
	} = attributes;

	const options = enableCarousel
		? {
			loop: enableLoop,
			slidesPerView,
			slidesPerGroup,
			autoplay: enableAutoplay ? { delay: autoplayDelay } : false,
			effect
		}
		: null;

	return (
		<section
			{...useBlockProps.save({ className: 'swiper-block alignfull' })}
			data-swiper-options={options ? JSON.stringify(options) : undefined}
		>
			<div className="swiper">
				<div className="swiper-wrapper">
					<InnerBlocks.Content />
				</div>
				{/* Optional swiper navigation/pagination */}
				<div className="swiper-pagination"></div>
				<div className="swiper-button-next"></div>
				<div className="swiper-button-prev"></div>
			</div>
		</section>
	);
}
import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const {
		navigationEnabled,
		paginationEnabled,
		loop,
		autoplayEnabled,
	} = attributes;

	return (
		<section {...useBlockProps.save()} className={`hero-swiper-banner alignfull swiper mySwiper ${autoplayEnabled ? 'autoplay-on' : ''}`}>
			<InnerBlocks.Content />
			<div className="swiper-navigation">
				{paginationEnabled && <div className="swiper-pagination"></div>}
				{navigationEnabled && (
					<>
						<div className="swiper-button-next"></div>
						<div className="swiper-button-prev"></div>
					</>
				)}
			</div>
		</section>
	);
}

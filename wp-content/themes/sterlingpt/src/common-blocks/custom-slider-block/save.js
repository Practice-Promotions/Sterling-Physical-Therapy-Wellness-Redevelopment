import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const {
		isSlider
	} = attributes;

	const blockProps = useBlockProps.save({
		className: `${isSlider ? 'swiper mySwiper' : 'grid-mode'}`
	});

	return (
		<div {...blockProps}>
			<div className={isSlider ? 'swiper-wrapper' : 'grid-wrapper'}>
				<InnerBlocks.Content />
			</div>
			{isSlider && (
				<>
					<div className="swiper-pagination"></div>
					<div className="swiper-button-next"></div>
					<div className="swiper-button-prev"></div>
				</>
			)}
		</div>
	);
}

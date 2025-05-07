import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InnerBlocks,
	InspectorControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	RangeControl,
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		isSlider,
		slidesToShow,
		slidesToScroll,
		loop,
		autoplay
	} = attributes;

	const blockProps = useBlockProps({
		className: `${isSlider ? 'swiper mySwiper' : 'grid-mode'}`
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Layout Settings', 'textdomain')} initialOpen={true}>
					<ToggleControl
						label={__('Enable Slider Mode', 'textdomain')}
						checked={isSlider}
						onChange={(val) => setAttributes({ isSlider: val })}
					/>
					{isSlider && (
						<>
							<RangeControl
								label={__('Slides to Show', 'textdomain')}
								min={1}
								max={4}
								value={slidesToShow}
								onChange={(val) => setAttributes({ slidesToShow: val })}
							/>
							<RangeControl
								label={__('Slides to Scroll', 'textdomain')}
								min={1}
								max={4}
								value={slidesToScroll}
								onChange={(val) => setAttributes({ slidesToScroll: val })}
							/>
							<ToggleControl
								label={__('Loop Slides', 'textdomain')}
								checked={loop}
								onChange={(val) => setAttributes({ loop: val })}
							/>
							<ToggleControl
								label={__('Autoplay', 'textdomain')}
								checked={autoplay}
								onChange={(val) => setAttributes({ autoplay: val })}
							/>
						</>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className={isSlider ? 'swiper-wrapper' : 'grid-wrapper'}>
					<InnerBlocks
						allowedBlocks={['core/column', 'core/group', 'core/image', 'core/cover']}
						templateLock={false}
					/>
				</div>

				{isSlider && (
					<>
						<div className="swiper-pagination"></div>
						<div className="swiper-button-next"></div>
						<div className="swiper-button-prev"></div>
					</>
				)}
			</div>
		</>
	);
}

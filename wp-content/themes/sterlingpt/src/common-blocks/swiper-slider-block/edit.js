import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	InnerBlocks
} from '@wordpress/block-editor';

import {
	PanelBody,
	ToggleControl,
	RangeControl,
	SelectControl
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		enableCarousel,
		enableLoop,
		enableAutoplay,
		autoplayDelay,
		slidesPerView,
		slidesPerGroup,
		effect
	} = attributes;

	// Handle conditional attribute changes
	const toggleCarousel = (value) => {
		setAttributes({
			enableCarousel: value,
			slidesPerView: value ? 3 : 1,
			slidesPerGroup: value ? 1 : 1,
			enableLoop: value,
			enableAutoplay: value,
			autoplayDelay: 3000,
			effect: 'slide'
		});
	};

	const blockProps = useBlockProps({ className: 'swiper-block alignfull' });

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Swiper Settings', 'text-domain')} initialOpen={true}>
					<ToggleControl
						label={__('Enable Carousel (3 Slides)', 'text-domain')}
						checked={enableCarousel}
						onChange={toggleCarousel}
					/>

					{enableCarousel && (
						<>
							<ToggleControl
								label={__('Loop Slides', 'text-domain')}
								checked={enableLoop}
								onChange={(value) => setAttributes({ enableLoop: value })}
							/>

							<ToggleControl
								label={__('Enable Autoplay', 'text-domain')}
								checked={enableAutoplay}
								onChange={(value) => setAttributes({ enableAutoplay: value })}
							/>

							{enableAutoplay && (
								<RangeControl
									label={__('Autoplay Delay (ms)', 'text-domain')}
									value={autoplayDelay}
									onChange={(value) => setAttributes({ autoplayDelay: value })}
									min={100}
									max={10000}
									step={100}
								/>
							)}

							<RangeControl
								label={__('Slides Per View', 'text-domain')}
								value={slidesPerView}
								onChange={(value) => setAttributes({ slidesPerView: value })}
								min={1}
								max={6}
							/>

							<RangeControl
								label={__('Slides Per Group', 'text-domain')}
								value={slidesPerGroup}
								onChange={(value) => setAttributes({ slidesPerGroup: value })}
								min={1}
								max={6}
							/>

							<SelectControl
								label={__('Transition Effect', 'text-domain')}
								value={effect}
								options={[
									{ label: __('Slide', 'text-domain'), value: 'slide' },
									{ label: __('Fade', 'text-domain'), value: 'fade' }
								]}
								onChange={(value) => setAttributes({ effect: value })}
							/>
						</>
					)}
				</PanelBody>
			</InspectorControls>

			<section {...blockProps}>
				<div className="swiper">
					<div className="swiper-wrapper">
						<InnerBlocks
							allowedBlocks={['core/image', 'core/paragraph', 'core/heading']}
							templateLock={false}
							renderAppender={InnerBlocks.ButtonBlockAppender}
							wrapperProps={{ className: 'swiper-slide' }}
						/>
					</div>
					<div className="swiper-pagination"></div>
					<div className="swiper-button-next"></div>
					<div className="swiper-button-prev"></div>
				</div>
			</section>
		</>
	);
}

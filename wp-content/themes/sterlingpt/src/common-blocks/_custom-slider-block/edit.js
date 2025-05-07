import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	InnerBlocks
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	RangeControl
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		enableSlider,
		slidesToShow,
		slidesToScroll,
		navigationEnabled,
		paginationEnabled,
	} = attributes;

	const classes = [
		'custom-slider-grid',
		enableSlider ? 'swiper custom-slider' : 'grid-layout',
		enableSlider ? `slides-show-${slidesToShow}` : '',
	].join(' ');

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Layout Settings', 'textdomain')} initialOpen={true}>
					<ToggleControl
						label={__('Enable Slider', 'textdomain')}
						checked={enableSlider}
						onChange={(val) => setAttributes({ enableSlider: val })}
					/>
					{enableSlider && (
						<>
							<RangeControl
								label={__('Slides To Show', 'textdomain')}
								value={slidesToShow}
								onChange={(val) => setAttributes({ slidesToShow: val })}
								min={1}
								max={6}
							/>
							<RangeControl
								label={__('Slides To Scroll', 'textdomain')}
								value={slidesToScroll}
								onChange={(val) => setAttributes({ slidesToScroll: val })}
								min={1}
								max={slidesToShow}
							/>
							<ToggleControl
								label={__('Show Navigation', 'textdomain')}
								checked={navigationEnabled}
								onChange={(val) => setAttributes({ navigationEnabled: val })}
							/>
							<ToggleControl
								label={__('Show Pagination', 'textdomain')}
								checked={paginationEnabled}
								onChange={(val) => setAttributes({ paginationEnabled: val })}
							/>
						</>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps({ className: classes })}>
				<InnerBlocks />
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
		</>
	);
}

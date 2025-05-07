import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InnerBlocks,
	InspectorControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		navigationEnabled,
		paginationEnabled,
		loop,
		autoplayEnabled
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Slider Settings', 'sterlingpt')} initialOpen={true}>
					<ToggleControl
						label={__('Show Navigation', 'sterlingpt')}
						checked={navigationEnabled}
						onChange={(value) => setAttributes({ navigationEnabled: value })}
					/>
					<ToggleControl
						label={__('Show Pagination', 'sterlingpt')}
						checked={paginationEnabled}
						onChange={(value) => setAttributes({ paginationEnabled: value })}
					/>
					<ToggleControl
						label={__('Loop Slides', 'sterlingpt')}
						checked={loop}
						onChange={(val) => setAttributes({ loop: val })}
					/>
					<ToggleControl
						label={__('Enable Autoplay', 'sterlingpt')}
						checked={autoplayEnabled}
						onChange={(value) => setAttributes({ autoplayEnabled: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()} className={`hero-swiper-banner alignfull swiper mySwiper ${autoplayEnabled ? 'autoplay-on' : ''}`}>
				<InnerBlocks
					template={[
						[
							'core/group',
							{
								className: 'swiper-wrapper',
								align: 'full',
								spacing: {
									margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
									padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
								}
							},
							[
								[
									'core/cover',
									{
										templateLock: 'all',
										className: 'swiper-slide',
										align: 'full',
										style: {
											spacing: {
												margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
												padding: { bottom: '80px', top: '80px', right: '15px', left: '15px' }
											}
										}
									},
									[
										[
											'core/columns',
											{
												align: 'full',
												className: 'hero-swiper-content',
												style: { height: '768px', display: 'flex', alignItems: 'center', justifyContent: 'center' }
											},
											[
												[
													'core/column',
													{ width: '60%' },
													[
														[
															'core/heading',
															{
																level: 1,
																placeholder: 'Heading goes here...',
																content: '',
																style: {
																	color: { text: 'var(--wp--preset--color--white)' },
																	typography: { fontWeight: 600 },
																	spacing: {
																		margin: { bottom: '15px', top: '0px', right: '0px', left: '0px' },
																		padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
																	}
																}
															}
														],
														[
															'core/heading',
															{
																level: 2,
																placeholder: 'Subheading goes here...',
																content: '',
																style: {
																	color: { text: 'var(--wp--preset--color--white)' },
																	typography: { fontWeight: 500, fontSize: '18px', textTransform: 'uppercase' },
																	spacing: {
																		margin: { bottom: '15px', top: '0px', right: '0px', left: '0px' },
																		padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
																	}
																}
															}
														],
														[
															'core/paragraph',
															{
																placeholder: 'Paragraph goes here...',
																content: '',
																style: {
																	color: { text: 'var(--wp--preset--color--white)' },
																	typography: { fontSize: '16px', fontWeight: 400 },
																	spacing: {
																		margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
																		padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
																	}
																}
															}
														],
														[
															'core/buttons',
															{
																style: {
																	typography: { textTransform: 'uppercase' },
																	spacing: {
																		margin: { bottom: '0px', top: '0', right: '0px', left: '0px' },
																		padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
																	}
																}
															},
															[
																[
																	'core/button',
																	{
																		className: 'appointment-button',
																		placeholder: 'Request Appointment',
																		content: '',
																		style: {
																			spacing: {
																				margin: { bottom: '0px', top: '20px', right: '0px', left: '0px' },
																			}
																		}
																	}
																],
																[
																	'core/button',
																	{
																		placeholder: 'Learn More',
																		content: '',
																		style: {
																			spacing: {
																				margin: { bottom: '0px', top: '20px', right: '0px', left: '0px' },
																			}
																		}
																	}
																]
															]
														]
													]
												]
											]
										]
									]
								]
							]
						]
					]}
				/>

				{paginationEnabled && <div className="swiper-pagination"></div>}
				{navigationEnabled && (
					<>
						<div className="swiper-button-next"></div>
						<div className="swiper-button-prev"></div>
					</>
				)}
			</div>
		</>
	);
}

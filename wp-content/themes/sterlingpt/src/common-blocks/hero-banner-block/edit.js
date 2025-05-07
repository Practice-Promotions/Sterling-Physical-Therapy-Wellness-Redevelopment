import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div { ...useBlockProps() } className={ 'alignfull' }>
			<InnerBlocks
				template={[
					[
						'core/group', {
							className: 'hero-banner-list',
							align: 'full',
							spacing: {
								margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
								padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
							}
						},
						[
							[
								'core/cover', {
									templateLock: 'all',
									className: 'hero-banner-item',
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
										'core/columns', {
											align: 'full',
											className: 'hero-banner-content',
											style: { height: '768px', display: 'flex', alignItems: 'center', justifyContent: 'center' }
										},
										[
											[
												'core/column', {
													width: '60%'
												},
												[
													[
														'core/heading', {
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
														'core/heading', {
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
														'core/paragraph', {
															placeholder: 'Paragraph goes here...',
															content: '',
															style: {
																color: { text: 'var(--wp--preset--color--white)' },
																typography: { fontSize: '16px', fontWeight:400 },
																spacing: {
																	margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
																	padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
																}
															}
														}
													],
													[
														'core/buttons', {
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
																'core/button', {
																	className: 'appointment-button',
																	placeholder: 'Request Appointment',
																	content: '',
																	style: {
																		typography: {},
																		spacing: {
																			margin: { bottom: '0px', top: '20px', right: '0px', left: '0px' },
																		}
																	}
																}
															],
															[
																'core/button', {
																	className: '',
																	placeholder: 'Learn More',
																	content: '',
																	style: {
																		typography: {},
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
		</div>
    );
}

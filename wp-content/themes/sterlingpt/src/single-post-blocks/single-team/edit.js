import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div { ...useBlockProps() } className="alignwide">
			<InnerBlocks
				template={[
					[
						'core/columns', {
							style: {
								gap: '40px',
							},
						},
						[
							[
								'core/column', {
									width: '32%',
									className: 'staff-member-sidebar'
								},
								[
									[
										'core/group', {
											style: {
		                                        color: { background: 'var(--wp--preset--color--gray-200)' },
		                                        border: { radius: 'var(--wp--custom--settings-key--border-radius)'},
		                                        spacing: {
		                                            padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' }
		                                        }
		                                    }
										},
										[
											['core/post-featured-image', {
												sizeSlug: 'team-thumb'
											}],
											['core/post-title', {
												style: {
			                                        color: { text: 'var(--wp--preset--color--primary-100)' },
			                                        typography: { fontWeight: 600, fontSize: '28px', textTransform: 'capitalize' },
			                                    }
											}],
											[
                                                'single-team/team-info-injector', {
                                                  className: 'team-info'
                                                },
                                            ],
										],
									]
								],
							],
							[
								'core/column', {
									width: '68%',
									className: 'staff-member-content'

								},
								[
									[
										'core/group', {},
										[
											['core/post-content', {}],
										],
									],
								],
							],
						],
					],
				]}
			/>
		</div>
	);
}

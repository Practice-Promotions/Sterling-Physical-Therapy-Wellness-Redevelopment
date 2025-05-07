import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

import './style.scss';

export default function Edit() {
	return (
		<div { ...useBlockProps() } className={ 'alignwide' }>
			<InnerBlocks
				template={[
					['core/query', {
							className: 'blog-list',
							query: {
								offset: 0,
								postType: 'post',
								order: 'desc',
								orderBy: 'date',
								perPage: 3,
								sticky: 0,
							}
						},
						[
							['core/post-template', { align: 'wide' },
								[
									['core/post-featured-image', { isLink: 1, aspectRatio: '4/2.4' }],
									['core/post-date', {
										format: 'j F',
										className: 'post-date',
										style: {
											color: { background: 'var(--wp--preset--color--secondary-100)', text: 'var(--wp--preset--color--white)' },
											typography: { fontSize: '14px' },
											border: { radius: 'var(--wp--custom--settings-key--border-radius)' },
											spacing: { padding: '4px 11px' }
										},
									}],
									['core/group', {
										className: 'blog-content',
										style: {
											color: { background: 'var(--wp--preset--color--primary-200)' },
	                                        border: { radius: 'var(--wp--custom--settings-key--border-radius)' },
											spacing: {
												padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' },
												margin: { bottom: '0px', top: '-40px', right: '0px', left: '0px' }
											}
										},
									},
									[
										['core/post-title', {
											level: 3,
											style: {
												color: { text: 'var(--wp--preset--color--black)' },
												typography: { fontSize: '24px', fontWeight: 500 },
												spacing: {
													margin: { bottom: '8px', top: '0px', right: '0px', left: '0px' }
												}
											},
										}],
										['core/post-excerpt', {
											moreText: 'Read More',
											className: 'postexcerpt',
											style: {
												color: { text: 'var(--wp--preset--color--gray-400)' },
												typography: { fontSize: '14px' },
												spacing: {
													margin: { bottom: '0', top: '0px', right: '0px', left: '0px' }
												}
											},
										}],
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

import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

import './style.scss';

export default function Edit() {
	const blockProps = useBlockProps({
		className: 'alignwide',
	});

	return (
		<div { ...blockProps }>
			<InnerBlocks
				template={[
					['core/query', {
							className: 'newsletter-list',
							query: {
								postType: 'newsletter',
								perPage: 4,
								order: 'desc',
								orderBy: 'date',
							},
						},
						[
							['core/post-template', {
									align: 'wide',
						 		},
								[
									['core/post-featured-image', {
										isLink: true,
									}],
									['core/group', {
										className: 'post-content same-height',
										style: {
											color: { background: 'var(--wp--preset--color--gray-100)' },
											border: { radius: 'var(--wp--custom--settings-key--border-radius)' },
											spacing: {
												padding: { bottom: '20px', top: '20px', right: '20px', left: '20px' },
												margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
											},
											boxShadow: 'var(--wp--preset--shadow--natural)',
										},
									},
									[
										['core/post-date', {
											format: 'j F, Y',
											className: 'post-date',
											style: {
												color: { text: 'var(--wp--preset--color--secondary-100)' },
												typography: { fontSize: '16px' },
											},
										}],
										['core/post-title', {
											isLink: true,
											level: 3,
											style: {
												color: { text: 'var(--wp--preset--color--black)' },
												typography: { fontSize: '30px', fontWeight: 500 },
												spacing: {
													margin: { bottom: '0px', top: '8px' },
												},
											},
										}],
										[
											'newsletter-meta/block', {
											  className: 'newsletter-info'
											},
										],
										// ['core/read-more', {
										// 	style: {
										// 		spacing: {
										// 			margin: { top: '20px' },
										// 		},
										// 	},
										// }],
									]],
								],
							],
							// Add pagination here
							['core/query-pagination', {}, [
								['core/query-pagination-previous', {
									label: __('Previous Page', 'sterlingpt')
								}],
								['core/query-pagination-next', {
									label: __('Next Page', 'sterlingpt')
								}]
							]]
						]
					],
				]}
			/>
		</div>
	);
}

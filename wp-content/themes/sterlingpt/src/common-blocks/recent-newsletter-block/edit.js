import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import './style.scss';

export default function Edit() {
	return (
		<div { ...useBlockProps() } className={ 'alignwide' }>
			<InnerBlocks
				template={[
					['core/query', {
							className: 'recent-newsletter-list',
							query: {
								offset: 0,
								postType: 'newsletter',
								order: 'desc',
								orderBy: 'date',
								perPage: 4,
								sticky: 0,
							}
						},
						[
							['core/post-template', { align: 'wide' },
								[
									['core/post-featured-image', { isLink: 0, aspectRatio: '4/2.5' }],
									['core/group', {
										className: 'recent-newsletter-content',
										style: {
											color: { background: 'var(--wp--preset--color--gray-100)' },
											spacing: {
												padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' },
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

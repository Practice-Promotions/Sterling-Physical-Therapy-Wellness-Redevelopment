import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div {...useBlockProps()} className="alignwide">
			<InnerBlocks
				template={[
					[
						'core/query',
						{
							className: 'parent-page-list',
							query: {
								offset: 0,
								postType: 'page',
								order: 'desc',
								orderBy: 'menu_order',
								perPage: 50,
							},
							align: 'wide',
						},
						[
							[
								'core/post-template',
								{ align: 'wide', },
								[
									['core/columns', {
										style: {
											color: { background: 'var(--wp--preset--color--gray-100)' },
											border: { radius: 'var(--wp--custom--settings-key--border-radius)' },
											spacing: {
												margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
												padding: { bottom: '0', top: '0', right: '0', left: '0' }
											}
										}
									}, [
										[
											'core/column', { className: 'parent-page-item' }, [
												['core/post-featured-image', {
													isLink: true,
													className: 'parent-page-image',
													width: '100%',
													style: {
														spacing: {
															margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
															border: { radius: { topLeft: '8px', topRight: '8px' } },
														}
													}
												}],
												['core/group', {
													className: 'parent-page-content',
													style: {
														spacing: {
															margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
															padding: { bottom: '24px', top: '24px', right: '24px', left: '24px' }
														}
													}
												}, [
													['core/post-title', {
														isLink: true,
														style: {
															color: { text: 'var(--wp--preset--color--black)' },
															typography: { fontSize: '24px', fontWeight: 500, textTransform: 'capitalize' },
															spacing: {
																margin: { bottom: '8px', top: '0px', right: '0px', left: '0px' },
																padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
															}
														}
													}],
													['core/post-excerpt', {
														moreText: __('Read More', 'sterlingpt'),
														className: 'postexcerpt same-height',
														style: {
															color: { text: 'var(--wp--preset--color--gray-400)' },
															spacing: { margin: { bottom: '0px', top: '6px', right: '0px', left: '0px' } }
														},
														excerptLength: 19,
													}],
												]],
											],
										],
									]],
								],
							],
							[
								'core/heading',
								{
									level: 2,
									content: __('No data found', 'sterlingpt'),
									className: 'no-data-found-message',
									style: { color: 'var(--wp--preset--color--black)', textAlign: 'center', fontSize: '18px' },
								},
							],
						],
					],
				]}
			/>
		</div>
	);
}

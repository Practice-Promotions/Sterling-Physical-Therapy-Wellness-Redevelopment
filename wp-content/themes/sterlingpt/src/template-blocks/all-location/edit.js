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
								postType: 'location',
								order: 'ASC',
								orderBy: 'menu_order',
								perPage: 50,
							},
							align: 'wide',
						},
						[
							[
								'core/post-template',
								{
								  className: 'location-listing',
								  layout: {
									type: 'grid',
									columnCount: 3,
									minimumColumnWidth: ''
								  }
								},
								[
								  [
									'core/group',
									{
									  className: 'location-listing-item same-height',
									  style: {
										color: { background: 'var(--wp--preset--color--gray-100)' },
										border: { radius: { bottomLeft: '8px', bottomRight: '8px', topLeft: '8px', topRight: '8px' } },
										spacing: {
										  margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
										  padding: { bottom: '0', top: '0', right: '0', left: '0' }
										}
									  }
									},
									[
									  [
										'core/post-featured-image',
										{
										  isLink: true,
										  className: 'location-listing-media',
										  width: '100%',
										  style: {
											spacing: {
											  margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
											  border: { radius: { topLeft: '8px', topRight: '8px' } },
											}
										  }
										}
									  ],
									  [
										'query-loop-locations-custom-meta/block', {
										  className: 'location-listing-info-detail'
										}
									  ]
									]
								  ]
								]
							 ],
						],
					],
				]}
			/>
		</div>
	);
}

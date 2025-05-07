import { __ } from '@wordpress/i18n';
import { registerBlockVariation } from '@wordpress/blocks';
import './style.scss';
import { useSelect } from '@wordpress/data';
import { useState, useEffect } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Dashicon } from '@wordpress/components';
import { addFilter } from '@wordpress/hooks';
import metadata from './block.json';

const Testimonial_Block_Template = [
	[
		'core/group',
		{
			className: 'testimonial-block',
		},
		[
			[
				'core/post-template',
				{
					className: 'testimonial-block-listing',
				},
				[
					[
						'core/group',
						{
							className: 'testimonial-block-listing-item',
						},
						[
							[
								'testimonial-block/testimonial-meta-injector',
								{
									className: 'testimonial-block-meta',
								},
							],
							[
								'core/post-excerpt',
							],
							[
								'core/group',
								{
									style: {
										spacing: {
											blockGap: '5px',
										},
									},
									layout: {
										type: 'flex',
										orientation: 'horizontal',
									},
								},
								[
									[
										'core/paragraph',
										{
											content: '-',
										},
									],
									[
										'core/post-title',
									],
								],
							],
						],
					],
				],
			],
		],
	],
];




registerBlockVariation('core/query', {
	name: metadata.name,
	title: metadata.title,
	icon: metadata.icon,
	category: 'common_block',
	description: metadata.description,
	isActive: ['namespace'],
	attributes: {
		namespace: 'testimonial-block',
		...metadata.attributes,
	},

	editorStyle: "file:./index.css",
	allowedControls: ['all'],
	innerBlocks: Testimonial_Block_Template,

});

export const withPostListingControls = (BlockEdit) => (props) => {

	const {
		attributes: {
			query = {}, // Default value for core/query
			namespace,
		},
		setAttributes,
	} = props;

	// Ensure controls are only applied to 'testimonial-block' block variation
	if (namespace !== 'testimonial-block') {
		return <BlockEdit {...props} />;
	}

	// States to handle dynamic statuses, and selected posts
	const [selectedPostType, setSelectedPostType] = useState(query.postType || 'testimonial');
	const [selectedStatus, setSelectedStatus] = useState(query.status || 'publish');
	const [selectedPosts, setSelectedPosts] = useState(query.include || []);
	const [draggedPostId, setDraggedPostId] = useState(null);

	useEffect(() => {
		// Rerender listings on change of postType, status and selected posts
		setAttributes({
			query: {
				...query,
				postType: selectedPostType,
				status: selectedStatus,
				include: selectedPosts
			},
		});

	}, [selectedPostType, selectedStatus, selectedPosts]);

	const postTypes = useSelect((select) => {

		const allPostTypes = select('core').getPostTypes({ per_page: -1 }) || [];
		return allPostTypes.filter((postType) => ['testimonial'].includes(postType.slug));

	}, []);

	const posts = useSelect(
		(select) => {
			return select('core').getEntityRecords('postType', selectedPostType, {
				status: selectedStatus, // Filter posts by the selected status
				per_page: -1, // Retrieve all posts
			});
		},
		[selectedPostType, selectedStatus] // Dependencies: refetch if either selectedPostType or selectedStatus changes
	);

	const handlePostSelect = (newSelectedPostIds) => {

		const newSelectedIdsAsNumbers = newSelectedPostIds.map(id => parseInt(id, 10));
		const updatedSelectedPosts = Array.from(new Set([...selectedPosts.map(id => parseInt(id, 10)), ...newSelectedIdsAsNumbers]));

		setSelectedPosts(updatedSelectedPosts);

		setAttributes({
			query: {
				...query,
				orderBy: 'include',
				include: updatedSelectedPosts,
				perPage: updatedSelectedPosts.length > 0 ? updatedSelectedPosts.length : -1,
			},
		});

	};

	const handlePostDeselect = (postId) => {

		const updatedSelectedPosts = selectedPosts.filter((id) => id !== postId);

		setSelectedPosts(updatedSelectedPosts);

		setAttributes({
			query: {
				...query,
				orderBy: 'include',
				include: updatedSelectedPosts,
				perPage: updatedSelectedPosts.length > 0 ? updatedSelectedPosts.length : -1,
			},
		});

	};

	const handleDragStart = (postId) => {
		setDraggedPostId(postId);
	};

	const handleDragOver = (e) => {
		e.preventDefault();
	};

	const handleDrop = (targetId) => {
		if (draggedPostId !== null) {
			const newSelectedPosts = selectedPosts.filter((id) => id !== draggedPostId);
			const targetIndex = newSelectedPosts.indexOf(targetId);
			newSelectedPosts.splice(targetIndex, 0, draggedPostId);
			setSelectedPosts(newSelectedPosts);
			setDraggedPostId(null); // Reset dragged post ID
		}
	};

	return (
		<>
			<BlockEdit {...props} />
			{'testimonial-block' === namespace && (
				<InspectorControls>
					<PanelBody title="Testimonial Listings Settings">

						<SelectControl
							label="Select Post Type"
							value={selectedPostType}
							options={postTypes?.map((type) => (
								{
									label: type.labels.singular_name,
									value: type.slug
								}
							))}
							onChange={(value) => {
								setSelectedPostType(value);
								setSelectedStatus('publish');
								setSelectedPosts([]);
							}}
						/>

						<SelectControl
							label="Select Status"
							value={selectedStatus}
							options={[
								{ label: 'Publish', value: 'publish' }
							]}
							onChange={(value) => {
								setSelectedStatus(value);
								setSelectedPosts([]);
							}}
						/>

						<SelectControl
							multiple
							label={__('Choose Testimonial Posts', 'sterlingpt')}
							value={selectedPosts.map(id => parseInt(id, 10))}
							options={
								posts
									?.filter((post) => !selectedPosts.includes(post.id))
									.map((post) => ({
										label: post.title.rendered || `(no title) (${post.id})`,
										value: parseInt(post.id, 10)
									})) || []
							}
							onChange={handlePostSelect}
						/>
						<div className="listings-result-container">
							{posts?.length > 0 ? (
								selectedPosts.length > 0 ? (
									<>
										<label className="components-base-control__label">
											{__('Selected Testimonial Posts', 'sterlingpt')}
										</label>
										<div className="selected-posts">
											<ul>
												{selectedPosts.map((postId) => {
													const post = posts?.find((p) => p.id == postId);
													return post ? (
														<li
															key={postId}
															className="selected-post-item-wrap"
															draggable
															onDragStart={() => handleDragStart(postId)}
															onDragOver={handleDragOver}
															onDrop={() => handleDrop(postId)}
														>
															<div className="selected-post-item">
																{post.title.rendered || `(no title) (${postId})`}
																<Dashicon
																	icon="no"
																	onClick={() => handlePostDeselect(postId)}
																	aria-label={__('Deselect this post', 'sterlingpt')}
																	style={{ cursor: 'pointer', color: 'red' }}
																/>
															</div>
														</li>
													) : null;
												})}
											</ul>
										</div>
									</>
								) : (
									<p>{__('No posts selected.', 'sterlingpt')}</p>
								)
							) : (
								<p>{__('No posts are available with the current configuration.', 'sterlingpt')}</p>
							)}
						</div>
					</PanelBody>
				</InspectorControls>
			)}
		</>
	);
};
addFilter('editor.BlockEdit', 'core/query', withPostListingControls);
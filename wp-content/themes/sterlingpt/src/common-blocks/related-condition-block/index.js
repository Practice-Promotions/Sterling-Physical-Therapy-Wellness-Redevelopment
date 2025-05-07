import { __ } from '@wordpress/i18n';
import { registerBlockVariation } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { useState, useEffect } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Dashicon, Draggable } from '@wordpress/components';
import { addFilter } from '@wordpress/hooks';
import './editor.scss';
import metadata from './block.json';


const RELATED_CONDITION_QUERY_TEMPLATE = [
  [ 'core/post-template', {
      className: 'page-list',
      layout: {
        type: 'grid',
        columnCount: 4,
        minimumColumnWidth: ''
      }
    },
    [
      [ 'core/group', {
          className: 'page-list-item same-height',
          style: {
            color: { background: '#F1F7FB' },
            border: { radius: { bottomLeft: '8px', bottomRight: '8px', topLeft: '8px', topRight: '8px' } },
            spacing: {
              margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
              padding: { bottom: '0', top: '0', right: '0', left: '0' }
            }
          }
        },
        [
          [ 'core/post-featured-image', {
              isLink: true,
              className: 'page-list-media',
              width: '100%',
              style: {
                spacing: {
                  margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                  border: { radius: { topLeft: '8px', topRight: '8px' } },
                }
              }
            }
          ],
		  [ 'core/post-title', {
              isLink: true,
			        level: 4,
              className: 'page-heading',
              width: '100%',
              textAlign: 'center',
              style: {
                typography: {
                  fontSize: 'var(--wp--preset--font-size--default)',
                },
                spacing: {
                  margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                  padding: { bottom: '15px', top: '15px', right: '15px', left: '15px' },
                  border: { radius: { topLeft: '8px', topRight: '8px' } },
                }
              }
            }
          ]
        ]
      ]
    ]
 ]

];


registerBlockVariation('core/query', {

	name: metadata.name,
	title: metadata.title,
	icon: metadata.icon,
	description: metadata.description,
	category: 'common_block',
	isActive: ['namespace'],
	attributes: {
	namespace: 'related-conditions',
	...metadata.attributes,
	},
	editorStyle: "file:./index.css",
	allowedControls: ['all'],
	innerBlocks: RELATED_CONDITION_QUERY_TEMPLATE,

});


export const withPostListingControls = (BlockEdit) => (props) => {

  const {
    attributes: {
      query = {}, // Default value for core/query
      namespace,
    },
    setAttributes,
  } = props;

  // Ensure controls are only applied to 'related-conditions' block variation
  if (namespace !== 'related-conditions') {
    return <BlockEdit {...props} />;
  }

  // States to handle dynamic post types, statuses, and selected posts
  const [selectedPostType, setSelectedPostType] = useState(query.postType || 'page');
  const [selectedStatus, setSelectedStatus]     = useState(query.status || 'publish');
  const [selectedPosts, setSelectedPosts]       = useState(query.include || []);
  const [draggedPostId, setDraggedPostId]       = useState(null);

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

    // Retrieve all post types from the WordPress data store.
    const allPostTypes = select('core').getPostTypes({ per_page: -1 }) || [];

    // Filter the retrieved post types to include only specific types.
    return allPostTypes.filter((postType) => ['page'].includes(postType.slug));

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

    // Convert newSelectedPostIds to integers
    const newSelectedIdsAsNumbers = newSelectedPostIds.map(id => parseInt(id, 10));

    // Update selectedPosts by combining with the new selection
    const updatedSelectedPosts = Array.from(new Set([...selectedPosts.map(id => parseInt(id, 10)), ...newSelectedIdsAsNumbers]));

    // Update state with new selection
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
      e.preventDefault(); // Prevent default to allow dropping
  };

  const handleDrop = (targetId) => {
    if (draggedPostId !== null) {
        // Remove the dragged post ID from the array
        const newSelectedPosts = selectedPosts.filter((id) => id !== draggedPostId);

        // Find the index of the target ID
        const targetIndex = newSelectedPosts.indexOf(targetId);

        // Insert the dragged ID at the target index
        newSelectedPosts.splice(targetIndex, 0, draggedPostId);

        // Update the selected posts state
        setSelectedPosts(newSelectedPosts);
        setDraggedPostId(null); // Reset dragged post ID
    }
  };

  return (
    <>
      <BlockEdit {...props} />
        {'related-conditions' === namespace && (
          <InspectorControls>
            <PanelBody title="Page Listings Settings">

              {/* Page Selection */}
              <SelectControl
                label="Select Page"
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
                  setSelectedPosts([]);  // Clear selected posts
                }}
              />

              {/* Page Selection */}
              <SelectControl
                label="Select Status"
                value={selectedStatus}
                options={[
                  { label: 'Publish', value: 'publish' },
                ]}
                onChange={(value) => {
                  setSelectedStatus(value);
                  setSelectedPosts([]);
                }}
              />

              {/* Choose approprite posts */}
              <SelectControl
                multiple
                label={__('Choose Page', 'sterlingpt')}
                value={selectedPosts.map(id => parseInt(id, 10))} // Convert selectedPosts to integers
                options={
                    posts
                        ?.filter((post) => !selectedPosts.includes(post.id))
                        .map((post) => ({
                            label: post.title.rendered || `(no title) (${post.id})`,
                            value: parseInt(post.id, 10) // Ensure value is integer
                        })) || []
                }
                onChange={handlePostSelect}
              />
              <div className="listings-result-container">
                {posts?.length > 0 ? (
                    selectedPosts.length > 0 ? (
                        <>
                            <label className="components-base-control__label">
                                {__('Selected Page', 'sterlingpt')}
                            </label>
                            <div className="selected-page">
                                <ul>
                                    {selectedPosts.map((postId) => {
                                        const post = posts?.find((p) => p.id == postId);
                                        return post ? (
                                          <li
                                              key={postId}
                                              className="selected-page-item-wrap"
                                              draggable
                                              onDragStart={() => handleDragStart(postId)}
                                              onDragOver={handleDragOver}
                                              onDrop={() => handleDrop(postId)}
                                          >
                                              <div className="selected-page-item">
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
                        <p>{__('No pages selected.', 'sterlingpt')}</p>
                    )
                ) : (
                    <p>{__('No pages are available with the current configuration.', 'sterlingpt')}</p>
                )}
              </div>
            </PanelBody>
          </InspectorControls>
        )}
    </>
  );
};
addFilter('editor.BlockEdit', 'core/query', withPostListingControls);

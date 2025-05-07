import { __ } from '@wordpress/i18n';
import { registerBlockVariation } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { useState, useEffect } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Dashicon } from '@wordpress/components';
import { addFilter } from '@wordpress/hooks';
import metadata from './block.json';

/**
 * Defines a Team custom listing template with a grid layout, including featured image, post title, and custom meta information
 */
const TEAM_BLOCK_TEMPLATE = [
  [
    'core/post-template',
    {
      className: 'listings-wrapper',
      layout: {
        type: 'grid',
        columnCount: 3,
        minimumColumnWidth: '', 
        gap: '40px' 
      }
    },
    [
      [
        'core/group',
        { className: 'team-listing-item' },
        [
          [
            'core/post-featured-image',
            { 
              className: 'team-listing-featured-image', 
              sizeSlug: 'team-thumb',
              isLink: false,
              style: {
                border: {
                  radius: '8px'
                },
                spacing: { 
                  margin: { top: '0px', right: '0px', bottom: '20px', left: '0px' } 
                } 
              } 
            }
          ],
          [
            'core/post-title',
            {
              className: 'team-listing-title',
              level: 3,
              textAlign: 'center',
              style: {
                textTransform: 'capitalize',
                typography: {
                  lineHeight: 1.33,
                  fontSize: '22px'
                },
                spacing: { 
                  margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
                  padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' } 
                }
              }
            }
          ],
          [
            'query-loop-team-custom-meta/block', {
              className: 'team-listing-meta'
            },
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
  category: 'archive_template_block',
  description: metadata.description,
  isActive: ['namespace'],
  attributes: {
    namespace: 'team-listings',
    ...metadata.attributes,
  },

  editorStyle: "file:./index.css",
  allowedControls: ['all'],
  innerBlocks: TEAM_BLOCK_TEMPLATE,
});

export const withPostListingControls = (BlockEdit) => (props) => {
  const {
      attributes: { query = {}, namespace, locationCategory = '' },
      setAttributes,
  } = props;

  // Ensure controls are only applied to 'team-listings' block variation
  if (namespace !== 'team-listings') {
    return <BlockEdit {...props} />;
  }

  const [selectedPostType, setSelectedPostType] = useState(query.postType || 'our_team');
  const [selectedStatus, setSelectedStatus] = useState(query.status || 'publish');
  const [selectedPosts, setSelectedPosts] = useState(query.include || []);
  const [selectedLocationCategory, setSelectedLocationCategory] = useState(locationCategory);
  const [draggedPostId, setDraggedPostId]       = useState(null);

  // Update block attributes whenever states change
  useEffect(() => {
      setAttributes({
          query: {
              ...query,
              postType: selectedPostType,
              status: selectedStatus,
              include: selectedPosts,
          },
          locationCategory: selectedLocationCategory,
      });
  }, [selectedPostType, selectedStatus, selectedPosts, selectedLocationCategory]);

  // Fetch all post types
  const postTypes = useSelect((select) => {
      const allPostTypes = select('core').getPostTypes({ per_page: -1 });
      return allPostTypes ? allPostTypes.filter((type) => ['our_team'].includes(type.slug)) : [];
  }, []);

  // Fetch all categories for the selected taxonomy
  const locationCategories = useSelect((select) => {
      const categories = select('core').getEntityRecords('taxonomy', 'location_category', { per_page: -1 });
      return categories || [];
  }, []);

  // Fetch posts based on selected filters
  const posts = useSelect((select) => {
      const queryArgs = {
          status: selectedStatus,
          per_page: -1,
      };
      if (selectedLocationCategory) {
          queryArgs['location_category'] = selectedLocationCategory;
      }
      const fetchedPosts = select('core').getEntityRecords('postType', selectedPostType, queryArgs);
      return fetchedPosts || [];
  }, [selectedPostType, selectedStatus, selectedLocationCategory]);

  // Add posts to the selected list
  const handlePostSelect = (newSelectedPostIds) => {
      const updatedSelectedPosts = Array.from(new Set([...selectedPosts, ...newSelectedPostIds.map((id) => parseInt(id, 10))]));
      setSelectedPosts(updatedSelectedPosts);
  };

  // Remove a post from the selected list
  const handlePostDeselect = (postId) => {
      const updatedSelectedPosts = selectedPosts.filter((id) => id !== postId);
      setSelectedPosts(updatedSelectedPosts);
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
          {'team-listings' === namespace && (
          <InspectorControls>
              <PanelBody title={__('Team Listings Settings', 'sterlingpt')}>
                  {/* Post Type Selector */}
                  <SelectControl
                      label={__('Select Post Type', 'sterlingpt')}
                      value={selectedPostType}
                      options={postTypes.map((type) => ({
                          label: type.labels.singular_name,
                          value: type.slug,
                      }))}
                      onChange={(value) => {
                          setSelectedPostType(value);
                      }}
                  />
                  {/* Post Status Selector */}
                  <SelectControl
                      label={__('Select Status', 'sterlingpt')}
                      value={selectedStatus}
                      options={[{ label: 'Publish', value: 'publish' }]}
                      onChange={(value) => {
                          setSelectedStatus(value);
                      }}
                  />
                  {/* Location Category Selector */}
                  <SelectControl
                      label={__('Filter by Location Category', 'sterlingpt')}
                      value={selectedLocationCategory}
                      options={[
                          { label: __('All Locations', 'sterlingpt'), value: '' },
                          ...locationCategories.map((term) => ({
                              label: term.name,
                              value: term.id,
                          })),
                      ]}
                      onChange={(value) => {
                          setSelectedLocationCategory(value);
                      }}
                  />
                  {/* Choose Posts Dropdown */}
                  <SelectControl
                    multiple
                    label={__('Choose Team Posts', 'sterlingpt')}
                    value={selectedPosts}
                    options={
                      posts
                        .filter((post) => !selectedPosts.includes(post.id)) // Filter out already selected posts
                        .map((post) => ({
                          label: post.title.rendered || `(no title) (${post.id})`,
                          value: post.id,
                        }))
                    }
                    onChange={(newSelected) => {
                      handlePostSelect(newSelected.map((id) => parseInt(id, 10)));
                    }}
                  />

                  {/* Selected Posts Tab */}
                  <div className="listings-result-container">
                      <label className="components-base-control__label">
                          {__('Selected Team Posts', 'sterlingpt')}
                      </label>
                      {selectedPosts.length > 0 ? (
                          <ul className="selected-posts">
                              {selectedPosts.map((postId) => {
                                  const post = posts.find((p) => p.id === postId);
                                  return (
                                      post && (
                                          <li 
                                            key={postId} 
                                            className="selected-post-item"
                                            draggable
                                            onDragStart={() => handleDragStart(postId)}
                                            onDragOver={handleDragOver}
                                            onDrop={() => handleDrop(postId)}
                                          >
                                              <span>{post.title.rendered || `(no title) (${postId})`}</span>
                                              <Dashicon
                                                  icon="no"
                                                  onClick={() => handlePostDeselect(postId)}
                                                  style={{ cursor: 'pointer', color: 'red' }}
                                              />
                                          </li>
                                      )
                                  );
                              })}
                          </ul>
                      ) : (
                          <p>{__('No posts selected.', 'sterlingpt')}</p>
                      )}
                  </div>
              </PanelBody>
          </InspectorControls>
        )}
      </>
  );
};

addFilter('editor.BlockEdit', 'core/query', withPostListingControls);
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
							className: 'location-single-location',
							query: {
								postType: 'location',
								perPage: 1,
								order: 'desc',
								orderBy: 'date',
							},
						},
						[
							[
							    'core/post-template',
							    {
							      className: 'location-listing',
							      layout: {
							        type: 'grid',
							        columnCount: 1
							      }
							    },
							    [
							      [
							        'core/group',
							        {
							          className: 'section-spacer',
							          layout: {
							            type: 'constrained'
							          }
							        },
							        [
							          [
							            'core/group',
							            {
							              className: 'location-single-heading',
							              style: {
							                spacing: {
							                  padding: {
							                    bottom: '50px'
							                  }
							                }
							              },
							              layout: {
							                type: 'constrained'
							              }
							            },
							            [
							              ['core/heading', {
							                level: 6,
							                placeholder: 'Contact us',
							                content: '',
							                style: {
							                  color: { text: 'var(--wp--preset--color--secondary-100)' },
							                  typography: { fontWeight: 400, fontSize: '18px', textTransform: 'uppercase' },
							                  spacing: {
							                    margin: { bottom: '6px', top: '0px', right: '0px', left: '0px' },
							                    padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
							                  }
							                }
							              }],
							              ['core/heading', {
							                level: 2,
							                placeholder: 'Let’s Connect',
							                content: '',
							                style: {
							                  color: { text: 'var(--wp--preset--color--primary-100)' },
							                  typography: { fontWeight: 600, fontSize: '48px' },
							                  spacing: {
							                    margin: { bottom: '6px', top: '0px', right: '0px', left: '0px' },
							                    padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
							                  }
							                }
							              }],
							              ['core/paragraph', {
							                placeholder: 'Lorem ipsum dolor ',
							                content: '',
							                style: {
							                  typography: { fontSize: '24px', fontWeight:400 },
							                  spacing: {
							                    margin: { bottom: '0px', top: '0px', right: '0px', left: '0px' },
							                    padding: { bottom: '0px', top: '0px', right: '0px', left: '0px' }
							                  }
							                }
							              }],
							            ]
							          ],
							          [
							            'core/columns',
							            {
							              style: {
							                spacing: {
							                  blockGap: {
							                    left: '60px'
							                  }
							                }
							              }
							            },
							            [
							              [
							                'core/column',
							                {
							                  width: '59%'
							                },
							                [
							                  ['gravityforms/form', {
							                    id: 38, 
							                    className: 'gravity-form'
							                  }],
							                ],
							              ],
							              [
							                'core/column',
							                {
							                  width: '1px',
							                  style: {
							                    spacing: {
							                      padding: {
							                        top: '0',
							                        bottom: '0'
							                      }
							                    }
							                  },
							                  backgroundColor: 'primary-200'
							                }
							              ],
							              [
							                'core/column',
							                {
							                  width: '39%'
							                },
							                [
							                  [
							                    'core/group',
							                    {
							                      className: 'location-listing-item',
							                      style: {
							                        border: {
							                          radius: {
							                            bottomLeft: '8px',
							                            bottomRight: '8px',
							                            topLeft: '8px',
							                            topRight: '8px'
							                          }
							                        },
							                        spacing: {
							                          margin: {
							                            bottom: '0px',
							                            top: '0px',
							                            right: '0px',
							                            left: '0px'
							                          },
							                          padding: {
							                            bottom: '0',
							                            top: '0',
							                            right: '0',
							                            left: '0'
							                          }
							                        }
							                      }
							                    },
							                    [
							                      [
							                        'contact-single-location/location-meta-injector',
							                        {
							                          className: 'location-listing-info-detail'
							                        }
							                      ]
							                    ]
							                  ]
							                ]
							              ]
							            ]
							          ],
							          [
							            'core/group',
							            {
							              className: 'location-single-map',
							              style: {
							                spacing: {
							                  padding: {
							                    top: '95px',
							                    bottom: '95px'
							                  }
							                }
							              },
							              layout: {
							                type: 'constrained'
							              }
							            },
							            [
							              [
							                'contact-single-location/location-meta-injector',
							                {
							                  className: 'location-map'
							                }
							              ]
							            ]
							          ]
							        ]
							      ]
							    ]
							  ]
						]
					],
				]}
			/>
		</div>
	);
}

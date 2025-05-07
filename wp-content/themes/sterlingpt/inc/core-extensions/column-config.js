(function () {
    // Wait for WordPress to be ready
    if (typeof wp === 'undefined') {
        return;
    }

    wp.hooks.addFilter(
        "blocks.registerBlockType",
        "custom/extend-columns-settings",
        (settings, name) => {
            if (name !== "core/columns") {
                return settings;
            }

            return {
                ...settings,
                attributes: {
                    ...settings.attributes,
                    justifyContent: {
                        type: "string",
                        default: ""
                    }
                },
                supports: {
                    ...settings.supports,
                    align: true,
                    layout: true
                }
            };
        }
    );

    const { createHigherOrderComponent } = wp.compose;
    const { Fragment } = wp.element;
    const { InspectorControls } = wp.blockEditor;
    const { PanelBody, Button, Flex, FlexItem } = wp.components;
    const { __ } = wp.i18n;

    const withInspectorControls = createHigherOrderComponent((BlockEdit) => {
        return (props) => {
            if (props.name !== "core/columns") {
                return wp.element.createElement(BlockEdit, props);
            }

            const { attributes, setAttributes } = props;
            const { justifyContent } = attributes;

            const justificationOptions = [
                {
                    value: 'flex-start',
                    icon: wp.element.createElement('svg', {
                        width: '20',
                        height: '20',
                        viewBox: '0 0 24 24',
                        xmlns: 'http://www.w3.org/2000/svg'
                    }, wp.element.createElement('path', {
                        d: 'M9 9v6h11V9H9zM4 20h1.5V4H4v16z'
                    })),
                    label: __('Justify items left')
                },
                {
                    value: 'center',
                    icon: wp.element.createElement('svg', {
                        width: '20',
                        height: '20',
                        viewBox: '0 0 24 24',
                        xmlns: 'http://www.w3.org/2000/svg'
                    }, wp.element.createElement('path', {
                        d: 'M20 9h-7.2V4h-1.6v5H4v6h7.2v5h1.6v-5H20z'
                    })),
                    label: __('Justify items center')
                },
                {
                    value: 'flex-end',
                    icon: wp.element.createElement('svg', {
                        width: '20',
                        height: '20',
                        viewBox: '0 0 24 24',
                        xmlns: 'http://www.w3.org/2000/svg'
                    }, wp.element.createElement('path', {
                        d: 'M4 9v6h11V9H4zm15-5h-1.5v16H20V4z'
                    })),
                    label: __('Justify items right')
                },
                {
                    value: 'space-between',
                    icon: wp.element.createElement('svg', {
                        width: '20',
                        height: '20',
                        viewBox: '0 0 24 24',
                        xmlns: 'http://www.w3.org/2000/svg'
                    }, wp.element.createElement('path', {
                        d: 'M9 15h6V9H9v6zM4 20h1.5V4H4v16zm14.5 0H20V4h-1.5v16z'
                    })),
                    label: __('Space between items')
                }
            ];

            return wp.element.createElement(
                Fragment,
                null,
                wp.element.createElement(BlockEdit, props),
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        {
                            title: "Layout Settings",
                            initialOpen: true
                        },
                        wp.element.createElement(
                            'div',
                            { 
                                className: 'block-editor-hooks__flex-layout-justification-controls',
                                style: {
                                    marginBottom: '24px'
                                }
                            },
                            wp.element.createElement(
                                'div',
                                {
                                    style: {
                                        marginBottom: '8px',
                                        textTransform: 'uppercase',
                                        fontSize: '11px',
                                        fontWeight: '500',
                                        lineHeight: '1.4',
                                        color: '#1e1e1e'
                                    }
                                },
                                'Justification'
                            ),
                            wp.element.createElement(
                                Flex,
                                { 
                                    gap: 1, 
                                    justify: "flex-start", 
                                    className: "block-editor-hooks__flex-layout-justification-controls"
                                },
                                justificationOptions.map((option) =>
                                    wp.element.createElement(
                                        FlexItem,
                                        { key: option.value },
                                        wp.element.createElement(
                                            Button,
                                            {
                                                label: option.label,
                                                icon: option.icon,
                                                isPressed: justifyContent === option.value,
                                                onClick: () => setAttributes({
                                                    justifyContent: justifyContent === option.value ? '' : option.value
                                                })
                                            }
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            );
        };
    }, 'withInspectorControls');

    wp.hooks.addFilter(
        'editor.BlockEdit',
        'custom/add-columns-justify-control',
        withInspectorControls
    );

    wp.hooks.addFilter(
        "editor.BlockListBlock",
        "custom/columns-editor-style",
        createHigherOrderComponent((BlockListBlock) => {
            return (props) => {
                if (props.name !== "core/columns") {
                    return wp.element.createElement(BlockListBlock, props);
                }

                const { attributes } = props;
                const { justifyContent } = attributes;

                let wrapperProps = props.wrapperProps || {};
                let style = { ...wrapperProps.style } || {};

                if (justifyContent) {
                    style.justifyContent = justifyContent;
                }

                wrapperProps = {
                    ...wrapperProps,
                    style: style
                };

                return wp.element.createElement(BlockListBlock, {
                    ...props,
                    wrapperProps: wrapperProps
                });
            };
        }, "withColumnsStyle")
    );

    wp.hooks.addFilter(
        "blocks.getSaveElement",
        "custom/apply-columns-justify-style",
        (element, blockType, attributes) => {
            if (blockType.name !== "core/columns") {
                return element;
            }

            if (!element || !element.props) {
                return element;
            }

            const existingStyle = element.props.style || {};
            const newStyle = { 
                ...existingStyle,
                justifyContent: attributes.justifyContent || ""
            };

            if (!newStyle.justifyContent) {
                delete newStyle.justifyContent;
            }

            return wp.element.cloneElement(element, {
                style: newStyle
            });
        }
    );
})();

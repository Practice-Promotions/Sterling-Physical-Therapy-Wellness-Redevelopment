wp.hooks.addFilter( // wp.hooks.addFilter is used to modify the settings of a block before it is registered.

    "blocks.registerBlockType", // The first argument ('blocks.registerBlockType') tells WordPress we are modifying a block type's settings.

    "custom/extend-group-settings", // The second argument is a unique namespace (to avoid conflicts with other custom filters).

    (settings, name) => {

        // This condition ensures that we are only modifying the core/columns block and not other blocks
        if (name !== "core/group") {
            return settings;  // If it's not the Columns block, return original settings
        }

        return {
            ...settings,  // Keeps all the existing settings of the block.
            attributes: {
                ...settings.attributes, // Ensures we don't override existing attributes.
                padding: {
                    type: "string",
                    default: ""  // New attribute with default value
                }
            }
        };
    }
);

wp.hooks.addFilter( // is used to modify how a block appears in the editor (Block Edit UI).

    "editor.BlockEdit", //  is a WordPress filter that allows us to change how blocks are edited in the Gutenberg editor.

    "custom/add-group-align-control", // is a unique namespace to avoid conflicts with other custom filters.

    wp.compose.createHigherOrderComponent((BlockEdit) => { // This allows us to inject additional controls into the block's settings panel without overriding the block itself.

        return (props) => {

            if (props.name !== "core/group") { // props.name contains the block type && If the block is not core/columns, we return the original block settings without modification.
                return wp.element.createElement(BlockEdit, props);
            }

            // "attributes" → contains the block's attributes (including the new padding attribute we added earlier).
            // "setAttributes" → is a function to update the block's attributes dynamically.
            // "padding" → is the custom attribute we added earlier using blocks.registerBlockType

            const { attributes, setAttributes } = props;
            const { padding } = attributes;

            return wp.element.createElement(
                wp.element.Fragment,  //  Used to group multiple elements without adding an extra wrapper
                {},
                wp.element.createElement(BlockEdit, props), // Ensures that the original Columns block UI remains intact.

                wp.element.createElement( // Allows us to add new settings in the right sidebar of Gutenberg (Block Settings).

                    wp.blockEditor.InspectorControls,

                    {},

                    // New Separate Panel Named "Custom Alignment Settings"
                    wp.element.createElement(

                        wp.components.PanelBody, // Creates a collapsible panel inside the block settings.

                        { 
                            title: "Section Padding[Top|Bottom]", //  The name of the new section (separate from "Advanced").
                            initialOpen: true  // Ensures that this section is open by default when selected.
                        }, 
                        wp.element.createElement(wp.components.SelectControl, { // Adds a dropdown inside "Custom Alignment Settings".
                            label: "Section Padding",
                            value: padding,
                            options: [
                                { label: "None", value: "" },
                                { label: "Default Spacing - 50px", value: "section-spacer" },
                                { label: "Small Spacing - 40px", value: "section-spacer-sm" },
                                { label: "Medium Spacing - 75px", value: "section-spacer-md" },
                                { label: "Large Spacing - 100px", value: "section-spacer-lg" }
                            ],
                            onChange: (value) => setAttributes({ padding: value }), // Updates the block's attributes dynamically when the user selects an option.
                        })
                    )
                )
            );
        };
    }, "withPaddingSettings")
);

// Add new filter for editor view styling
wp.hooks.addFilter(
    "editor.BlockListBlock",
    "custom/group-editor-style",
    wp.compose.createHigherOrderComponent((BlockListBlock) => {
        return (props) => {
            if (props.name !== "core/group") {
                return wp.element.createElement(BlockListBlock, props);
            }

            const { attributes } = props;
            const { padding } = attributes;

            // Get existing classes
            let wrapperProps = props.wrapperProps || {};
            let className = wrapperProps.className || '';

            // Add padding class if it exists
            if (padding) {
                className = `${className} ${padding}`.trim();
            }

            wrapperProps = {
                ...wrapperProps,
                className: className
            };

            return wp.element.createElement(BlockListBlock, {
                ...props,
                wrapperProps: wrapperProps
            });
        };
    }, "withGroupPaddingStyle")
);

wp.hooks.addFilter( // is used to modify the saved HTML output of the block.
    
    "blocks.getSaveElement", // is a WordPress filter that allows us to alter how a block appears in the frontend when it is saved.
    "custom/apply-group-align-style", // is a unique namespace to avoid conflicts with other custom filters.

    (element, blockType, attributes) => {

        if (blockType.name !== "core/group") { // If the block is NOT core/columns, return it unchanged
            return element;
        }

        // Generate a custom class based on the selected alignment
        const customClass = attributes.padding ? attributes.padding : "";

        return wp.element.cloneElement(element, { // Clones the existing block's HTML while adding custom properties.
            className: customClass ? `${element.props.className || ""} ${customClass}`.trim() : element.props.className || ""
        });
    }
);

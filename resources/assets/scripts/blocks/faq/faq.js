const { useBlockProps, InnerBlocks } = wp.blockEditor;

const attributes = {
  additionalListCssClasses: {
    type: "string",
  },
};

export default {
  title: "FAQ List",
  description:
    "List your Frequently Asked Questions in an SEO-friendly way. You can only use one FAQ block per post.",
  icon: "editor-ul",
  category: "widgets",
  keywords: [
    "FAQ",
    "Frequently Asked Questions",
    "Schema",
    "SEO",
    "Structured Data",
  ],
  // Allow only one FAQ block per post.
  supports: {
    multiple: false,
  },
  // Block attributes - decides what to save and how to parse it from and to HTML.
  attributes,

  /**
   * The edit function describes the structure of your block in the context of the editor.
   * This represents what the editor will render when the block is used.
   *
   * The "edit" property must be a valid function.
   *
   * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
   * @returns {Component} The editor component.
   */
  edit: ({ attributes, setAttributes, className }) => {
    const blockProps = useBlockProps();

    return (
      // <div className="border border-solid border-gray-100 px-2 py-1">
      // <span className="text-gray-500 text-sm font-bold">FAQ List</span>
      <div {...blockProps}>
        <InnerBlocks allowedBlocks={["sample-wordpress/faq-question"]} />
      </div>
      // </div>
    );
  },

  /* eslint-disable react/display-name */
  /**
   * The save function defines the way in which the different attributes should be combined
   * into the final markup, which is then serialized by Gutenberg into post_content.
   *
   * The "save" property must be specified and must be a valid function.
   *
   * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
   * @returns {Component} The display component.
   */
  save: function ({ attributes }) {
    const blockProps = useBlockProps.save();

    return (
      // <div className="schema-faq-block max-w-2xl mx-auto">
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
      // </div>
    );
  },
  /* eslint-enable react/display-name */
};

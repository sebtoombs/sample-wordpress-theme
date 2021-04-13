const { useBlockProps, InnerBlocks, RichText } = wp.blockEditor;

const attributes = {
  title: {
    type: "string",
  },
};

export default {
  title: "FAQ Question",
  description: "FAQ Question/Answer",
  icon: "editor-ul",
  category: "widgets",
  keywords: [
    "FAQ",
    "Frequently Asked Questions",
    "Schema",
    "SEO",
    "Structured Data",
  ],
  parent: ["sample-wordpress/faq"],
  // Allow only one FAQ block per post.
  supports: {
    anchor: true,
    reusable: false,
    html: false,
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
      // <div className="schema-faq-section border-0 border-b border-solid border-gray-100 last:border-b-0 px-2 py-1 ">
      // {/* <span className="text-gray-500 font-bold text-sm">Question</span> */}
      // {/* <RichText
      // className="schema-faq-question"
      //   tagName="p"
      //   value={attributes.title}
      //   onChange={(value) => setAttributes({ title: value })}
      //   placeholder={"Enter a question"}
      //   allowedFormats={["italic", "strikethrough", "link"]}
      // /> */}
      // <span className="text-gray-500 font-bold text-sm">Answer</span>
      <div {...blockProps}>
        <InnerBlocks />
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
      // <div
      //   className={
      //     "schema-faq-section border-b border-solid border-gray-100 last:border-b-0 mb-2 last:mb-0 py-2"
      //   }
      //   x-data="dropdown()"
      // >
      //   <button
      //     className="flex items-center border-none bg-none w-full"
      //     x-spread="trigger"
      //   >
      //     {/* <RichText.Content
      //       tagName="strong"
      //       className="schema-faq-question flex-grow text-left"
      //       value={attributes.title}
      //     /> */}

      //     <span className="ml-auto">
      //       <svg
      //         width="32"
      //         height="32"
      //         viewBox="0 0 32 32"
      //         fill="none"
      //         xmlns="http://www.w3.org/2000/svg"
      //         x-spread="iconShow"
      //       >
      //         <path
      //           d="M25.3229 17.3327H17.3229V25.3327H14.6562V17.3327H6.65625V14.666H14.6562V6.66602H17.3229V14.666H25.3229V17.3327Z"
      //           fill="black"
      //         />
      //       </svg>
      //       <svg
      //         width="32"
      //         height="32"
      //         viewBox="0 0 32 32"
      //         fill="none"
      //         xmlns="http://www.w3.org/2000/svg"
      //         x-spread="iconHide"
      //         x-cloak
      //       >
      //         <path
      //           d="M25.3229 17.3346H6.65625V14.668H25.3229V17.3346Z"
      //           fill="black"
      //         />
      //       </svg>
      //     </span>
      //   </button>
      //   <div x-cloak x-spread="dialogue" className="schema-faq-answer">
      <div {...blockProps}>
        <InnerBlocks.content />
      </div>
      //   </div>
      // </div>
    );
  },
  /* eslint-enable react/display-name */
};

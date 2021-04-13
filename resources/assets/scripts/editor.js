// import FAQBlock from "./blocks/faq/faq";
// import FAQQuestion from "./blocks/faq/question";
const { useBlockProps, InnerBlocks, RichText } = wp.blockEditor;
const {
  ToggleControl,
  TextControl,
  __experimentalNumberControl: NumberControl,
} = wp.components;

wp = window.wp;

wp.domReady(() => {
  wp.blocks.registerBlockStyle("core/spacer", {
    name: "default",
    label: "Default",
    isDefault: true,
  });

  wp.blocks.registerBlockStyle("core/spacer", {
    name: "responsive-large",
    label: "Responsive Large",
  });

  wp.blocks.registerBlockStyle("core/spacer", {
    name: "responsive-medium",
    label: "Responsive Medium",
  });

  wp.blocks.registerBlockStyle("core/spacer", {
    name: "responsive-small",
    label: "Responsive Small",
  });

  wp.blocks.registerBlockType("sample-wordpress/price", {
    title: "Price",
    description: "Display pricing with formatting",
    attributes: {
      price: {
        type: "string",
      },
      showDollarSign: {
        type: "boolean",
      },
      perPeriod: {
        type: "string",
      },
    },
    edit({ attributes, setAttributes }) {
      return (
        <div className="border border-solid border-gray-100 p-2">
          <ToggleControl
            label="Show dollar sign"
            checked={attributes.showDollarSign}
            onChange={(showDollarSign) => setAttributes({ showDollarSign })}
          />
          <TextControl
            label="Price"
            // isShiftStepEnabled={true}
            onChange={(price) => setAttributes({ price })}
            // step={0.1}
            // shiftStep={10}
            value={attributes.price}
          />
          <TextControl
            label="Per period"
            value={attributes.perPeriod}
            onChange={(perPeriod) => setAttributes({ perPeriod })}
          />
        </div>
      );
    },
    save({ attributes }) {
      return (
        <div className="price">
          <div class="price__box">
            <div class="price__item">
              {attributes.showDollarSign && (
                <span className="price__symbol">$</span>
              )}
              {!!attributes.price && (
                <div class="price__price">
                  <span>{attributes.price}</span>
                </div>
              )}
              {!!attributes.perPeriod && (
                <div class="price__period">/{attributes.perPeriod}</div>
              )}
            </div>
          </div>
        </div>
      );
    },
  });

  // wp.blocks.registerBlockType("sample-wordpress/faq", FAQBlock);
  // wp.blocks.registerBlockType("sample-wordpress/faq-question", FAQQuestion);
  wp.blocks.registerBlockType("sample-wordpress/faq", {
    title: "FAQ List",
    description:
      "List your Frequently Asked Questions in an SEO-friendly way. You can only use one FAQ block per post.",
    icon: "editor-ul",
    category: "widgets",
    edit() {
      const blockProps = useBlockProps();

      return (
        <div className="border border-solid border-gray-100 px-2 py-1">
          <span className="text-gray-500 text-sm font-bold">FAQ List</span>
          <div {...blockProps}>
            <InnerBlocks allowedBlocks={["sample-wordpress/faq-question"]} />
          </div>
        </div>
      );
    },

    save() {
      const blockProps = useBlockProps.save();

      return (
        <div className="max-w-2xl mx-auto">
          <div {...blockProps}>
            <InnerBlocks.Content />
          </div>
        </div>
      );
    },
  });
  wp.blocks.registerBlockType("sample-wordpress/faq-question", {
    title: "FAQ Section",
    description: "FAQ Section.",
    icon: "editor-ul",
    category: "widgets",
    parent: ["sample-wordpress/faq"],
    attributes: {
      question: {
        type: "string",
      },
    },
    edit({ attributes, setAttributes }) {
      const blockProps = useBlockProps();

      return (
        <div className="schema-faq-section border-0 border-b border-solid border-gray-100 last:border-b-0 px-2 py-1 ">
          <span className="text-gray-500 font-bold text-sm">Question</span>
          <div>
            <RichText
              className="schema-faq-question"
              tagName="p"
              value={attributes.question}
              onChange={(value) => setAttributes({ question: value })}
              placeholder={"Enter a question"}
              allowedFormats={["italic", "strikethrough", "link"]}
            />
            <span className="text-gray-500 font-bold text-sm">Answer</span>
            <div {...blockProps}>
              <InnerBlocks />
            </div>
          </div>
        </div>
      );
    },

    save({ attributes }) {
      const blockProps = useBlockProps.save();

      return (
        <div
          className={
            "schema-faq-section border-b border-solid border-gray-100 last:border-b-0 mb-2 last:mb-0 py-2"
          }
          x-data="dropdown()"
        >
          <button
            className="flex items-center border-none bg-none w-full"
            x-spread="trigger"
          >
            <RichText.Content
              tagName="strong"
              className="schema-faq-question flex-grow text-left"
              value={attributes.question}
            />
            <span className="ml-auto">
              <svg
                width="32"
                height="32"
                viewBox="0 0 32 32"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                x-spread="iconShow"
              >
                <path
                  d="M25.3229 17.3327H17.3229V25.3327H14.6562V17.3327H6.65625V14.666H14.6562V6.66602H17.3229V14.666H25.3229V17.3327Z"
                  fill="black"
                />
              </svg>
              <svg
                width="32"
                height="32"
                viewBox="0 0 32 32"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                x-spread="iconHide"
                x-cloak
              >
                <path
                  d="M25.3229 17.3346H6.65625V14.668H25.3229V17.3346Z"
                  fill="black"
                />
              </svg>
            </span>
          </button>
          <div x-cloak x-spread="dialogue" className="schema-faq-answer">
            <div {...blockProps}>
              <InnerBlocks.Content />
            </div>
          </div>
        </div>
      );
    },
  });
});

const plugin = require("tailwindcss/plugin");

const containerPadding = "1rem";

const colors = {
  //Add your theme here
  // EG
  orange: {
    50: "#FFF5EF",
    100: "#FFEADF",
    200: "#FFC6B3",
    300: "#F9A285",
    400: "#F57D56",
    500: "#F15A29",
    600: "#D73F0E",
    700: "#A9300A",
    800: "#792206",
    900: "#4B1201",
  },
  teal: {
    50: "#E6FFFA",
    100: "#B2F5EA",
    200: "#81E6D9",
    300: "#4FD1C5",
    400: "#38B2AC",
    500: "#319795",
    600: "#2C7A7B",
    700: "#285E61",
    800: "#234E52",
    900: "#1D4044",
    1000: "#1E2F2C",
  },
};

module.exports = {
  // purge: ["./src/**/*.html", "./src/**/*.js"],
  theme: {
    fontFamily: {
      sans: [
        "Varta",
        "system-ui",
        "-apple-system",
        "Segoe UI",
        "Roboto",
        "Helvetica",
        "Arial",
        "sans-serif",
        "Apple Color Emoji",
        "Segoe UI Emoji",
      ],
      body: [
        "Varta",
        "system-ui",
        "-apple-system",
        "Segoe UI",
        "Roboto",
        "Helvetica",
        "Arial",
        "sans-serif",
        "Apple Color Emoji",
        "Segoe UI Emoji",
      ],
    },
    container: {
      center: true,
      padding: containerPadding,
    },
    extend: {
      colors,
    },
  },
  variants: {
    margin: ["responsive", "last"],
  },
  plugins: [
    plugin(({ addUtilities, theme }) => {
      const breakpoints = theme("screens", {});

      const containerMargins = {
        ".ml-container": {
          ...Object.keys(breakpoints).reduce((obj, key) => {
            obj[`@screen ${key}`] = {
              marginLeft: `calc(((100vw - ${breakpoints[key]}) / 2) + ${containerPadding})`,
            };
            return obj;
          }, {}),
        },
        ".mr-container": {
          ...Object.keys(breakpoints).reduce((obj, key) => {
            obj[`@screen ${key}`] = {
              marginRight: `calc(((100vw - ${breakpoints[key]}) / 2) + ${containerPadding})`,
            };
            return obj;
          }, {}),
        },
      };

      addUtilities(containerMargins, {
        variants: ["responsive"],
      });
    }),
    plugin(({ addUtilities, theme }) => {
      const adminBar = {
        ".top-admin": {
          top: "32px",
        },
      };

      addUtilities(adminBar, {
        variants: ["adminbar", "responsive"],
      });
    }),
    plugin(({ addVariant, e }) => {
      addVariant("adminbar", ({ modifySelectors, separator }) => {
        modifySelectors(({ className }) => {
          return `body.admin-bar .${e(`admin-bar${separator}${className}`)}`;
        });
      });
    }),
    plugin(function ({ addComponents, addUtilities, theme }) {
      const stack = {
        ".stack": {
          display: "flex",
          flexDirection: "column",
          "&>*:first-child": {
            marginTop: 0,
          },
          "&>*:last-child": {
            marginBottom: 0,
          },
        },
        ".is-inline": {
          flexDirection: "row",
          "&>*:first-child": {
            marginLeft: 0,
          },
          "&>*:last-child": {
            marginRight: 0,
          },
        },
      };

      addComponents(stack, {
        variants: ["responsive"],
      });
    }),
  ],
};

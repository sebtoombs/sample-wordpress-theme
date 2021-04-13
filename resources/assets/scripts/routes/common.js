import "@ryangjchandler/spruce";
import "alpinejs";
import focusLock from "dom-focus-lock";

window.focusLock = focusLock;

window.Spruce.store("dropdown", {
  open: null,
  toggle: function (itemID, $event) {
    $event.preventDefault();
    if (this.open !== itemID) {
      this.open = itemID;
    } else {
      this.open = null;
    }
  },
  keydownParent: function (itemID, $event, $el) {
    if ($event.key === "Escape" && this.open) {
      const dropdown = $el.querySelector(".dropdown-menu");
      this.open = null;
      focusLock.off(dropdown);
      setTimeout(() => {
        $el.querySelector("a").focus();
      });
    }
    if (($event.key === "Down" || $event.key === "ArrowDown") && !this.open) {
      $event.preventDefault();
      this.open = itemID;
      const dropdown = $el.querySelector(".dropdown-menu");
      var focusable = dropdown.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
      );
      setTimeout(() => {
        Array.from(focusable)[0].focus();
        focusLock.on(dropdown);
      });
    }
    if (
      this.open &&
      ($event.key === "ArrowUp" ||
        $event.key === "ArrowDown" ||
        $event.key === "Down" ||
        $event.key === "Up")
    ) {
      $event.preventDefault();
      const dir =
        $event.key === "ArrowUp" || $event.key === "Up" ? "up" : "down";

      const dropdown = $el.querySelector(".dropdown-menu");
      var focusable = dropdown.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
      );
      let foundActive = false;
      const active = (dir === "up"
        ? Array.from(focusable).reverse()
        : Array.from(focusable)
      ).filter((el) => {
        if (el === document.activeElement) {
          foundActive = true;
          return false;
        }
        return foundActive;
      });
      if (active.length) {
        active.slice(0, 1)[0].focus();
      } else if (dir === "up") {
        this.open = null;
        setTimeout(() => {
          $el.querySelector("a").focus();
        }, 100);
      }
    }
  },
});

window.Spruce.watch("dropdown.open", (value) => console.log("open", value));

window.Spruce.store("navigation", {
  open: false,
  triggerEl: null,
});

window.Spruce.watch("navigation.open", (value) => {
  const store = window.Spruce.store("navigation");
  const el = document.querySelector("#mobile-navigation");
  if (value) {
    focusLock.on(el);
  } else {
    focusLock.off(el);
    if (store.triggerEl) {
      store.triggerEl.focus();
      setTimeout(() => {
        store.triggerEl = null;
      });
    }
  }
});

window.dropdown = function dropdown() {
  return {
    open: false,
    trigger: {
      ["@click"]() {
        this.open = !this.open;
      },
    },
    dialogue: {
      ["x-show"]() {
        return this.open;
      },
    },
    iconShow: {
      ["x-show"]() {
        return !this.open;
      },
    },
    iconHide: {
      ["x-show"]() {
        return this.open;
      },
    },
  };
};

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};

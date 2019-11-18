import { post } from "axios";

export default {
  state: {
    yoast: {
      settings: window.frontity.plugins.yoast.settings
    },
    theme: {
      colors: {
        brandBlue: "#2038c5",
        brandNavy: "#0c112b",
        slate: "#e1e1e5",
        lightSlate: "#f6f9fa",
        emeral: "#7dd72d",
        red: "#ea5a35"
      }
    }
  },
  actions: {
    yoast: {
      save: async ({ state }) => {
        console.log("saving");
        const data = new window.FormData();
        data.append("action", "frontity_save_frontity_yoast_settings");
        data.append("data", JSON.stringify(state.yoast.settings));
        const res = await post(window.ajaxurl, data);
        console.log("saved");
        console.log(res);
      },
      enable: ({ state, actions }) => {
        state.yoast.settings.isEnabled = true;
        actions.yoast.save();
      },
      disable: ({ state, actions }) => {
        state.yoast.settings.isEnabled = false;
        actions.yoast.save();
      }
    }
  }
};

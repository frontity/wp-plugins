import { post } from "axios";

export default {
  state: {
    headtags: {
      settings: window.frontity.plugins.headtags.settings
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
    headtags: {
      save: async ({ state }) => {
        console.log("saving");
        const data = new window.FormData();
        data.append("action", "frontity_save_frontity_headtags_settings");
        data.append("data", JSON.stringify(state.headtags.settings));
        const res = await post(window.ajaxurl, data);
        console.log("saved");
        console.log(res);
      },
      enable: ({ state, actions }) => {
        state.headtags.settings.isEnabled = true;
        actions.headtags.save();
      },
      disable: ({ state, actions }) => {
        state.headtags.settings.isEnabled = false;
        actions.headtags.save();
      }
    }
  }
};

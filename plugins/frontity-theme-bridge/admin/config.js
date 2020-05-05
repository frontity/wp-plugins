import { post } from "axios";

export default {
  state: {
    themeBridge: {
      settings: window.frontity.plugins.themeBridge.settings,
    },
  },
  actions: {
    themeBridge: {
      save: async ({ state }) => {
        console.log("saving");
        const data = new window.FormData();
        data.append("action", "frontity_save_frontity_theme_bridge_settings");
        data.append("data", JSON.stringify(state.themeBridge.settings));
        const res = await post(window.ajaxurl, data);
        console.log("saved");
        console.log(res);
      },
      setValue: ({ state, actions }) => {
        state.themeBridge.settings.value = Math.random();
        actions.themeBridge.save();
      },
    },
  },
};

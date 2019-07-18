import { createStore } from "@frontity/connect";
import { post } from "axios";

const store = createStore({
  state: {
    pluginOne: {
      settings: window.frontity.plugins.pluginOne.settings
    }
  },
  actions: {
    pluginOne: {
      save: async ({ state }) => {
        console.log("saving");
        const data = new window.FormData();
        data.append("action", "frontity_save_plugin_one_settings");
        data.append("data", JSON.stringify(state.pluginOne.settings));
        const res = await post(window.ajaxurl, data);
        console.log("saved");
        console.log(res);
      },
      setValue: ({ state, actions }) => {
        state.pluginOne.settings.value = Math.random();
        actions.pluginOne.save();
      }
    }
  }
});

window.frontity.state = store.state;
window.frontity.actions = store.actions;

export default store;

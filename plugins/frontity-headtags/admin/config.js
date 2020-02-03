import { post } from "axios";

export default {
  state: {
    headtags: {
      settings: window.frontity.plugins.headtags.settings,
      cacheModal: {
        isWaitingConfirmation: false,
        isConfirmed: false
      }
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
        const data = new window.FormData();
        data.append("action", "frontity_save_frontity_headtags_settings");
        data.append("data", JSON.stringify(state.headtags.settings));
        await post(window.ajaxurl, data);
      },
      enable: ({ state, actions }) => {
        state.headtags.settings.isEnabled = true;
        actions.headtags.save();
      },
      disable: ({ state, actions }) => {
        state.headtags.settings.isEnabled = false;
        actions.headtags.save();
      },
      clearCache: async ({ state }) => {
        const data = new window.FormData();
        data.append("action", "frontity_headtags_clear_cache");
        data.append("data", JSON.stringify({}));
        await post(window.ajaxurl, data);
        const { cacheModal } = state.headtags;
        cacheModal.isWaitingConfirmation = false;
        cacheModal.isConfirmed = true;
      },
      openCacheModal: ({ state }) => {
        state.headtags.cacheModal.isWaitingConfirmation = true;
      },
      closeCacheModal: ({ state }) => {
        const { cacheModal } = state.headtags;
        cacheModal.isWaitingConfirmation = false;
        cacheModal.isConfirmed = false;
      }
    }
  }
};

import pluginOne from "../../frontity-plugin-one/admin/config";
import headtags from "../../frontity-headtags/admin/config";

// List of store configs from each plugin
const pluginConfigs = [pluginOne, headtags];

// Generate the main store config using the list above
export default pluginConfigs.reduce(
  (config, { state, actions }) => {
    return {
      state: { ...config.state, ...state },
      actions: { ...config.actions, ...actions }
    };
  },
  { state: {}, actions: {} }
);

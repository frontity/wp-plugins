import pluginOne from "../../plugin-one/admin/config";
import yoast from "../../yoast-meta/admin/config";

// List of store configs from each plugin
const pluginConfigs = [pluginOne, yoast];

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

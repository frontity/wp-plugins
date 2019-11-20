import React from "react";
import Card from "./card";
import Toggle from "./toggle";

const Settings = () => {
  const [checked, setChecked] = React.useState(false);
  const toggleChecked = () => setChecked(!checked);

  return (
    <Card margin="56px 0">
      <h2>Setting option here?</h2>
      <p>Activate this option to...</p>
      <Toggle checked={checked} onClick={toggleChecked} />
    </Card>
  );
};

export default Settings;

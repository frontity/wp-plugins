import React from "react";
import Dropdown from "./dropdown";

const Info = () => {
  return (
    <Dropdown margin="56px 0" title="How to use REST API - Head Tags">
      <h4>If you are using Frontity</h4>
      <p>
        The only thing you have to do is install the{" "}
        <a href="" target="_blank">
          <code>@frontity/head-tags</code>
        </a>{" "}
        package into your Frontity project.
      </p>
      <br />
      <h4>If you are using other JS framework</h4>
      <p>
        The plugin adds a new field to entities fetched from the REST API,
        called <code>head_tags</code>. This field is an array of objects with
        the properties <code>tag</code>, <code>attributes</code> and{" "}
        <code>content</code>.
      </p>
      <p>
        At vero eos et accusamus et iusto odio dignissimos ducimus qui
        blanditiis praesentium voluptatum deleniti atque corrupti quos dolores
        et quas molestias excepturi sint occaecati cupiditate non provident,
        similique sunt in culpa qui officia deserunt mollitia animi, id est
        laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita
        distinctio. Nam libero tempore, cum soluta nobis est eligendi optio
        cumque nihil impedit quo minus id quod maxime placeat facere possimus,
        omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem
        quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet
        ut et voluptates repudiandae sint et molestiae non recusandae. Itaque
        earum rerum hic tenetur a sapiente delectus, ut aut reiciendis
        voluptatibus maiores alias consequatur aut perferendis doloribus
        asperiores repellat.
      </p>
    </Dropdown>
  );
};

export default Info;

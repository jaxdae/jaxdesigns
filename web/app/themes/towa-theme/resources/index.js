import "./main.scss";
import * as components from "./components";
import "./polyfills";

document.addEventListener("DOMContentLoaded", () => {
  const componentNodes = document.querySelectorAll("[data-component]") || [];
  componentNodes.forEach(node => {
    const componentName = node.getAttribute("data-component");
    let props = node.getAttribute("data-props");
    if (props) props = JSON.parse(props);

    /* eslint-disable no-new */
    new components[componentName](node, props);
  });
});

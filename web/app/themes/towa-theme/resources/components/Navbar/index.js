import $ from "jquery";

export default class Navbar {
  constructor(rootNode, props) {
    this.$rootNode = rootNode;
    this.props = JSON.parse(props);

    this.refs = {
      rootNode,
      shareBtn: rootNode.querySelector(".Navbar__share")
    };

    this.setupListeners();
  }

  setupListeners() {
    this.refs.shareBtn.addEventListener("click", () => {
      console.log("share");
    });
  }
}

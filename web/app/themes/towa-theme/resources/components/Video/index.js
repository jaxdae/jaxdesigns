import $ from "jquery";

export default class Video {
  constructor(rootNode) {
    this.state = {
      isPlaying: false
    };
    this.refs = {
      rootNode,
      overlay: rootNode.querySelector(".Video__overlay"),
      picture: rootNode.querySelector(".Video__picture"),
      video: rootNode.querySelector(".Video__item")
    };

    this.setupListeners();
  }

  setupListeners() {
    this.onPlayIconClick = this.onPlayIconClick.bind(this);
    if (this.refs.rootNode) {
      this.refs.rootNode.addEventListener("click", this.onPlayIconClick);
    }
  }

  onPlayIconClick() {
    this.setState({ isPlaying: true });
  }

  setState(newState) {
    const prevState = this.state;
    this.state = Object.assign({}, this.state, newState);
    this.render(prevState);
  }

  render() {
    if (this.state.isPlaying) {
      this.refs.overlay.classList.add("Video__overlay--hidden");
      this.refs.picture.classList.add("Video__picture--hidden");
      $(this.refs.video)[0].src += "&autoplay=1";
    }
  }
}

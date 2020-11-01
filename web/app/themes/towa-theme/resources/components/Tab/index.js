export default class Tab {
  constructor(rootNode) {
    this.state = {
      activeIndex: 0
    };
    this.refs = {
      rootNode,
      tabs: [...rootNode.querySelector(".Tab__items").children],
      content: [...rootNode.querySelector(".Tab__wrapper").children]
    };

    this.setupListeners();
    this.render();
  }

  setupListeners() {
    this.refs.tabs.forEach((item, i) => {
      item.addEventListener("click", () => {
        this.onTabClick(i);
      });
    });
  }

  onTabClick(activeIndex) {
    this.setState({ activeIndex });
  }

  setState(newState) {
    const prevState = this.state;
    this.state = Object.assign({}, this.state, newState);
    this.render(prevState);
  }

  render() {
    this.refs.tabs.forEach((item, i) => {
      if (this.state.activeIndex === i) {
        item.classList.add("Tab__item--active");
      } else {
        item.classList.remove("Tab__item--active");
      }
    });

    this.refs.content.forEach((item, i) => {
      if (this.state.activeIndex === i) {
        item.classList.add("Tab__content--active");
      } else {
        item.classList.remove("Tab__content--active");
      }
    });
  }
}

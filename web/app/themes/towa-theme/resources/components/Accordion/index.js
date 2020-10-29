export default class Accordion {
  constructor(rootNode) {
    this.state = {
      clickedIndex: 0,
    };

    this.refs = {
      rootNode,
      items: [...rootNode.querySelector('.Accordion__items').children],
    };

    this.setupListeners();
  }

  setupListeners() {
    this.refs.items.forEach((item, i) => {
      item.addEventListener('click', () => {
        this.onItemClick(i);
      });
    });
  }

  onItemClick(clickedIndex) {
    this.setState({
      clickedIndex,
    });
  }

  setState(newState) {
    this.state = Object.assign({}, this.state, newState);
    this.render();
  }

  render() {
    this.refs.items.forEach((item, i) => {
      if (this.state.clickedIndex === i && item.classList.contains('Accordion__item--open')) {
        item.classList.remove('Accordion__item--open');
      } else if (this.state.clickedIndex === i) {
        item.classList.add('Accordion__item--open');
      }
    });
  }
}

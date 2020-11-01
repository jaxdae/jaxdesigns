import $ from "jquery";

export default class Navbar {
    constructor(rootNode, props) {
        this.$rootNode = rootNode;
        this.props = JSON.parse(props);
        this.state = {
            isLarge: false,
            image: null,
        }
        this.refs = {
            rootNode,
            left: rootNode.querySelector(".PostImages__overlay-1"),
            leftImg: document.getElementsByClassName('PostImages__fullscreen-image-1')[0],
            rightImg: document.getElementsByClassName('PostImages__fullscreen-image-2')[0],
            right: rootNode.querySelector(".PostImages__overlay-2"),
            container: document.getElementsByClassName('PostImages__fullscreen')[0],
            close: document.getElementsByClassName('PostImages__fullscreen-wrapper')[0],
            body: document.getElementsByTagName('body')[0],
        };

        this.setupListeners();
    }

    setupListeners() {
        this.refs.left.addEventListener("click", () => {
            this.setState({ isLarge: true });
            this.setState({ image: 'left' });
        });
        this.refs.right.addEventListener("click", () => {
            this.setState({ isLarge: true });
            this.setState({ image: 'right' });
        });
        this.refs.close.addEventListener("click", () => {
            this.setState({ isLarge: false });
        })
    }

    setState(newState) {
        const prevState = this.state;
        this.state = Object.assign({}, this.state, newState);
        this.render(prevState);
    }

    render() {
        if (this.state.isLarge && this.state.image === "left") {
            this.refs.container.style.opacity = "1";
            this.refs.container.style.pointerEvents = "all";
            this.refs.rightImg.style.display = "none";
            this.refs.leftImg.style.display = "block";
            this.refs.body.style.overflowY = "hidden";

        } else if (this.state.isLarge && this.state.image === "right") {
            this.refs.container.style.opacity = "1";
            this.refs.container.style.pointerEvents = "all";
            this.refs.leftImg.style.display = "none";
            this.refs.rightImg.style.display = "block";
            this.refs.body.style.overflowY = "hidden";
        }
        else {
            this.refs.container.style.opacity = "0";
            this.refs.container.style.pointerEvents = 'none';
            this.refs.body.style.overflowY = "visible";
        }
    }
}

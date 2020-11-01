import $ from "jquery";
import { wrapGrid } from "animate-css-grid";

export default class PostGrid {
  constructor(rootNode, props) {
    this.$rootNode = rootNode;
    this.props = JSON.parse(props);
    this.data = {
      activeElem: "All"
    };
    this.state = {
      dropdownOpen: false
    };
    this.refs = {
      rootNode,
      filters: [...rootNode.querySelector(".PostGrid__filterwrapper").children],
      mobileMenu: rootNode.querySelector(".PostGrid__filterwrapper"),
      loadMore: rootNode.querySelector(".PostGrid__load-more"),
      onWrapper: rootNode.querySelector(".PostGrid__on"),
      allItems: [...rootNode.querySelector(".PostGrid__on").children],
      dropdownArrow: rootNode.querySelector(".PostGrid__filterarrow")
    };
    this.setupListeners();
    this.showDefault();

    wrapGrid(this.refs.onWrapper, {
      duration: 800,
      easing: "anticipate"
    });
  }

  setupListeners() {
    this.refs.filters[0].addEventListener("click", e => {
      this.onFilterClick(e, this.refs.filters[0].innerText);
    });
    this.refs.filters[1].addEventListener("click", e => {
      this.onFilterClick(e, this.refs.filters[1].innerText);
    });
    this.refs.filters[2].addEventListener("click", e => {
      this.onFilterClick(e, this.refs.filters[2].innerText);
    });
    this.refs.filters[3].addEventListener("click", e => {
      this.onFilterClick(e, this.refs.filters[3].innerText);
    });
    this.refs.filters[4].addEventListener("click", e => {
      this.onFilterClick(e, this.refs.filters[4].innerText);
    });
    this.refs.filters[5].addEventListener("click", e => {
      this.onFilterClick(e, this.refs.filters[5].innerText);
    });
    this.refs.mobileMenu.addEventListener("click", () => {
      this.openDropdown();
    });
    this.refs.loadMore.addEventListener("click", () => {
      this.loadNext();
    });
    this.refs.dropdownArrow.addEventListener("click", () => {
      this.closeDropdown();
    });
  }

  closeDropdown() {
    for (let i = 0; i < this.refs.filters.length; i++) {
      this.refs.filters[i].removeAttribute("style");
      this.refs.mobileMenu.removeAttribute("style");
    }
  }

  showDefault() {
    for (let i = 0; i < this.refs.allItems.length; i++) {
      if (i >= 12) {
        this.refs.allItems[i].classList.add("PostGrid__hidden");
      }
    }
  }

  capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  loadNext() {
    const relevantItems = [];
    let newData = this.data.activeElem.toLowerCase();
    newData = this.capitalizeFirstLetter(newData);
    for (let i = 0; i < this.refs.allItems.length; i++) {
      if (
        this.refs.allItems[i].classList.contains(newData) &&
        this.refs.allItems[i].classList.contains("PostGrid__hidden")
      ) {
        relevantItems.push(this.refs.allItems[i]);
      } else if (
        newData === "All" &&
        this.refs.allItems[i].classList.contains("PostGrid__hidden")
      ) {
        relevantItems.push(this.refs.allItems[i]);
      }
    }
    if (relevantItems.length > 0) {
      if (relevantItems.length < 12) {
        this.refs.loadMore.style.display = "none";
      }
      for (let i = 0; i < relevantItems.length; i++) {
        if (i < 12) {
          relevantItems[i].classList.remove("PostGrid__hidden");
        }
      }
    }
  }

  openDropdown() {
    if (this.state.dropdownOpen === false) {
      for (let i = 0; i < this.refs.filters.length; i++) {
        this.refs.filters[i].style.display = "block";
      }
      if (window.innerWidth <= 1024) {
        this.refs.mobileMenu.style.padding = "15px 20px";
        $(".PostGrid__filterarrow")[0].style.margin = "10px 5px";
        $(".PostGrid__filterarrow")[0].style.transform = "rotate(180deg)";
      }
      this.state.dropdownOpen = true;
    } else {
      this.state.dropdownOpen = false;
    }
  }

  onFilterClick(e, whichFilter) {
    $(".PostGrid__load-more")[0].style.display = "flex";
    this.data.activeElem = e.target.innerText;

    // Set filters right, and highlight active filter
    for (let i = 0; i < this.refs.filters.length; i++) {
      this.refs.filters[i].removeAttribute("style");
      this.refs.mobileMenu.removeAttribute("style");
    }

    for (let i = 0; i < this.refs.filters.length; i++) {
      if (this.refs.filters[i].classList.contains("PostGrid__active")) {
        this.refs.filters[i].classList.remove("PostGrid__active");
      }
      e.target.classList.add("PostGrid__active");
    }

    // remove all filtering before filtering again
    for (let i = 0; i < this.refs.allItems.length; i++) {
      this.refs.allItems[i].classList.remove("PostGrid__hidden");
    }

    // hide items
    if (whichFilter != "All" && whichFilter != "ALL") {
      const itemsToShow = [];
      for (let i = 0; i < this.refs.allItems.length; i++) {
        if (
          this.refs.allItems[i].children[0].children[2].innerText !=
          whichFilter.toUpperCase()
        ) {
          this.refs.allItems[i].classList.add("PostGrid__hidden");
        } else {
          itemsToShow.push(this.refs.allItems[i]);
        }
      }
      if (itemsToShow.length <= 12) {
        $(".PostGrid__load-more")[0].style.display = "none";
      }
      for (let i = 0; i < itemsToShow.length; i++) {
        if (i >= 12) {
          itemsToShow[i].classList.add("PostGrid__hidden");
        }
      }
    } else {
      for (let i = 0; i < $(".PostGrid__on")[0].children.length; i++) {
        if (i >= 12) {
          $(".PostGrid__on")[0].children[i].classList.add("PostGrid__hidden");
        }
      }
    }
  }
}

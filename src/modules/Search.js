import axios from "axios"

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML()
    this.resultsDiv = document.querySelector("#search-overlay__results")
    this.openButton = document.querySelectorAll(".js-search-trigger")
    this.closeButton = document.querySelector(".search-overlay__close")
    this.searchOverlay = document.querySelector(".search-overlay")
    this.searchField = document.querySelector("#search-term")
    this.isOverlayOpen = false
    this.isSpinnerVisible = false
    this.previousValue
    this.typingTimer
    this.events()
  }

  // 2. events
  events() {
    this.openButton.forEach(el => {
      el.addEventListener("click", e => {
        e.preventDefault()
        this.openOverlay()
      })
    })

    this.closeButton.addEventListener("click", () => this.closeOverlay())
    document.addEventListener("keydown", e => this.keyPressDispatcher(e))
    this.searchField.addEventListener("keyup", () => this.typingLogic())
  }

  // 3. methods (function, action...)
  typingLogic() {
    if (this.searchField.value != this.previousValue) {
      clearTimeout(this.typingTimer)

      if (this.searchField.value) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>'
          this.isSpinnerVisible = true
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750)
      } else {
        this.resultsDiv.innerHTML = ""
        this.isSpinnerVisible = false
      }
    }

    this.previousValue = this.searchField.value
  }

  async getResults() {
    try {
      const response = await axios.get(dcData.root_url + "/wp-json/dc/v1/search?term=" + this.searchField.value)
      const results = response.data
      this.resultsDiv.innerHTML = `
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${results.genInfo.length ? '<ul class="link-list min-list">' : "<p>No general information matches that search.</p>"}
              ${results.genInfo.map(item => `<li><a href="${item.url}">${item.title}</a> ${item.postType == "post" ? `by ${item.author}` : ""}</li>`).join("")}
            ${results.genInfo.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Companies</h2>
            ${results.companies.length ? '<ul class="link-list min-list">' : `<p>No results found <a href="${dcData.root_url}/companies">View all Companies</a></p>`}
              ${results.companies.map(item => `<li><a href="${item.url}">${item.title}</a></li>`).join("")}
            ${results.companies.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Portfolios</h2>
            ${results.ports.length ? '<ul class="professor-cards">' : `<p>No results found </p>`}
              ${results.ports
          .map(
            item => `
                <li class="professor-card__list-item">
                  <a class="professor-card" href="${item.url}">
                    <img class="professor-card__image" src="${item.image}">
                    <span class="professor-card__name">${item.title}</span>
                  </a>
                </li>
              `
          )
          .join("")}
          </div>
            ${results.ports.length ? "</ul>" : ""}
          <div class="one-third">
            <h2 class="search-overlay__section-title">Events</h2>
            ${results.events.length ? "" : `<p>No events match that search. <a href="${dcData.root_url}/events">View all events</a></p>`}
              ${results.events
          .map(
            item => `
            
                <div class="event-summary">
                  <a class="event-summary__date t-center" href="${item.url}">
                    <span class="event-summary__month">${item.month}</span>
                    <span class="event-summary__day">${item.day}</span>  
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="${item.url}">${item.title}</a></h5>
                    <p>${item.description} <a href="${item.url}" class="nu gray">Learn more</a></p>
                    </div>
                </div>
              `
          )
          .join("")}
        </div>
      `
      this.isSpinnerVisible = false
    } catch (e) {
      console.log(e)
    }
  }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen && document.activeElement.tagName != "INPUT" && document.activeElement.tagName != "TEXTAREA") {
      this.openOverlay()
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay()
    }
  }

  openOverlay() {
    this.searchOverlay.classList.add("search-overlay--active")
    document.body.classList.add("body-no-scroll")
    this.searchField.value = ""
    setTimeout(() => this.searchField.focus(), 301)
    console.log("our open method just ran!")
    this.isOverlayOpen = true
    return false
  }

  closeOverlay() {
    this.searchOverlay.classList.remove("search-overlay--active")
    document.body.classList.remove("body-no-scroll")
    console.log("our close method just ran!")
    this.isOverlayOpen = false
  }

  addSearchHTML() {
    document.body.insertAdjacentHTML(
      "beforeend",
      `
      <div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="Search DC" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>
        
        <div class="container">
          <div id="search-overlay__results"></div>
        </div>

      </div>
    `
    )
  }
}

export default Search

import axios from "axios";

class GetAllJobs {
  constructor(payload) {
    this.DOM = {
      element: payload.element,
      resultsContainer: payload.resultsContainer,
      filterLocation: payload.filterLocation,
      filterPracticeAreas: payload.filterPracticeAreas,
      loader: payload.loader
    };

    this.resultList = [];
    this.jobs = [];
    this.eventHandlers = [];

    this.init();
    this.events();
  }

  init() {
    if (this.DOM.element) {
      this.getFilters();
      this.getContent();
    }
  }

  events() {
    if (this.DOM.filterPracticeAreas) {
      const handlePracticeAreaChange = () => {
        this.DOM.resultsContainer.innerHTML = "";
        this.DOM.loader.style.display = 'block';
        this.getContent();
      };

      this.DOM.filterPracticeAreas.addEventListener("change", handlePracticeAreaChange);
      this.eventHandlers.push({
        element: this.DOM.filterPracticeAreas,
        event: "change",
        handler: handlePracticeAreaChange
      });
    }

    if (this.DOM.filterLocation) {
      const handleLocationChange = () => {
        this.DOM.resultsContainer.innerHTML = "";
        this.DOM.loader.style.display = 'block';
        this.getContent();
      };

      this.DOM.filterLocation.addEventListener("change", handleLocationChange);
      this.eventHandlers.push({
        element: this.DOM.filterLocation,
        event: "change",
        handler: handleLocationChange
      });
    }
  }

  async getContent() {
    try {
      const selectedArea = this.DOM.filterPracticeAreas.value !== '' ? this.DOM.filterPracticeAreas.value : '';
      const selectedLoc = this.DOM.filterLocation.value !== '' ? this.DOM.filterLocation.value : '';

      const data = {
        action: "get_greenhouse_jobs",
        location: selectedLoc,
        department: selectedArea,
        category: "",
      };

      const response = await axios.get(base_wp_api.ajax_url, { params: data });

      this.resultList = response.data.jobs;

      this.resultList.forEach((job) => {
        const jUrl = `${base_wp_api.root_url}/careers/open-positions/job-position-detail/`;
        job.url = jUrl + "?gh_jid=" + job.id;
      });


      this.generateJobElements(selectedArea, selectedLoc);
    } catch (error) {
      console.error("Error fetching jobs", error);
    }
  }

  async getFilters() {
    try {
      const data = {
        action: "get_greenhouse_jobs",
        location: "",
        department: "",
        category: "",
      };

      const response = await axios.get(base_wp_api.ajax_url, { params: data });
      this.areasList = response.data.deps;
      this.locList = response.data.locs;

      this.generateFilterLocs();
      this.generateFilterPA();
    } catch (error) {
      console.error("Error fetching filters", error);
    }
  }

  generateJobElements(selectedArea, selectedLoc) {
    const jobsContainer = this.DOM.resultsContainer;
    
    if (this.resultList.length > 0) {
      this.resultList.forEach((job) => {
        const cityName = job.location["name"].split(",")[0].trim();
        const jobHtml = `
          <div class="f--col-12">
            <a target="_blank" class="c--card-f" href="${job.url}">
              <div class="c--card-f__wrapper">
                <span class="c--card-f__wrapper__subtitle">${cityName}</span>
                <h3 class="c--card-f__wrapper__title">${job.title}</h3>
              </div>
              <div class="c--card-f__artwork">
                  <svg class="c--card-f__artwork__item" width="28" height="27" viewBox="0 0 28 27" fill="none">
                      <rect x="1" y="0.5" width="26" height="26" rx="13" fill="#F01840"/>
                      <rect x="1" y="0.5" width="26" height="26" rx="13" stroke="#F01840"/>
                      <path d="M7.52002 13.5H20.48" stroke="#FFFFF8" stroke-width="2" stroke-linecap="round"/>
                      <path d="M14 7.02002V19.98" stroke="#FFFFF8" stroke-width="2" stroke-linecap="round"/>
                  </svg>
              </div>
            </a>
          </div>
        `;
        const jobElement = document.createElement("div");
        jobElement.innerHTML = jobHtml.trim();
        jobsContainer.appendChild(jobElement.firstChild);
        this.DOM.loader.style.display = 'none';
        this.DOM.filterPracticeAreas.value = selectedArea;
        this.DOM.filterLocation.value = selectedLoc;
      });
    } else {
      jobsContainer.innerHTML = `
        <p>We have no open positions at this time. Please check back later or view our other open roles.</p>
      `;
    }
  }

  generateFilterPA() {
    this.DOM.filterPracticeAreas.innerHTML = '<option value="">All Practice Areas</option>';
    this.areasList.forEach((area) => {
      const option = document.createElement("option");
      option.id = area["id"];
      option.value = area["title"];
      option.text = area["depName"];
      this.DOM.filterPracticeAreas.appendChild(option);
    });
  }

  generateFilterLocs() {
    this.DOM.filterLocation.innerHTML = '<option value="">All Locations</option>';
    this.locList.forEach((loc) => {
      const option = document.createElement("option");
      option.id = loc["locName"];
      option.value = loc["location"];
      option.text = loc["locName"];
      this.DOM.filterLocation.appendChild(option);
    });
  }

  destroy() {
    this.eventHandlers.forEach(({ element, event, handler }) => {
      element.removeEventListener(event, handler);
    });
    this.eventHandlers = [];
    this.DOM.resultsContainer.innerHTML = "";
  }
}

export default GetAllJobs;

import axios from "axios";

class LocationJobs {
  constructor(payload) {
    this.DOM = {
      element: payload.element,
      locationId: payload.job_id,
    };
    this.resultList = []; 
    this.jobs = []; 

    if (this.DOM.element && this.DOM.locationId) {
      this.getContent()
        .then(() => { this.generateJobElements(); })
        .catch((error) => console.error(error));
    }
  }

  async getContent() {
    try {
      const data = {
        action: "get_greenhouse_jobs",
        location: this.DOM.locationId,
      };

      //* goes to functions/project/custom/api/GRT/get-jobs.php
      const response = await axios.get(base_wp_api.ajax_url, {
        params: data,
      });

      //* we set the resultList to use in generateJobElements;
      this.resultList = response.data.single_loc;

      //? we will use this in the future for single pages, pls keep
      this.resultList.forEach(job => {
        var jUrl = `${base_wp_api.root_url}/careers/open-positions/job-position-detail/`;
        job.url = jUrl + "?gh_jid=" + job.id;
      });

    } catch (error) {
      console.error("Error fetching jobs", error);
    }
  }

  generateJobElements() {
    const jobsContainer = this.DOM.element;
    jobsContainer.innerHTML = '';
    if (this.resultList.length > 0) {
      this.resultList.forEach(job => {
        const cityName = job.location['name'].split(',')[0].trim();
        const jobHtml = `
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
        `;
        const jobElement = document.createElement('div');
        jobElement.innerHTML = jobHtml.trim(); 
        jobsContainer.appendChild(jobElement.firstChild); 
      });
    } else {
      jobsContainer.innerHTML = `
        <p>We have no open positions at this time. Please check back later or view our other open roles.</p>
      `;
    }
  }

  destroy(){
    const jobsContainer = this.DOM.element;
    jobsContainer.innerHTML = '';
  }
}

export default LocationJobs;

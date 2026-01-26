import axios from "axios"; // used to make http requests
import { GET_THEME_OPTIONS } from "./../services/GET/index.js";

class SetCookies {
  constructor(payload) {
    this.cookieDiv = payload.cookieContainer;
    this.events();
  }

  events() {
    this.checkCookie();
  }

  checkCookie() {
    var exists = this.getCookie("SEICookie"); // get our cookie
    if (exists != "1") {
      this.showCookieWindow();
    }
  }

  async showCookieWindow() {
    if (this.cookieDiv) {
      const dataCookie = await GET_THEME_OPTIONS({
        ACTION: "options",
      });
      this.cookieDiv.innerHTML = `
        <section class="c--cookies-a js--cookies">
          <div class="f--container">
            <div class="f--row">
              <div class="f--col-12">
                <div class="c--cookies-a__wrapper">
                  <div class="c--cookies-a__wrapper__item-left">
                    ${dataCookie.data.acf.cookies_text}
                  </div>
                  <div class="c--cookies-a__wrapper__item-right">
                    <a href="${dataCookie.data.acf.cookie_settings_link}" class="c--cookies-a__wrapper__item-right__link">
                      Privacy Policy
                    </a>
                    <button class="c--cookies-a__wrapper__item-right__btn js--click-setCookie">
                      Accept
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      `;
      document.querySelector(".js--click-setCookie").addEventListener("click", this.acceptCookies.bind(this));
    }
  }

  acceptCookies(e) {
    e.preventDefault();
    this.setCookie();
  }

  setCookie() {
    axios({
      method: "post",
      url: base_wp_api.ajax_url + "?action=set_cookie",
    })
      .then((response) => {
        document.querySelector(".js--cookies").style.display = "none";
      })
      .catch((err) => {
        console.error("Error setting cookie:", err);
      });
  }

  getCookie(cookie) {
    var name = cookie + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  closeModal(e) {
    e.preventDefault();
    if (document.querySelector(".js--cookies")) {
      document.querySelector(".js--cookies").style.display = "none";
    }
  }

  destroy() {
    document.querySelector(".js--click-setCookie").removeEventListener("click", this.acceptCookies.bind(this));
    document.querySelector(".js--click-closeCookie").removeEventListener("click", this.closeModal.bind(this));
  }
}

export default SetCookies;

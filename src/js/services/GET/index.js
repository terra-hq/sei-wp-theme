import axios from "axios";
import qs from "qs";

const siteURL = base_wp_api.root_url;
const postURL = base_wp_api.ajax_url;

export const GET_FILTERED_INSIGHTS = async (payload) => {
    let receivedData = null;
    var settings = {
        baseURL: payload.baseURL,
    };
    try {
        receivedData = await axios.get(settings.baseURL);
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

export const GET_FILTERED_BLOGS = async (payload) => {
    let receivedData = null;
    var settings = {
        baseURL: payload.baseURL,
    };
    try {
        receivedData = await axios.get(settings.baseURL);
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

export const GET_CUSTOM_ENDPOINT = async (payload) => {
    let receivedData = null;
    var settings = {
        action: payload.ACTION,
        page_id: payload.PAGE_ID,
        keyword: payload.keyword
    };
    try {
        receivedData = await axios.get(
            siteURL +  `/wp-json/wp/v2/tf_api/${settings.action}?keyword=${settings.keyword}`
        );
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

export const GET_CUSTOM = async (payload) => {
    let receivedData = null;
    var settings = {
        action: payload.ACTION,
        page_id: payload.PAGE_ID,
    };
    try {
        receivedData = await axios.get(siteURL + `/wp-json/wp/v2/tf_api/${settings.action}/${settings.page_id}`);
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

export const GET_THEME_OPTIONS = async (payload) => {
    let receivedData = null;
    var settings = {
        action: payload.ACTION
    };
    try {
        receivedData = await axios.get(siteURL + `/wp-json/acf/v2/${settings.action}`);
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

export const GET_CS_ENDPOINT = async (payload) => {
    let receivedData = null;
    var settings = {
        action: payload.ACTION,
        page_id: payload.PAGE_ID,
        per_page: payload.PER_PAGE,
        offset: payload.OFFSET,
    };
    try {
        receivedData = await axios.get(siteURL + `/wp-json/wp/v2/tf_api/${settings.action}/${settings.page_id}?per_page=${settings.per_page}&offset=${settings.offset}`);
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

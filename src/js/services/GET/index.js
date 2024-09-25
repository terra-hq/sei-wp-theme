/**
 * Importa las librerías necesarias: Axios para realizar peticiones HTTP y qs para manejar query strings.
 */
import axios from "axios";
import qs from "qs";

/**
 * Variables globales que contienen las URLs de la API de WordPress y del Ajax en WordPress.
 */
const siteURL = base_wp_api.root_url;
const postURL = base_wp_api.ajax_url;

/**
 * GET_FILTERED_INSIGHTS
 * @description Realiza una solicitud GET a la URL proporcionada para obtener información filtrada de Insights.
 * @param {Object} payload - Contiene la baseURL que se utilizará para realizar la solicitud.
 * @returns {Object|null} receivedData - Datos obtenidos de la solicitud o null en caso de error.
 */
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

/**
 * GET_FILTERED_BLOGS
 * @description Realiza una solicitud GET a la URL proporcionada para obtener información filtrada de Blogs.
 * @param {Object} payload - Contiene la baseURL que se utilizará para realizar la solicitud.
 * @returns {Object|null} receivedData - Datos obtenidos de la solicitud o null en caso de error.
 */
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

/**
 * GET_CUSTOM_ENDPOINT
 * @description Realiza una solicitud GET a un endpoint personalizado en la API de WordPress.
 * @param {Object} payload - Contiene los parámetros ACTION, PAGE_ID, y keyword.
 * @returns {Object|null} receivedData - Datos obtenidos de la solicitud o null en caso de error.
 */
export const GET_CUSTOM_ENDPOINT = async (payload) => {
    let receivedData = null;
    var settings = {
        action: payload.ACTION,
        page_id: payload.PAGE_ID,
        keyword: payload.keyword
    };
    try {
        receivedData = await axios.get(
            siteURL + `/wp-json/wp/v2/tf_api/${settings.action}?keyword=${settings.keyword}`
        );
    } catch (error) {
        console.log(error);
    }
    return receivedData;
};

/**
 * GET_CUSTOM
 * @description Realiza una solicitud GET para obtener datos de un endpoint personalizado usando el action y el page_id.
 * @param {Object} payload - Contiene los parámetros ACTION y PAGE_ID.
 * @returns {Object|null} receivedData - Datos obtenidos de la solicitud o null en caso de error.
 */
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

/**
 * GET_THEME_OPTIONS
 * @description Realiza una solicitud GET para obtener las opciones de tema de WordPress usando la API de ACF.
 * @param {Object} payload - Contiene el parámetro ACTION que define la acción a realizar.
 * @returns {Object|null} receivedData - Datos obtenidos de la solicitud o null en caso de error.
 */
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

/**
 * GET_CS_ENDPOINT
 * @description Realiza una solicitud GET para obtener datos desde un endpoint de Client Success.
 * @param {Object} payload - Contiene los parámetros ACTION, PAGE_ID, PER_PAGE, y OFFSET.
 * @returns {Object|null} receivedData - Datos obtenidos de la solicitud o null en caso de error.
 */
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

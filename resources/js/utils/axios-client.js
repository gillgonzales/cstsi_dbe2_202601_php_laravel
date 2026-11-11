import axios from "axios";

export const API_HOST = import.meta.env.VITE_API_HOST
export const API_URL = import.meta.env.VITE_API_URL
console.log(API_HOST,API_URL)
const axiosClient = axios.create({
    baseURL: API_URL,
});

axiosClient.defaults.withCredentials = true
axiosClient.defaults.withXSRFToken = true;
axiosClient.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axiosClient.interceptors.request.use((config) => {
    config.headers.Accept = "application/json";
    return config;
});

axiosClient.interceptors.response.use(
    (response) => { return response },
    (error) => {
        console.error('Axios:', error)
        throw error;
    }
);

export const getCsrfCookie = async ()=>{
const csrfUrl = API_HOST + `/sanctum/csrf-cookie`
      console.log({ csrfUrl })
      await axiosClient.get(csrfUrl)
}

export default axiosClient;

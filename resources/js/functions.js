import axios from 'axios';


export function sendRequest(url, data){
    return axios.post(url, data);
}



export default class HttpClient {
    constructor( baseUrl= '', csrfToken = '') {
        this.baseUrl = baseUrl;
        this.csrfToken = csrfToken;
    }

    request (url, method, callBack, parameters = {}, headers) {

        headers = headers || {};
        if(method != 'GET') {
            headers['X-CSRF-TOKEN'] = this.csrfToken;
        }
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...headers
            },
        }

        const cleanUrl = url.replace(this.baseUrl, '');
    
        let fullUrl = this.baseUrl + cleanUrl;
    
        if (method === 'GET' && Object.entries(parameters).length > 0) {
            const queryString = new URLSearchParams(parameters).toString();
            fullUrl = `${fullUrl}?${queryString}`;
        } else if( method !== 'GET') {
            options.body = JSON.stringify(parameters);
        }
        fetch(fullUrl, options)
            .then(response => response.json())
            .then(data => { 
                callBack(data);
                console.log(data);
            })
            .catch(error => console.log(url, method, error));
    }

    delete(url, callBack) {
        this.request(url, 'DELETE', callBack);
    }
    get(url, parameters = {}, callBack) {
        this.request(url, 'GET', callBack, parameters);
    }

    post(url, parameters = {}, callBack) {
        this.request(url, 'POST', callBack, parameters);
    }

    put(url, parameters = {}, callBack) {
        this.request(url, 'PUT', callBack, parameters);
    }



}
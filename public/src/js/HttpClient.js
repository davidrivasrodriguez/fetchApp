export default class HttpClient {
    constructor(baseUrl = '', csrfToken = '') {
        this.baseUrl = baseUrl;
        this.csrfToken = csrfToken;
    }

        request(url, method = 'GET', parameters = {}, headers = {}, callBack) {
        // Check if the URL is absolute (starts with http:// or https://)
        const finalUrl = url.startsWith('http') ? url : this.baseUrl + url;
    
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...headers
            }
        };
    
        if (method !== 'GET') {
            options.headers['X-CSRF-Token'] = this.csrfToken;
            if (Object.keys(parameters).length > 0) {
                options.body = JSON.stringify(parameters);
            }
        }
    
        fetch(finalUrl, options)
            .then(response => response.json())
            .then(data => {
                if (typeof callBack === 'function') {
                    callBack(data);
                }
            })
            .catch(error => {
                console.error('Request failed:', error);
            });
    }


    delete(url, parameters = {}, callBack) {
        this.request(url, 'DELETE', parameters, {}, callBack);
    }

    get(url, parameters = {}, callBack) {
        this.request(url, 'GET', parameters, {}, callBack);
    }

    post(url, parameters = {}, callBack) {
        this.request(url, 'POST', parameters, {}, callBack);
    }

    put(url, parameters = {}, callBack) {
        this.request(url, 'PUT', parameters, {}, callBack);
    }
}
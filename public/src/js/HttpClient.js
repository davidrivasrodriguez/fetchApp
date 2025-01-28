export default class HttpClient {
    constructor(baseUrl = '', csrfToken = '') {
        this.baseUrl = baseUrl;
        this.csrfToken = csrfToken;
    }

        request(url, method = 'GET', parameters = {}, headers = {}, callBack) {
        const finalUrl = url.startsWith('http') ? url : this.baseUrl + url;
        
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...headers
            },
            credentials: 'include'
        };
    
        if (method !== 'GET') {
            options.headers['X-CSRF-Token'] = this.csrfToken;
            if (Object.keys(parameters).length > 0) {
                options.body = JSON.stringify(parameters);
            }
        }
    
        fetch(finalUrl, options)
            .then(async response => {
                const contentType = response.headers.get('content-type');
                
                if (!response.ok) {
                    const errorData = contentType?.includes('application/json') 
                        ? await response.json() 
                        : await response.text();
                    throw new Error(JSON.stringify({
                        status: response.status,
                        statusText: response.statusText,
                        data: errorData
                    }));
                }
    
                if (contentType?.includes('application/json')) {
                    return response.json();
                } else if (contentType?.includes('text/html')) {
                    return response.text();
                }
    
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch {
                        return text;
                    }
                });
            })
            .then(data => {
                if (typeof callBack === 'function') {
                    // Add session check in successful response
                    if (data.status === 'success') {
                        localStorage.setItem('isAuthenticated', 'true');
                    }
                    callBack(data);
                }
            })
            .catch(error => {
                console.error('Request failed:', error);
                const errorElement = document.getElementById('productError');
                if (errorElement) {
                    errorElement.style.display = 'block';
                    errorElement.textContent = error.message;
                }
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
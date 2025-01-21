import PageItem from './PageItem.js';
import ResponseRow from './ResponseRow.js';

export default class ResponseContent {

    constructor(content, paginationContent, httpClient) {
        this.content = content;
        this.currentPage = 1;
        this.paginationContent = paginationContent;
        this.httpClient = httpClient; // Add this line
        this.pageItem = new PageItem(this.paginationContent);
        this.responseRow = new ResponseRow(this.content, this.currentPage);
    }

    cleanContent(element) {
        while (element.firstChild) {
            element.removeChild(element.firstChild);
        }
    }

        setContent(data) {
        this.cleanContent(this.content);
        this.cleanContent(this.paginationContent);
    
        // Create button
        const buttonCreate = document.createElement('button');
        buttonCreate.textContent = 'create';
        buttonCreate.setAttribute('data-bs-toggle', 'modal');
        buttonCreate.setAttribute('data-bs-target', '#createModal');
        buttonCreate.classList.add('btn', 'btn-success');
        buttonCreate.dataset.url = "/product";
        buttonCreate.dataset.method = "post";
        this.content.appendChild(buttonCreate);
    
        if (data.products) {  // Changed this condition
            // Set current page
            this.currentPage = data.products.current_page || 1;
    
            // Add products
            if (data.products.data) {
                data.products.data.forEach(product => {
                    this.responseRow.add(product);
                });
            }
    
            // Add pagination
            this.pageItem.add(data.products, (url) => {
                this.httpClient.get(url, {}, (response) => {
                    this.setContent(response);
                });
            });
        }
    }
}
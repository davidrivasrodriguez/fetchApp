import PageItem from './PageItem.js';
import ResponseRow from './ResponseRow.js';

export default class ResponseContent {

    constructor(content, paginationContent, httpClient) {
        if (!content || !paginationContent || !httpClient) {
            throw new Error('Missing required elements for ResponseContent');
        }
        this.content = content;
        this.currentPage = 1;
        this.paginationContent = paginationContent;
        this.httpClient = httpClient;
        this.pageItem = new PageItem(this.paginationContent);
        this.responseRow = new ResponseRow(this.content, this.currentPage);
    }

    cleanContent(element) {
        if (element && element.firstChild) {
            while (element.firstChild) {
                element.removeChild(element.firstChild);
            }
        }
    }

    setContent(data) {
        this.cleanContent(this.content);
        this.cleanContent(this.paginationContent);


        // Create div container for buttons
        const buttonContainer = document.createElement('div');
        buttonContainer.classList.add('d-flex', 'justify-content-between', 'mb-3');

        // Create button
        const buttonCreate = document.createElement('button');
        buttonCreate.textContent = 'create';
        buttonCreate.setAttribute('data-bs-toggle', 'modal');
        buttonCreate.setAttribute('data-bs-target', '#createModal');
        buttonCreate.classList.add('btn', 'btn-success');
        buttonCreate.dataset.url = "/product";
        buttonCreate.dataset.method = "post";

        // // Register button
        // const buttonRegister = document.createElement('button');
        // buttonRegister.innerHTML = '<i class="fas fa-user-plus"></i> Register';
        // buttonRegister.setAttribute('data-bs-toggle', 'modal');
        // buttonRegister.setAttribute('data-bs-target', '#registerModal');
        // buttonRegister.setAttribute('data-url', '/register');
        // buttonRegister.classList.add('btn', 'btn-primary');

        // Left side container for Create button
        const leftContainer = document.createElement('div');
        leftContainer.appendChild(buttonCreate);

        // Right side container for Register button
        const rightContainer = document.createElement('div');
        // rightContainer.appendChild(buttonRegister);

        // Add buttons to container
        buttonContainer.appendChild(leftContainer);
        buttonContainer.appendChild(rightContainer);
        this.content.appendChild(buttonContainer);


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
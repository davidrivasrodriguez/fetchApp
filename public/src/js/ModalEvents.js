import HttpClient from './HttpClient.js';
import ResponseContent from './ResponseContent.js';

export default class ModalEvents {

    constructor(url, csrf) {
        this.url = url;
        this.csrf = csrf;

        this.content = document.getElementById('content');
        this.pagination = document.getElementById('pagination');

        this.fetchUrl = '';
        this.httpClient = new HttpClient(this.url, this.csrf);
        this.responseContent = new ResponseContent(this.content, this.pagination, this.httpClient);

        this.modalCreate = document.getElementById('createModal');
        this.modalCreateButton = document.getElementById('modalCreateButton');

        this.modalDelete = document.getElementById('deleteModal');
        this.modalDeleteButton = document.getElementById('modalDeleteButton');

        this.modalEdit = document.getElementById('editModal');
        this.modalEditButton = document.getElementById('modalEditButton');

        this.modalView = document.getElementById('viewModal');

        this.createName = document.getElementById('createName');
        this.createPrice = document.getElementById('createPrice');

        this.deleteName = document.getElementById('deleteName');
        this.deletePrice = document.getElementById('deletePrice');

        this.editName = document.getElementById('editName');
        this.editPrice = document.getElementById('editPrice');

        this.viewCreatedAt = document.getElementById('viewCreatedAt');
        this.viewId = document.getElementById('viewId');
        this.viewName = document.getElementById('viewName');
        this.viewPrice = document.getElementById('viewPrice');
        this.viewUpdatedAt = document.getElementById('viewUpdatedAt');

        this.productError = document.getElementById('productError');
        this.productSuccess = document.getElementById('productSuccess');

        this.assignEvents();
    }

    assignEvents() {

        this.modalCreate.addEventListener('show.bs.modal', event => {
            document.getElementById('modalCreateWarning').style.display = 'none';
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.createName.value = '';
            this.createPrice.value = '';
        });

        this.modalDelete.addEventListener('show.bs.modal', event => {
            document.getElementById('modalDeleteWarning').style.display= 'none';
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.deleteName.value = event.relatedTarget.dataset.name;
            this.deletePrice.value = event.relatedTarget.dataset.price;
        });

        this.modalEdit.addEventListener('show.bs.modal', event => {
            document.getElementById('modalEditWarning').style.display= 'none';
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.editName.value = event.relatedTarget.dataset.name;
            this.editPrice.value = event.relatedTarget.dataset.price;
        });

        this.modalView.addEventListener('show.bs.modal', event => {
            document.getElementById('modalViewWarning').style.display= 'none';
            this.viewCreatedAt.value = '';
            this.viewId.value = '';
            this.viewName.value = event.relatedTarget.dataset.name;
            this.viewPrice.value = event.relatedTarget.dataset.price;
            this.viewUpdatedAt.value = '';
            
            const url = event.relatedTarget.dataset.url;

            this.httpClient.get(
                url,
                {},
                data => this.responseShow(data)
            );
        });

        this.modalCreateButton.addEventListener('click', event => {
            this.httpClient.post(
                this.fetchUrl,
                {
                    name: this.createName.value,
                    price: this.createPrice.value,
                    page: this.responseContent.currentPage
                },
                data => this.responseCreate(data)
            );
        });

        this.modalDeleteButton.addEventListener('click', event => {
            this.httpClient.delete(
                this.fetchUrl,
                {
                    page: this.responseContent.currentPage
                },
                data => this.responseDelete(data));
        });

        this.modalEditButton.addEventListener('click', event => {
            this.httpClient.put(
                this.fetchUrl,
                {
                    name: this.editName.value,
                    price: this.editPrice.value,
                    page: this.responseContent.currentPage
                },
                data => this.responseEdit(data)
            );
        });
    }

    responseCreate(data) {
        if(data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalCreate).hide();
            this.responseContent.setContent(data);
            setTimeout(() => {
                this.productSuccess.style.display= 'none';
            }, 4000);
        } else {
            document.getElementById('modalCreateWarning').style.display = 'block';
        }
    }

    responseDelete(data) {
        if(data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalDelete).hide();
            this.responseContent.setContent(data);
            setTimeout(() => {
                this.productSuccess.style.display= 'none';
            }, 4000);
        } else {
            document.getElementById('modalDeleteWarning').style.display = 'block';
        }
    }

    responseEdit(data) {
        if(data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalEdit).hide();
            this.responseContent.setContent(data);
            setTimeout(() => {
                this.productSuccess.style.display= 'none';
            }, 4000);
        } else {
            document.getElementById('modalEditWarning').style.display = 'block';
        }
    }

    responseShow(data) {
        const {id, name, price, created_at, updated_at} = data.product;
        this.viewCreatedAt.value = created_at;
        this.viewId.value = id;
        this.viewName.value = name;
        this.viewPrice.value = price;
        this.viewUpdatedAt.value = updated_at;
    }

    init() {
        this.httpClient.get('/product',{}, (data) => {
            this.responseContent.setContent(data);
        });
    }
}
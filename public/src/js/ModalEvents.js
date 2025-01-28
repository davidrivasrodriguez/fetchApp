import HttpClient from './HttpClient.js';
import ResponseContent from './ResponseContent.js';

export default class ModalEvents {

    constructor(url, csrf) {
        this.url = url;
        this.csrf = csrf;

        this.registerUrl = `${url}/register`; 
        this.loginUrl = `${url}/login`;
        this.logoutUrl = `${url}/logout`;

        this.content = document.getElementById('content');
        this.pagination = document.getElementById('pagination');

        if (!this.content || !this.pagination) {
            throw new Error('Required DOM elements not found');
        }

        this.fetchUrl = '';
        this.httpClient = new HttpClient(url, csrf);
        this.responseContent = new ResponseContent(
            this.content,
            this.pagination,
            this.httpClient,
        );

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

        this.modalRegister = document.getElementById('registerModal');
        this.modalRegisterUserButton = document.getElementById('registerUserButton');
        this.registerName = document.getElementById('registerName');
        this.registerEmail = document.getElementById('registerEmail');
        this.registerPassword = document.getElementById('registerPassword');
        this.registerConfirmPassword = document.getElementById('registerConfirmPassword');
        this.modalRegisterWarning = document.getElementById('modalRegisterWarning');


        this.modalLogin = document.getElementById('loginModal');
        this.modalLoginUserButton = document.getElementById('loginUserButton');
        this.loginEmail = document.getElementById('loginEmail');
        this.loginPassword = document.getElementById('loginPassword');
        this.modalLoginWarning = document.getElementById('modalLoginWarning');


        this.logoutButton = document.getElementById('logoutButton');

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
            document.getElementById('modalDeleteWarning').style.display = 'none';
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.deleteName.value = event.relatedTarget.dataset.name;
            this.deletePrice.value = event.relatedTarget.dataset.price;
        });

        this.modalEdit.addEventListener('show.bs.modal', event => {
            document.getElementById('modalEditWarning').style.display = 'none';
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.editName.value = event.relatedTarget.dataset.name;
            this.editPrice.value = event.relatedTarget.dataset.price;
        });

        this.modalView.addEventListener('show.bs.modal', event => {
            document.getElementById('modalViewWarning').style.display = 'none';
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

        this.modalRegister.addEventListener('show.bs.modal', event => {
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.registerName.value = '';
            this.registerEmail.value = '';
            this.registerPassword.value = '';
            this.registerConfirmPassword.value = '';
        });


        this.modalLogin.addEventListener('show.bs.modal', event => {
            this.fetchUrl = event.relatedTarget.dataset.url;
            this.loginEmail.value = '';
            this.loginPassword.value = '';
            this.modalLoginWarning.style.display = 'none';
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
        if (this.modalRegisterUserButton) {
            this.modalRegisterUserButton.addEventListener('click', event => {
                this.httpClient.post(
                    this.registerUrl,
                    {
                        name: this.registerName.value,
                        email: this.registerEmail.value,
                        password: this.registerPassword.value,
                        password_confirmation: this.registerConfirmPassword.value
                    },
                    data => this.responseRegister(data)
                );
            });
        }

        if (this.modalLoginUserButton) {
            this.modalLoginUserButton.addEventListener('click', event => {
                this.httpClient.post(
                    this.loginUrl,  
                    {
                        email: this.loginEmail.value,
                        password: this.loginPassword.value
                    },
                    data => this.responseLogin(data)
                );
            });
        }

        if (this.logoutButton) {
            this.logoutButton.addEventListener('click', event => {
                this.httpClient.post(
                    this.logoutUrl, 
                    {},
                    data => {
                        window.location.reload();
                    }
                );
            });
        }

    }

    responseCreate(data) {
        if (data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalCreate).hide();
            this.responseContent.setContent(data);
            setTimeout(() => {
                this.productSuccess.style.display = 'none';
            }, 4000);
        } else {
            document.getElementById('modalCreateWarning').style.display = 'block';
        }
    }

    responseDelete(data) {
        if (data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalDelete).hide();
            this.responseContent.setContent(data);
            setTimeout(() => {
                this.productSuccess.style.display = 'none';
            }, 4000);
        } else {
            document.getElementById('modalDeleteWarning').style.display = 'block';
        }
    }

    responseEdit(data) {
        if (data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalEdit).hide();
            this.responseContent.setContent(data);
            setTimeout(() => {
                this.productSuccess.style.display = 'none';
            }, 4000);
        } else {
            document.getElementById('modalEditWarning').style.display = 'block';
        }
    }

    responseShow(data) {
        const { id, name, price, created_at, updated_at } = data.product;
        this.viewCreatedAt.value = created_at;
        this.viewId.value = id;
        this.viewName.value = name;
        this.viewPrice.value = price;
        this.viewUpdatedAt.value = updated_at;
    }

    responseRegister(data) {
        // Add console.log to debug the response
        console.log('Registration response:', data);
        
        if (data.status === 201 || data.status === 200 || data.success || data.result) {
            this.productSuccess.style.display = 'block';
            bootstrap.Modal.getInstance(this.modalRegister).hide();
            
            // Clear form
            this.registerName.value = '';
            this.registerEmail.value = '';
            this.registerPassword.value = '';
            this.registerConfirmPassword.value = '';
            
            setTimeout(() => {
                this.productSuccess.style.display = 'none';
                window.location.reload();
            }, 2000);
        } else {
            this.modalRegisterWarning.style.display = 'block';
            // Display validation errors if they exist
            if (data.errors) {
                this.modalRegisterWarning.textContent = Object.values(data.errors).flat().join('\n');
            } else {
                this.modalRegisterWarning.textContent = data.message || 'Registration failed. Please try again.';
            }
        }
    }


    responseLogin(data) {
        console.log('Login response:', data);
        
        // First check if there is a validation error
        if (data.errors) {
            this.modalLoginWarning.style.display = 'block';
            this.modalLoginWarning.textContent = Object.values(data.errors).flat().join(', ');
            return;
        }
    
        // Check for successful login - Laravel specific response
        if (data === true || data.success === true || data.status === 200 || data.result === true || !data.error) {
            this.productSuccess.style.display = 'block';
            this.modalLoginWarning.style.display = 'none';
            
            // Hide modal
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            if (loginModal) {
                loginModal.hide();
            }
            
            // Clear login form
            this.loginEmail.value = '';
            this.loginPassword.value = '';
            
            // Store authentication state
            localStorage.setItem('isAuthenticated', 'true');
            
            // Reload page immediately on success
            window.location.reload();
        } else {
            // Show error message
            this.modalLoginWarning.style.display = 'block';
            this.modalLoginWarning.textContent = data.message || 'Invalid credentials';
        }
    }

    init() {
        this.httpClient.get('/product', {}, (data) => {
            this.responseContent.setContent(data);
        });
    }
}
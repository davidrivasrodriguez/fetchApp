<!doctype html>
<html lang="es" class="h-100" data-bs-theme="auto">

    <head>
        <!-- https://getbootstrap.com/docs/5.3/examples/sticky-footer/ -->

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.122.0">
        <meta name="theme-color" content="#712cf9">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="url-base" content="{{ url('') }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>Fetch</title>

        <style>
            .container {
                width: auto;
                max-width: 680px;
                padding: 0 15px;
            }

            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            .b-example-divider {
                width: 100%;
                height: 3rem;
                background-color: rgba(0, 0, 0, .1);
                border: solid rgba(0, 0, 0, .15);
                border-width: 1px 0;
                box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }

            .b-example-vr {
                flex-shrink: 0;
                width: 1.5rem;
                height: 100vh;
            }

            .bi {
                vertical-align: -.125em;
                fill: currentColor;
            }

            .nav-scroller {
                position: relative;
                z-index: 2;
                height: 2.75rem;
                overflow-y: hidden;
            }

            .nav-scroller .nav {
                display: flex;
                flex-wrap: nowrap;
                padding-bottom: 1rem;
                margin-top: -1px;
                overflow-x: auto;
                text-align: center;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }

            .btn-bd-primary {
                --bd-violet-bg: #712cf9;
                --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

                --bs-btn-font-weight: 600;
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: var(--bd-violet-bg);
                --bs-btn-border-color: var(--bd-violet-bg);
                --bs-btn-hover-color: var(--bs-white);
                --bs-btn-hover-bg: #6528e0;
                --bs-btn-hover-border-color: #6528e0;
                --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
                --bs-btn-active-color: var(--bs-btn-hover-color);
                --bs-btn-active-bg: #5a23c8;
                --bs-btn-active-border-color: #5a23c8;
            }

            .bd-mode-toggle {
                z-index: 1500;
            }

            .bd-mode-toggle .dropdown-menu .active .bi {
                display: block !important;
            }
        </style>
    </head>

    <body class="d-flex flex-column h-100">

        <!-- Modal -->
       @include('modal')

        <!-- Begin page content -->
        <main class="flex-shrink-0">
            <div class="container">
                <h1 class="mt-5">Product</h1>
                <p class="lead">
                    Tercera versión de la misma aplicación de productos: fetch (ajax).
                </p>

                <div id="liveAlertPlaceholder"></div>
                <div id="content"></div>
                <div id="pagination" class="pagination"></div>
            </div>
        </main>

        <footer class="footer mt-auto py-3 bg-body-tertiary">
            <div class="container">
                <span class="text-body-secondary">Place sticky footer content here.</span>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- <script type="module" src="{{ url('src/js/HttpClient.js')}}"></script> -->
        <script type="module">
            import HttpClient from './src/js/HttpClient.js';
            import PageItem from './src/js/PageItem.js';
            const content = document.getElementById('content');
            const pagination = document.getElementById('pagination');
            const pageItem = new PageItem(pagination);
            const csrf = document.querySelector('meta[name="csrf-token"]')['content'];
            const mainUrl = document.querySelector('meta[name="url-base"]')['content'];
            const httpClient = new HttpClient(mainUrl, csrf);
            let currentPage = 1;


            const renderFetchData = (data) => {
                console.log(data)

                while (content.firstChild) {
                    content.removeChild(content.firstChild);
                }

                while (pagination.firstChild) {
                    pagination.removeChild(pagination.firstChild);
                }

                const buttonCreate = document.createElement('button');
                buttonCreate.textContent = 'Create';
                buttonCreate.setAttribute('data-bs-toggle', 'modal');
                buttonCreate.setAttribute('data-bs-target', '#createModal');
                buttonCreate.classList.add('btn', 'btn-success');
                buttonCreate.dataset.url = '/product';
                buttonCreate.dataset.method = 'POST';
                content.appendChild(buttonCreate);

                data.products.links.forEach(element => {
                    pageItem.add(element, () => {
                        const url = new URL(element.url);
                        currentPage = url.searchParams.get('page') || 1;
        
                        httpClient.get(element.url, {}, (data) => {
                            renderFetchData(data);
                        });
                    });
                });

                if (!data || !data.products) {
                console.error('No products data available');
                return;
                }
                
                data.products.data.forEach(element => {
                    const div = document.createElement('div');
                    /*for (const key in element) {
                        div.textContent = element[key];
                    }*/
                    const {id, name, price} = element //destructuring assignment
                    div.textContent = id + ' ' + name + ' ' + price;

                    const buttonView = document.createElement('button');
                    buttonView.textContent = 'View';
                    buttonView.setAttribute('data-bs-toggle', 'modal');
                    buttonView.setAttribute('data-bs-target', '#viewModal');
                    buttonView.classList.add('btn', 'btn-primary');
                    buttonView.dataset.id = id;
                    buttonView.dataset.name = name;
                    buttonView.dataset.value = price;
                    buttonView.dataset.url = '/product/' + id;
                    buttonView.dataset.method = 'GET';

                    const buttonEdit = document.createElement('button');
                    buttonEdit.textContent = 'Edit';
                    buttonEdit.setAttribute('data-bs-toggle', 'modal');
                    buttonEdit.setAttribute('data-bs-target', '#editModal');
                    buttonEdit.classList.add('btn', 'btn-warning');
                    buttonEdit.dataset.id = id;
                    buttonEdit.dataset.name = name;
                    buttonEdit.dataset.value = price;
                    buttonEdit.dataset.url = '/product/' + id;
                    buttonEdit.dataset.method = 'PUT';

                    const buttonDelete = document.createElement('button');
                    buttonDelete.textContent = 'Delete';
                    buttonDelete.setAttribute('data-bs-toggle', 'modal');
                    buttonDelete.setAttribute('data-bs-target', '#deleteModal');
                    buttonDelete.classList.add('btn', 'btn-danger');
                    buttonDelete.dataset.id = id;
                    buttonDelete.dataset.name = name;
                    buttonDelete.dataset.value = price;
                    buttonDelete.dataset.url = '/product/' + id;
                    buttonDelete.dataset.method = 'DELETE';

                    div.appendChild(buttonView);
                    div.appendChild(buttonEdit);
                    div.appendChild(buttonDelete);
                    content.appendChild(div);
                });
            }

            //Create Product Functionalities
            const name = document.getElementById('productName');
            const price = document.getElementById('productPrice');
            const modalCreate = document.getElementById('createModal');
            const submitCreate = document.getElementById('bt-confirm-create');
            submitCreate.addEventListener('click', (event) => {
                const createData = {
                    name: name.value,
                    price: price.value
                };
                
                httpClient.post('/product', createData, (response) => {
                    console.log('Create response:', response);
                    if (response.result) {
                        appendAlert('Created successfully!', 'success', alertPlaceholder);
                        
                        // Clear form fields
                        name.value = '';
                        price.value = '';
                        
                        // Close the modal
                        const createModal = bootstrap.Modal.getInstance(modalCreate);
                        createModal.hide();
                        
                        // Refresh product list
                        httpClient.get('/product', {}, (data) => {
                            renderFetchData(data);
                        });
                    } else {
                        const modalBody = modalCreate.querySelector('.modal-body');
                        appendAlert('Error: Could not create!', 'danger', modalBody);
                        modalCreate.addEventListener('hidden.bs.modal', () => {
                            modalBody.querySelector('.alert').remove();
                        }, { once: true });
                    }
                });
            });

            const modalView = document.getElementById('viewModal');
            modalView.addEventListener('show.bs.modal', function (event) {
                console.log('View');
                console.log(event.relatedTarget.dataset.id, event.relatedTarget.dataset.url);
                const url = event.relatedTarget.dataset.url;
                httpClient.get(url, {}, (data) => {
                    const idView = document.getElementById('id-view');
                    const {id, name, price, created_at, updated_at} = data.product;
                    idView.innerHTML = `
                        <p><strong>ID:</strong> ${id}</p>
                        <p><strong>Name:</strong> ${name}</p>
                        <p><strong>Price:</strong> ${price}$</p>
                        <p><strong>Created At:</strong> ${created_at}</p>
                        <p><strong>Updated At:</strong> ${updated_at}</p>
                    `;
                });
            });

            const editName = document.getElementById('editProductName');
            const editPrice = document.getElementById('editProductPrice');
            const modalEdit = document.getElementById('editModal');
            const submitEdit = document.getElementById('bt-confirm-edit');
            let editData;
            
            modalEdit.addEventListener('show.bs.modal', function (event) {
                console.log('Edit');
                editName.value = event.relatedTarget.dataset.name;
                editPrice.value = event.relatedTarget.dataset.value;
                editData = {
                    url: event.relatedTarget.dataset.url,
                    method: event.relatedTarget.dataset.method
                };
            });
            
            submitEdit.addEventListener('click', (event) => {
                const updateData = {
                    name: editName.value,
                    price: editPrice.value
                };
                
                httpClient.put(editData.url, updateData, (response) => {
                    console.log('Edit response:', response);
                    if (response.result) {
                        appendAlert('Updated successfully!', 'success', alertPlaceholder);
                        
                        // Close the modal
                        const editModal = bootstrap.Modal.getInstance(modalEdit);
                        editModal.hide();
                        
                        // Refresh product list
                        httpClient.get(`/product?page=${currentPage}`, {}, (data) => {
                            renderFetchData(data);
                        });
                    } else {
                        const modalBody = modalEdit.querySelector('.modal-body');
                        appendAlert('Error: Could not update!', 'danger', modalBody);
                        modalEdit.addEventListener('hidden.bs.modal', () => {
                            modalBody.querySelector('.alert').remove();
                        }, { once: true });
                    }
                });
            });




            let deleteData; // Declare deleteData variable in outer scope

            const modalDeleteConfirm = document.getElementById('bt-confirm-delete');
            const modalDeleteName = document.getElementById('deleteModalName');
            const modalDelete = document.getElementById('deleteModal');
            modalDelete.addEventListener('show.bs.modal', (event) => {
                console.log('Delete');
                console.log(event.relatedTarget.dataset.id);
                modalDeleteConfirm.dataset.url = event.relatedTarget.dataset.url;
                modalDeleteConfirm.dataset.method = event.relatedTarget.dataset.method;
                modalDeleteName.textContent = event.relatedTarget.dataset.name;
                deleteData = {
                    url: event.relatedTarget.dataset.url,
                    method: event.relatedTarget.dataset.method
                }
            });

            const alertPlaceholder = document.getElementById('liveAlertPlaceholder');
            const appendAlert = (message, type, target) => {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = [
                    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                    `   <div>${message}</div>`,
                    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                    '</div>'
                ].join('');
                target.append(wrapper);
            };

            modalDeleteConfirm.addEventListener('click', () => {
                httpClient.delete(deleteData.url, (response) => {
                    console.log('Delete response:', response);
                    if (response.result) {
                        appendAlert('Deleted successfully!', 'success', alertPlaceholder);

                        httpClient.get(`/product?page=${currentPage}`, {}, (data) => {
                            renderFetchData(data);
                        });

                        const deleteModal = bootstrap.Modal.getInstance(modalDelete);
                        deleteModal.hide();
                    } else {
                        const modalBody = modalDelete.querySelector('.modal-body');
                        appendAlert('Error: Could not delete!', 'danger', modalBody);
                        modalDelete.addEventListener('hidden.bs.modal', () => {
                            modalBody.querySelector('.alert').remove();
                        }, { once: true });
                    }
                });
            });


            // function genericFetch(url, method, callback) {
            //     fetch(mainUrl + url, {
            //         method: method,
            //         headers: {
            //             'X-CSRF-TOKEN': csrf,
            //             'Content-Type': 'application/json',
            //             'Accept': 'application/json'
            //         }
            //     })
            //     .then(response => response.json())
            //     .then(data => {
            //         console.log(data);
            //         if (callback) callback(data);
            //     });
            // };


            //ejecucion diferida a lo largo del tiempo
            //1º fetch -> request/peticion a un ordenador -> tarda un tiempo
            //2º then  -> espera diferida de la llegada completa de la respuesta
            //3º then -> engtrega de respuesta transformada a json
            fetch(mainUrl + '/product')
            .then(response => response.json())
            .then(data => renderFetchData(data))

            httpClient.get('/product', {}, (data) => {
                renderFetchData(data);
            });

        </script>


        

    </body>
</html>
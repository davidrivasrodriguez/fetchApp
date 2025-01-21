export default class ResponseRow {
    constructor(parent, currentPage) {
        this.parent = parent;
        this.currentPage = currentPage;
    }

    add(data) {
        const div = document.createElement('div');
        div.classList.add('row', 'align-items-center', 'border-bottom', 'py-3');
        
        const {id, name, price} = data;
        
        // Columna para la información
        const infoCol = document.createElement('div');
        infoCol.classList.add('col-md-6');
        let textNode = document.createTextNode(`${id} - ${name} - $${price}`);
        infoCol.appendChild(textNode);
        
        // Columna para los botones
        const buttonCol = document.createElement('div');
        buttonCol.classList.add('col-md-6', 'd-flex', 'gap-2', 'justify-content-end');

        // Botón View
        const buttonView = document.createElement('button');
        buttonView.innerHTML = '<i class="fas fa-eye"></i> View';
        buttonView.setAttribute('data-bs-toggle', 'modal');
        buttonView.setAttribute('data-bs-target', '#viewModal');
        buttonView.classList.add('btn', 'btn-primary', 'btn-xl');
        Object.assign(buttonView.dataset, {id, name, price, url: `/product/${id}`, method: 'get'});

        // Botón Edit
        const buttonEdit = document.createElement('button');
        buttonEdit.innerHTML = '<i class="fas fa-edit"></i> Edit';
        buttonEdit.setAttribute('data-bs-toggle', 'modal');
        buttonEdit.setAttribute('data-bs-target', '#editModal');
        buttonEdit.classList.add('btn', 'btn-warning', 'btn-xl');
        Object.assign(buttonEdit.dataset, {id, name, price, url: `/product/${id}`, method: 'put'});

        // Botón Delete
        const buttonDelete = document.createElement('button');
        buttonDelete.innerHTML = '<i class="fas fa-trash"></i> Delete';
        buttonDelete.setAttribute('data-bs-toggle', 'modal');
        buttonDelete.setAttribute('data-bs-target', '#deleteModal');
        buttonDelete.classList.add('btn', 'btn-danger', 'btn-xl');
        Object.assign(buttonDelete.dataset, {id, name, price, url: `/product/${id}`, method: 'delete'});

        // Agregar botones al contenedor de botones
        buttonCol.appendChild(buttonView);
        buttonCol.appendChild(buttonEdit);
        buttonCol.appendChild(buttonDelete);

        // Agregar columnas al div principal
        div.appendChild(infoCol);
        div.appendChild(buttonCol);

        this.parent.appendChild(div);
    }
}
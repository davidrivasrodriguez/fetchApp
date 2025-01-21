<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Create</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label for="createName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="createName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="createPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="createPrice" name="price">
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalCreateWarning">An error ocurred. The product has not been created.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modalCreateButton">Create</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteForm">
                    <div class="mb-3">
                        <label for="deleteName" class="form-label">Name</label>
                        <input readonly disabled type="text" class="form-control" id="deleteName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="deletePrice" class="form-label">Price</label>
                        <input readonly disabled type="number" class="form-control" id="deletePrice" name="price">
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalDeleteWarning">An error ocurred. The product is still avaliable.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modalDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price">
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalEditWarning">An error ocurred. The product has not been edited.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modalEditButton">Edit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewModalLabel">View</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="viewForm">
                    <div class="mb-3">
                        <label for="viewId" class="form-label">Id</label>
                        <input disabled readonly type="text" class="form-control" id="viewId">
                    </div>
                    <div class="mb-3">
                        <label for="viewName" class="form-label">Name</label>
                        <input disabled readonly type="text" class="form-control" id="viewName">
                    </div>
                    <div class="mb-3">
                        <label for="viewPrice" class="form-label">Price</label>
                        <input disabled readonly type="number" class="form-control" id="viewPrice">
                    </div>
                    <div class="mb-3">
                        <label for="viewCreatedAt" class="form-label">Created at</label>
                        <input disabled readonly type="datetime" class="form-control" id="viewCreatedAt">
                    </div>
                    <div class="mb-3">
                        <label for="viewUpdatedAt" class="form-label">Updated at</label>
                        <input disabled readonly type="datetime" class="form-control" id="viewUpdatedAt">
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalViewWarning">An error ocurred. Product not found.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Ok</button>-->
            </div>
        </div>
    </div>
</div>
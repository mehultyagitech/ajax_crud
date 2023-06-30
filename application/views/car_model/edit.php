<form action="" method="post" id="editCarModel" name="editCarModel">
    <input type="hidden" name="id" value="<?php echo $row->id ?>">
    <div class="modal-body">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $row->name ?>" class="form-control" placeholder="Name">
            <p class="nameError" class="invalid-feedback d-block"></p>
        </div>

        <div class="form-group">
            <label for="">price</label>
            <input type="text" name="price" id="price" value="<?php echo $row->color ?>" class="form-control" placeholder="price">
            <p class="priceError" class="invalid-feedback d-block"></p>
        </div>

        <div class="form-group">
            <label for="">Transmission</label>
            <select name="transmission" id="transmission" class="form-control">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>

        <div class="form-group">
            <label for="">color</label>
            <input type="text" name="color" id="color" value="<?php echo $row->color ?>" class="form-control" placeholder="color">
            <p class="colorError" class="invalid-feedback d-block"></p>
        </div>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>

    </div>
</form>
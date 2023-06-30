<!DOCTYPE html>
<html>

<head>
    <title>AJAX CRUD APPLICATION</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assests/css/bootstrap.min.css">
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assests/js/jquery 3.7.0.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assests/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assests/css/style.css">

</head>

<body>
    <div class="header">
        <div class="container">
            <h3 class="heading">AJAX CRUD APPLICATION</h3>
        </div>
    </div>

    <div class="container">
        <div class="row pt-4"></div>
        <div class="col-md-6">
            <h4>Car Models</h4>
        </div>
        <div class="col-md-12 text-right pt-2">
            <a href="javascript:void(0);" onclick="showModal()" class="btn btn-primary">CREATE</a>
        </div>

        <div class="col-md-12 pt-3">
            <table class="table table-striped" id="carModelList">
                <tbody>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>price</th>
                        <th>transmission</th>
                        <th>color</th>
                        <th>created_at</th>
                        <th>edit</th>
                        <th>delete</th>

                    </tr>

                    <?php if (!empty($rows)) { ?>
                        <?php foreach ($rows as $row) : ?>
                            <tr id="row-<?php echo $row->id ?>">
                                <td class="modelId"><?php echo ($row->id); ?></td>
                                <td class="modleName"><?php echo ($row->name); ?></td>
                                <td class="modelPrice"><?php echo ($row->price); ?></td>
                                <td class="modelTransmission"><?php echo ($row->transmission); ?></td>
                                <td class="modelColor"><?php echo ($row->color) ?></td>
                                <td class="modelCreated_at"><?php echo ($row->created_at) ?></td>
                                <td>
                                    <a href="javascript:void(0);" onclick="showEditForm(<?php echo ($row->id) ?>)" ; class="btn btn-primary">edit</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" ; class="btn btn-danger" onclick="confirmDeleteModel(<?php echo ($row->id) ?>);">delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createCar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="response"></div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxResponseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="deleteNow();">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>


            <script type="text/javascript">
                function showModal() {
                    $("#createCar").modal("show");
                    $("#createCar #title").html("Create");
                    $("#createCar .modal-title").html('Edit')

                    $.ajax({
                        url: '<?php echo base_url() . 'index.php/CarModel/showCreateForm' ?>',
                        type: 'POST',
                        data: {},
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            $("#response").html(response["html"]);
                        }
                    })
                };

                $("body").on("submit", "#createCarModel", function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: '<?php echo base_url() . 'index.php/CarModel/saveModel' ?>',
                        type: 'POST',
                        data: $(this).serializeArray(),
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response['status'] == 0) {
                                if (response["name"] != "") {
                                    console.log(response["name"] != "");
                                    $(".nameError").html(response["name"]);
                                    $("#name").addClass('is-invalid');
                                }

                                if (response["color"] != "") {
                                    $(".colorError").html(response["color"]);
                                    $("#color").addClass('is-invalid');
                                }

                                if (response["price"] != "") {
                                    $(".priceError").html(response["price"]);
                                    $("#price").addClass('is-invalid');
                                }
                            } else {

                                $("#createCar").modal("hide");
                                $(".modal-body").html(response["message"]);
                                $("#ajaxResponseModal").modal("show");

                                $(".nameError").html(" ").removeclass('invalid-feedback d-block');
                                $("#name").removeClass('is-invalid');

                                $(".colorError").html(" ").removeclass('invalid-feedback d-block');
                                $("#color").removeClass('is-invalid');

                                $(".priceError").html(" ").removeclass('invalid-feedback d-block');
                                $("#price").removeClass('is-invalid');

                                $("carModelList").append(response["row"]);

                            }

                        }
                    });
                });

                function showEditForm(id) {
                    $("#createCar .modal-title").html('edit');
                    var base_url = '<?php echo base_url() . 'index.php/' ?>';
                    $.ajax({
                        url: base_url + 'CarModel/getCarModel',
                        type: 'POST',
                        data: {
                            'id': id
                        },
                        dataType: 'json',
                        success: function(response) {
                            $("#createCar").modal('show');
                            $("#response").html(response);


                        }
                    });
                }

                // editcarmodel

                $("body").on("submit", "#editCarModel", function(e) {
                    e.preventDefault();
                    var base_url = '<?php echo base_url() . 'index.php/' ?>';
                    $.ajax({
                        url: base_url + 'carModel/updateModel',
                        type: 'POST',
                        data: $(this).serializeArray(),
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response['status'] == 0) {
                                if (response["name"] != "") {
                                    console.log(response["name"] != "");
                                    $(".nameError").append(response["name"]);
                                    $("#name").addClass('is-invalid');
                                }
                                if (response["price"] != "") {
                                    $(".priceError").append(response["price"]);
                                    $("#price").addClass('is-invalid');
                                }

                                if (response["color"] != "") {
                                    $(".colorError").append(response["color"]);
                                    $("#color").addClass('is-invalid');
                                }
                            } else {

                                $("#createCar").modal("hide");
                                $(".modal-body").append(response["message"]);
                                $("#ajaxResponseModal").modal("show");

                                $(".nameError").append(" ").removeclass('invalid-feedback d-block');
                                $("#name").removeClass('is-invalid');

                                $(".priceError").append(" ").removeclass('invalid-feedback d-block');
                                $("#price").removeClass('is-invalid');

                                $(".colorError").append(" ").removeclass('invalid-feedback d-block');
                                $("#color").removeClass('is-invalid');

                                var id = response["row"]["id"];
                                $("#row-" + id + ".modelName").html(response["row"]["name"])
                                $("#row-" + id + ".modelColor").html(response["row"]["color"])
                                $("#row-" + id + ".modelPrice").html(response["row"]["price"])
                                $("#row-" + id + ".modelTransmission").html(response["row"]["transmission"])



                            }

                        }
                    });
                });

                function confirmDeleteModel(id) {
                    $("#deleteModal").modal("show");
                    $("#deleteModal .modal-body").html("Are you sure you want to delete" + id + "?");
                    $("#deleteModal").data("id", id);
                }

                function deleteNow(){
                    var id = $("#deleteModal").data('id');
                    var base_url = '<?php echo base_url() . 'index.php/' ?>';

                    $.ajax({
                        url: base_url + 'carModel/deleteModel/'+id,
                        type: 'POST',
                        data: $(this).serializeArray(),
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response['status'] == 1) {
                                $("#deleteModal").modal("show");
                                $(".modal-body").append(response["msg"]);
                                $("#ajaxResponseModal").modal("show");
                                
                            } else {
                                $("#deleteModal").modal("hide");
                                $(".modal-body").append(response["msg"]);
                                $("#ajaxResponseModal").modal("show");
                                
                            }
                        }
                    }); 
                }
            </script>


</body>

</html>
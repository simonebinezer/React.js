<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
  .customerlistpg {
    background: #fff;
    padding: 20px 15px 50px;
  }

  .table-striped>tbody>tr:nth-of-type(odd)>* {
    --bs-table-color-type: var(--bs-table-striped-color);
    --bs-table-bg-type: #fff;
  }

  .table-bordered>:not(caption)>*>* {
    border-width: 0;
    /* text-align: center; */
    border-bottom: 1px solid #EBF3FC;
  }

  .home .table thead tr th {
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
  }

  .home .table tbody tr td {
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    /* line-height: normal; */
  }

  .home .table tbody tr td .edit {
    padding: 0px;
  }

  .home .table tbody tr td .delete {
    padding: 0px;
  }

  .customerlistpg .add {
    background: #0A2472;
    padding: 5px 20px;
    border-radius: 15px;
  }

  .btn-success,
  .btn-success:hover,
  .btn-success:active,
  .btn-success::after {
    background: #0A2472 !important;
    padding: 5px 20px;
    border-radius: 15px;
  }

  #uploadForm .csv {
    background: none;
    padding: 5px 20px;
    border-radius: 15px;
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    border: 1px solid #0A2472;
  }

  .upload-download {
    display: flex;
    justify-content: space-between;
  }

  .page-link {
    margin: 0px 5px !important;
    border-radius: 50px;
    border: 1px solid #092C4C;
    height: 30px;
    color: #092C4C;
    font-size: 12px;
    width: 30px;
  }

  .active>.page-link,
  .page-link.active,
  .page-link:hover,
  .page-link:active {
    background: #092C4C;
    color: #fff;
  }

  .page-item:first-child .page-link {
    margin: 0px 5px !important;
    border-radius: 50px;
    height: 30px;
    width: 30px;
    padding: 5px 12px;
  }

  .page-item:last-child .page-link {
    margin: 0px 5px !important;
    border-radius: 50px;
    height: 30px;
    width: 30px;
    padding: 6px 12px;
  }
  
.home .table tbody tr td .send-email {
    padding: 0px;
}
</style>
<section class="home">
  <div class="container">

    <!-- Breadcrumbs-->
    <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
    <!-- Page Content -->
    <h1>Customer Details</h1>
    <!-- <hr> -->

    <div class="customerlistpg">

      <button type="button" class="btn btn-success add pull-right mb-3" data-bs-toggle="modal"
        data-bs-target="#AddModal" id="AddCustomer"><span class="glyphicon glyphicon-plus">Add
          Customer</span></button>
      <br />
      <?php if (!empty($userslist)) { ?>

        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">SNo 
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
                </th>
              <th scope="col">Name 
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
                </th>
              <th scope="col">Email Id 
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
                </th>
              <th scope="col">Contact No 
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
                </th>
              <th colspan="3" class="pull-centre" scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($userslist as $userdata) { ?>
              <tr id="row">
                <td scope="row">
                  <?php echo $userdata['id']; ?>
                </td>
                <td>
                  <?php echo $userdata['firstname'] . " " . $userdata['lastname']; ?>
                </td>
                <td>
                  <?php echo $userdata['email_id']; ?>
                </td>
                <td>
                  <?php echo $userdata['contact_details']; ?>
                </td>
                <td><button type="button" class="btn btn-default edit" data-bs-toggle="modal" data-bs-target="#EditModal"
                    id="EditCustomer"><img src="<?php echo base_url(); ?>images/icons/Create.png"
                      class="img-centered img-fluid"></button></td>

                <td><button type="button" class="btn btn-default delete" data-bs-toggle="modal"
                    data-bs-target="#DeleteModal" id="DeleteCustomer"><img
                      src="<?php echo base_url(); ?>images/icons/Remove.png" class="img-centered img-fluid"></button></td>

                <td>
                  <form action="<?= base_url('sendEmail') ?>" method="post" >
                  <input type="hidden" name="email_id" value="<?php echo $userdata['email_id']; ?>">
                  <button type="submit" class="btn btn-default send-email" action=""
                    id="send-email"><img src="<?php echo base_url(); ?>images/icons/Send-Email.png"
                      class="img-centered img-fluid"></button>
                  </form></td>
              </tr>
            <?php } ?>
          </tbody>

        </table>
        <form id="uploadForm">
          <div class="upload-download mb-5">
            <div>
              <!-- <label for="uploadfile" class="btn btn-success csv"> Download <img
                  src="<?php echo base_url(); ?>images/icons/download.png" class="img-centered img-fluid"></label>
              <input type="file" class="btn btn-success upload" name="formData" style="display: none;" id="uploadfile"> -->
            </div>
            <div>
              <label for="uploadfile" class="btn  csv"> Upload csv <img
                  src="<?php echo base_url(); ?>images/icons/upload.png" class="img-centered img-fluid"></label>
              <input type="file" class="btn btn-success upload" name="formData" style="display: none;" id="uploadfile">
            </div>
          </div>
        </form>
        <!-- <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <li class="page-item disabled">
              <a class="page-link">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#">6</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav> -->
      <?php } else { ?>
        <div class="text-center">
          <p class="fs-3"> <span class="text-danger">Oops!</span>No records found.</p>
        </div>
      <?php } ?>
    </div>
  </div>
</section>


<!-- Modal -->
<!-- <style>
  .modal-header,
  h4,
  .modal-header .close {
    background-color: #0a2472;
    color: white !important;
    text-align: center;
    font-size: 35px;
    border: 0px;
  }

  .modal-footer {
    background-color: #f9f9f9;
  }

  .btn-danger {
    width: 100%;
    margin: 0px auto 15px;
  }
</style> -->
<!-- #region --><!-- ADD MODAL -->
<div class="container">


  <div class="modal fade" id="AddModal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:37px 0px 20px">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4> Add Customer</h4>
        </div>
        <div class="modal-body gap-3" style="padding:10px 50px 20px;">
          <form role="form" action="<?= base_url('AddCustomer') ?>" method="post" id="Add_form">

            <div class="form-group">
              <label for="first_name"><span class="glyphicon glyphicon fa fa-user"></span> First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="V1">
                  <?= $validation->showError('first_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="last_name"><span class="glyphicon glyphicon fa fa-user"></span> Last name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last name">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="V2">
                  <?= $validation->showError('last_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="email"><span class="glyphicon glyphicon fa fa-envelope"></span> Email Id</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="V3">
                  <?= $validation->showError('email') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="contact"><span class="glyphicon glyphicon fa fa-phone"></span> Contact</label>
              <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="V4">
                  <?= $validation->showError('contact') ?>
                </div>
              <?php endif; ?>
            </div>
            <br />
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-block save"><span
                  class="glyphicon glyphicon fa fa-plus"></span> Add</button>
            </div>
          </form>
        </div>
        <div class="d-grid" style="padding:0px 50px 30px">
          <button type="submit" class="btn btn-danger btn-default pull-right" id="close" data-bs-dismiss="modal"><span
              class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- #endregion -->

<!-- #region --><!-- EDIT MODAL -->
<div class="container">


  <div class="modal fade" id="EditModal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:37px 0px 20px;">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4> Edit Customer</h4>
        </div>
        <div class="modal-body" style="padding:10px 50px 20px;">
          <form action="<?= base_url('EditCustomer') ?>" method="post">

            <div class="form-group">
              <label for="E_first_name"><span class="glyphicon glyphicon fa fa-user"></span> First Name</label>
              <input type="text" class="form-control" id="E_first_name" name="first_name"
                value="<?php echo set_value('E_first_name'); ?>" placeholder="Enter First name">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="E1">
                  <?= $validation->showError('first_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="E_last_name"><span class="glyphicon glyphicon fa fa-user"></span> Last Name</label>
              <input type="text" class="form-control" id="E_last_name" name="last_name"
                value="<?php echo set_value('E_last_name'); ?>" placeholder="Enter Last name">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="E2">
                  <?= $validation->showError('last_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="E_email"><span class="glyphicon glyphicon fa fa-envelope"></span> Email Id</label>
              <input type="text" class="form-control" id="E_email" name="email"
                value="<?php echo set_value('E_email'); ?>" placeholder="Enter Email">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="E3">
                  <?= $validation->showError('email') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="E_contact"><span class="glyphicon glyphicon fa fa-phone"></span> Contact</label>
              <input type="text" class="form-control" id="E_contact" name="contact"
                value="<?php echo set_value('E_contact'); ?>" placeholder="Enter Contact">
              <?php if (isset($validation)): ?>
                <div style="color:red" id="E4">
                  <?= $validation->showError('contact') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" id="E_Id" name="E_Id" value="<?php echo set_value('E_Id'); ?>"
                placeholder="Enter Contact">
            </div>
            <br />
            <div class="d-grid">
              <button type="submit" class="btn btn-primary save"><span class="glyphicon glyphicon-plus"></span>
                Save</button>
            </div>
          </form>
        </div>
        <div class="d-grid" style="padding:0px 50px 30px">
          <button type="submit" class="btn btn-danger btn-default pull-right" id="E_close" data-bs-dismiss="modal"><span
              class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- #endregion -->


<!-- #region --><!-- DELETE MODAL -->
<div class="container">


  <div class="modal fade" id="DeleteModal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:15px 50px;">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4> Delete Customer</h4>
        </div>
        <form action="<?= base_url('DeleteCustomer') ?>" method="post">
          <div class="modal-body" style="padding:40px 50px 20px;">
            <p> Are you sure you want to remove the customer from the customer list?</p>
            <div class="form-group">
              <input type="hidden" class="form-control" id="Id" name="Id" value="<?php echo set_value('E_Id'); ?>"
                placeholder="Enter Contact">
            </div>
            <br />
            <div class="d-grid">
              <button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-trash"></span>
                Confirm</button>
              <button type="button" class="btn btn-outline-secondary Cancel pull-left" data-bs-dismiss="modal"><span
                  class="fa fa-remove"></span> Cancel</button>
            </div>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>
<!-- #endregion -->

<?php if (isset($Function)): ?>
  <?php if ($Function == "ADD"): ?>
    <!-- #region --><!-- ADD MODAL Script -->
    <script>
      $(document).ready(function () {
        $('#AddModal').modal('show')
        var a = <?php echo ($Data); ?>;
        //console.log(a.E_Id);
        $('#first_name').val(a.first_name);
        $('#last_name').val(a.last_name);
        $('#email').val(a.email);
        $('#contact').val(a.contact);
      });
    </script>
  <?php elseif ($Function == "EDIT"): ?>
    <script>
      $(document).ready(function () {
        $('#EditModal').modal('show')
        var a = <?php echo ($Data); ?>;
        $('#E_Id').val(a.E_Id);
        $('#E_first_name').val(a.first_name);
        $('#E_last_name').val(a.last_name);
        $('#E_email').val(a.email);
        $('#E_contact').val(a.contact);

      });
    </script>
  <?php endif; ?>
<?php endif; ?>


<script>
  //Edit modal 
  $(document).ready(function () {
    $('.edit').on('click', function () {
      $("#EditModal").modal('show');
      //getting data of selected row using id.
      $id = document.getElementById('row');
      $tr = $(this).closest('tr');
      var data = $tr.children().map(function () {
        return $(this).text();
      }).get();
      console.log(data);
      //splitting the name
      var nameArray = data[1].trim().split(" ");
      // getting the value of the input fields and assign it to form values.
      $('#E_Id').val(data[0].trim());
      $('#E_first_name').val(nameArray[0]);
      $('#E_last_name').val(nameArray[1]);
      $('#E_email').val(data[2].trim());
      $('#E_contact').val(data[3].trim());


    });

    //delete modal 
    $('.delete').on('click', function () {
      $("#DeleteModal").modal('show');
      $id = document.getElementById('row');
      $tr = $(this).closest('tr');
      var data = $tr.children().map(function () {
        return $(this).text();
      }).get();
      console.log(data);
      //splitting the name
      var nameArray = data[1].split(" ");
      // getting the value of the input field and assign it to form value.
      $('#Id').val(data[0].trim());
    });

    //remove validation messages
    $("#close").on('click', function () {
      $('#Add_form').trigger("reset");
      removeValidation("V");
      removeValidation("E");
    });

    $("#E_close").on('click', function () {
      removeValidation("E");
      removeValidation("V");
    });

    function removeValidation(param) {
      var id = param;
      for (let index = 1; index <= 4; index++) {
        console.log(index);
        var final_Id = id + index;
        console.log(final_Id);
        var element = document.getElementById(final_Id);
        console.log(element);
        element.parentNode.removeChild(element);
      }
    }

    window.onload = function () {
      history.replaceState("", "", "/getCustomerData");
    }
    $(document).on('change', 'input[type="file"]', function () {
      // console.log(file1);
      var file = null;
      var file = $('#uploadfile').prop('files')[0];
      console.log(file);

      var formData = new FormData();
      formData.append('formData', file);
      console.log(formData);
      $.ajax({
        url: '<?php echo base_url('UploadFileCustomer'); ?>',
        type: 'post',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response.success) {
            console.log(response);
            if (response.count > 0) {
              if (!alert(response.count + " customer's details uploaded successfully!")) {
                window.location.reload();
              }
            } else {
              alert(" file contains no data or the customer's email is already present")
            }

          } else {
            console.log(response);
            alert("ERROR: " + response.validation['formData'])
            $('#uploadForm').trigger("reset");
          }
        },
        error: function (response) {
          console.log(response);
        }
      });
    });
  });
</script>

<?= $this->endSection() ?>
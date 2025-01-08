<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<style>
  .edit-sur {
    background: none !important;
    border: 1px solid #092c4c;
  }

  .edit-sur:hover {
    background: #00000017 !important;
    border: 1px solid #092c4c;
  }

  .del-sur {
    background: none !important;
    border: 1px solid #092c4c;
  }

  .del-sur:hover {
    background: #00000017 !important;
    border: 1px solid #092c4c;
  }

  .table-striped>tbody>tr:nth-of-type(odd)>* {
    --bs-table-color-type: none;
    --bs-table-bg-type: none;
  }

  .sur-lis-bd {
    border-width: 0px !important;
  }

  .sur-lis-bd td {
    border-width: 0px 0px 1px 0px !important;
    padding: 20px 30px;
    border-bottom: 1px solid #cae3ff;
    background: none;
  }

  .sur-lis-bd th {
    border-width: 0px 0px 1px 0px !important;
    padding: 20px 30px;
    border-bottom: 1px solid #cae3ff;
    background: none;
  }

  .table-bordered {
    padding: 20px;
    background: #fff;
    border-radius: 20px;
  }

  .crt-sur {
    border-radius: 5px;
    background: #092C4C;
    border: 0px;
  }

  .crt-sur:hover {
    border-radius: 5px;
    background: #092C4C;
    border: 1px solid #092C4C;
  }
</style>
<section class="home">
  <div class="container">
    <!-- Breadcrumbs-->
    <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
    <!-- Page Content -->
    <!-- <h1>Survey List</h1>
    <hr> -->

    <?php if (session()->getFlashdata('response') !== NULL) : ?>
      <p style="color:green; font-size:18px;" align="center">
        <?php echo session()->getFlashdata('response'); ?>
      </p>
    <?php endif; ?>
    <div class="row ">
      <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="mb-5">
          <h1>Survey Management</h1>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="text-center mb-5"><a class="btn btn-primary crt-sur float-end" href="<?php echo site_url('createSurvey'); ?>">Create Survey</a>
        </div>
      </div>
    </div>

    <?php if (!empty($surveyList)) { ?>
      <table class="table mt-6 table-striped table-bordered">
        <thead>
          <tr class="sur-lis-bd">
            <th scope="col">S.No</th>
            <th scope="col">Campaign Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $count=0;foreach ($surveyList as $surveyData) { $count++;?>
            <tr class="sur-lis-bd">
              <td scope="row">
                <?php echo $count; ?>
              </td>
              <td>
                <?php echo stripslashes($surveyData['campaign_name']); ?>
                <?php if ($surveyData['sent_status'] == 0) { ?><p style="color: red;font-size: 12px;">* This survey is already in progress you cannot edit.</p><?php } ?>
              </td>
              <td>
                  <a class="btn btn-primary edit-sur" href="<?php echo site_url('editsurvey/' . $surveyData['campaign_id']); ?>" <?php if ($surveyData['sent_status'] == 0) { ?>style="pointer-events: none;"<?php } ?>> <img src="<?php echo base_url(); ?>images/icons/Create.png" class="img-centered img-fluid"></a>
                  <!-- <a class="btn btn-primary del-sur" id="<?= $surveyData['campaign_id']; ?>" href="<?php echo site_url('deletesurvey/' . $surveyData['campaign_id']); ?>" > <img src="<?php echo base_url(); ?>images/icons/Remove.png" class="img-centered img-fluid"></a> -->
              <button class="btn btn-primary del-sur" type="button" onclick="showModal(<?= $surveyData['campaign_id']; ?>)"><img src="<?php echo base_url(); ?>images/icons/Remove.png"></button>
                </td>

            </tr>

          <?php } ?>
        </tbody>

      </table>
    <?php } else { ?>
      <div class="text-center">
        <p class="fs-3"> <span class="text-danger">Oops!</span>No records found.</p>
      </div>
    <?php } ?>
  </div>


  <!-- #region --><!-- DELETE MODAL -->
<div class="container">


<div class="modal fade" id="DeleteModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:15px 50px;">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        <h4> Delete Survey</h4>
      </div>
      <form id="deleteForm"action="" method="post">
        <div class="modal-body" style="padding:40px 50px 20px;">
          <p> Are you sure you want to delete the survey ?</p>
          <div class="form-group">
            <input type="hidden" class="form-control" id="Id" name="Id">
          </div>
          <br />
          <div class="d-grid">
            <button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-trash"></span>
              Confirm</button>
            <button type="button" class="btn btn-outline-secondary Cancel pull-left" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
          </div>
        </div>
      </form>


    </div>
  </div>
</div>
</div>
<!-- #endregion -->
</section>
<script>
  
//delete modal 
function showModal(param){
     console.log("entry");
      
      $('#Id').val(param);
      var action="<?= site_url('deletesurvey/') ?>"+param;
      console.log("action",action);
      $("#deleteForm").attr("action", action);
      $("#DeleteModal").modal('show');

  };
  </script>
<?= $this->endSection() ?>
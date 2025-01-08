<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>

<section class="home">
  <div class="container">
    <!-- Breadcrumbs-->
    <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?>
    <!-- Page Content -->
    <h1>Reports Details</h1>
    <hr>
    <?php if (session()->get('tenant_id') == 1) { ?>
      <div class="col-xl-8 col-lg-8 col-md-8"></div>
      <div class="col-xl-4 col-lg-4 col-md-4 float-right">
        <select class="custom-select form-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="tenant" id="tenantchange">
          <?php foreach ($getdashData['getTenantdata'] as $getTenantlist) { ?>
            <option value="<?php echo $getTenantlist['tenant_id']; ?>" <?php if ($getdashData['selectTenant'] == $getTenantlist['tenant_id']) : ?>selected="selected" <?php endif; ?>>
              <?php echo $getTenantlist['tenant_name']; ?>
            </option>
          <?php } ?>
        </select>
      </div>
    <?php } ?>

    <?php if (session()->getFlashdata('response') !== NULL) : ?>
      <p style="color:green; font-size:18px;" align="center">
        <?php echo session()->getFlashdata('response'); ?>
      </p>
    <?php endif; ?>
    <style>
      .sur-reports {
        background: #fff;
        padding: 20px;
      }

      .table-bordered>:not(caption)>*>* {
        border: 1px solid #fff;
        border-bottom: 2px solid #EBF3FC;
      }

      .btn-primary {
        background: none;
        border: 0px;
        padding: 0px;
      }

      .btn-primary:hover {
        background: none;
        border: 0px;
        padding: 0px;
      }

      .btn-primary img {}

      .table-striped>tbody>tr:nth-of-type(odd)>* {
        background: #fff;
        --bs-table-striped-bg: #fff;
      }
    </style>
    <div clas="sur-reports" style="background: #fff;
    padding: 20px;
    margin: 20px 0px;
    border-radius: 20px;">
      <table class="table table-striped table-bordered mt-4">
        <?php $tenantId = isset($_GET["tenantId"]) ? $_GET["tenantId"] : '1';
        $status = "no";
        $check = 'no';
        ?>
        <tbody>
          <tr>
            <td scope="row">NPS Reports for the year of
              <?php echo date("Y"); ?>
            </td>
            <td><a class="btn btn-primary" href="<?php echo site_url('pdfGenerateCurrentYr/' . $status . '/' . $check); ?>" alt="Generate PDF"> <img src="<?php echo base_url(); ?>images/icons/pdf.png" class="img-centered img-fluid"></a>
            </td>
          </tr>
          <tr>
            <td scope="row">NPS Reports for Customer review Options</td>
            <td><a class="btn btn-primary" href="<?php echo site_url('pdfGenerateCurrentYr/' . $status . '/' . $check); ?>" alt="Generate PDF"> <img src="<?php echo base_url(); ?>images/icons/pdf.png" class="img-centered img-fluid"></a>
            </td>
          </tr>
          <?php $status = "high"; ?>

          <tr>
            <td scope="row">Highest Rate of NPS Reports</td>
            <td><a class="btn btn-primary" href="<?php echo site_url('pdfGenerateCurrentYr/' . $status . '/' . $check); ?>" alt="Generate PDF"> <img src="<?php echo base_url(); ?>images/icons/pdf.png" class="img-centered img-fluid"></a>
            </td>
          </tr>
          <?php $status = "low"; ?>

          <tr>
            <td scope="row">Lowest Rate of NPS Reports</td>
            <td><a class="btn btn-primary" href="<?php echo site_url('pdfGenerateCurrentYr/' . $status . '/' . $check); ?>" alt="Generate PDF"> <img src="<?php echo base_url(); ?>images/icons/pdf.png" class="img-centered img-fluid"></a>
            </td>
          </tr>
          <?php $status = "no";
          $check = "yes"; ?>

          <tr>
            <td scope="row">NPS Reports for the year 2020 -
              <?php echo date("Y"); ?>
            </td>
            <td><a class="btn btn-primary" href="<?php echo site_url('pdfGenerateCurrentYr/' . $status . '/' . $check); ?>" alt="Generate PDF"> <img src="<?php echo base_url(); ?>images/icons/pdf.png" class="img-centered img-fluid"></a>
            </td>
          </tr>
        </tbody>

      </table>
    </div>
  </div>
</section>
<script type="text/javascript">
  $("#tenantchange").change(function() {
    var t_id = $(this).val();
    var newUrl = '';
    var currLoc = $(location).attr('href');
    var hashes = window.location.href.indexOf("?");
    if (hashes == -1) {
      var currentUrl = window.location.href + "?tenantId=" + t_id;
      var urls = new URL(currentUrl);
      newUrl = urls.href;
    } else {
      var currentUrl = window.location.href;
      var urls = new URL(currentUrl);
      urls.searchParams.set("tenantId", t_id); // setting your param
      newUrl = urls.href;
    }
    window.location.href = newUrl;
  });
</script>
<?= $this->endSection() ?>
<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<style>
    .flo-r {
        float: right;
    }

    .new-survey-report {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
    }

    .response-head {
        display: flex;
        justify-content: space-between;
    }

    .response-head h6 {
        color: #092C4C;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .border-bottom-response {
        border-bottom: 2px solid #EBF3FC;
    }

    .response-titles {
        display: flex;
        justify-content: space-between;
    }

    .response-content-row {
        color: #092C4C;
        font-family: 'Inter', sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .response-content-row-sub {
        border-radius: 73px;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        padding: 5px 10px;
        width: 30px;
        background-color: #092C4C;
        height: 30px;
    }

    .response-titles-content p {
        float: right;
        font-size: 12px;
        line-height: 28px;
        padding-left: 2px;
        margin: 0px;
    }

    .response-titles-content {
        padding: 0px 15px;
    }

    .response-content .dropdown button {
        border-radius: 5px;
        padding: 7px 25px;
        border: 1px solid #092C4C;
        color: #000;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        background: #FFF;

    }

    .page-link {
        border: 1px solid #092C4C;
        border-radius: 65px;
        margin: 10px;
        width: 36px;
        height: 36px;
        color: #000;
    }

    .page-item:first-child .page-link {
        border-top-left-radius: 85px;
        border-bottom-left-radius: 85px;
        border-top-right-radius: 85px;
        border-bottom-right-radius: 85px;
        width: 36px;
        height: 36px;
        padding: 5px 15px;
    }

    .page-item:last-child .page-link {
        border-top-left-radius: 85px;
        border-bottom-left-radius: 85px;
        border-top-right-radius: 85px;
        border-bottom-right-radius: 85px;
        width: 36px;
        height: 36px;
        /* padding: 5px 15px; */
    }

    .page-link:hover {
        z-index: 2;
        color: #fff;
        background-color: #092C4C;
        border-color: #092C4C;
    }

    sup {
        color: #DA2C33;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    #submit {
        background: #0a2472;
        border: 0px;
    }
</style>
<section class="home">
    <div class="container">
        <!-- Breadcrumbs-->
        <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8">
                <h2 class="crt-survey-h2 mb-5">View Survey Response</h2>
            </div>
            <?php if (session()->get('tenant_id') == 1) { ?>
                <div class="col-xl-4 col-lg-4 col-md-4 float-right">
                    <select class="custom-select form-select custom-select-sm" class="custom-select custom-select-sm"
                        aria-label="Default select example" name="tenant" id="tenantchange">
                        <?php foreach ($getTenantdata as $getTenantlist) { ?>
                            <option value="<?php echo $getTenantlist['tenant_id']; ?>" <?php if ($selectTenant == $getTenantlist['tenant_id']): ?>selected="selected" <?php endif; ?>>
                                <?php echo $getTenantlist['tenant_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
        <?php if (!empty($getsurveylist)) {
            $basesurvey = (isset($_GET['tenantId'])) ? base_url('SurveyResponse?tenantId=' . $_GET['tenantId']) : base_url('SurveyResponse'); ?>
            <form class="form-horizontal" action="<?= $basesurvey; ?>" method="post">

                <div class="row mb-4">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <select class="custom-select form-select custom-select-sm"
                                    class="custom-select custom-select-sm" aria-label="Default select example"
                                    name="surveyid">
                                    <?php foreach ($getsurveylist as $getsurveys) { ?>
                                        <option value="<?php echo $getsurveys['campaign_id']; ?>" <?php if ($getsurveys['campaign_id'] == $selectsurvey) { ?> selected="selected" <?php } ?>>
                                            <?php echo $getsurveys['campaign_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block"
                                    value="Filter" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="new-survey-report">
                <div class="response-head">
                    <h6></h6>
                    <h6 class="flo-r">Download the Excel &nbsp;<img
                            src="<?php echo base_url(); ?>images\icons\response/download-pie.png"
                            class="img-centered img-fluid">
                    </h6>
                </div>


                <?php if (!empty($getSurveyData)) {
                    foreach ($getSurveyData as $getSurveylist) {
                        $timestamp = strtotime($getSurveylist["created_at"]); ?>
                        <div class="response-content border-bottom-response p-4">
                            <div class="row mb-4">
                                <!-- <div class="col-md-1">
                                    <div class="mt-3">
                                        <p class="response-content-row">Completed</p>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <div class="response-titles">
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/time.png"
                                                class="img-centered img-fluid">
                                            <p>Time:<span>
                                                    <?php echo date("h:m:s", $timestamp); ?>
                                                </span></p>
                                        </div>
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Calendar.png"
                                                class="img-centered img-fluid">
                                            <p>
                                                <?php echo date("l,m d,Y", $timestamp); ?>
                                            </p>
                                        </div>
                                        <!-- <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Laptop.png"
                                                class="img-centered img-fluid">
                                            <p>Device Type:<span>Laptop</span></p>
                                        </div> -->
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Location.png"
                                                class="img-centered img-fluid">
                                            <p>Location:<span>
                                                    <?php echo $getSurveylist["location"] ? $getSurveylist["location"] : ""; ?>
                                                </span></p>
                                        </div>
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Phone.png"
                                                class="img-centered img-fluid">
                                            <p>Phone Number:<span>
                                                    <?php echo isset($getSurveylist['userdata']) ? $getSurveylist['userdata']['contact_details'] : ""; ?>
                                                </span></p>
                                        </div>

                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Delivery-time.png"
                                                class="img-centered img-fluid">
                                            <p>Time Interval:<span>
                                                    <?php echo $getSurveylist["timeInterval"]->format('%H:%I:%S'); ?>
                                                </span></p>
                                        </div>
                                    </div>
                                    <div class="response-titles">
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Email.png"
                                                class="img-centered img-fluid">
                                            <p>Email:<span>
                                                    <?php echo isset($getSurveylist['userdata']) ? $getSurveylist['userdata']['email_id'] : ''; ?>
                                                </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <!-- <div class="col-md-1">
                                    <div class="">
                                        <p class="response-content-row-sub">1</p>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <div class="response-titles" style="justify-content: space-between;">
                                        <div class="response-titles-content">

                                            <p>
                                                <?php echo $getSurveylist["questiondata"][0] ? $getSurveylist["questiondata"][0]['question_name'] : ""; ?><sup>Main
                                                    Metric</sup>
                                            </p>
                                        </div>
                                        <div class="response-titles-content" style="text-align:right;width:360px;">
                                            <p>
                                                <?php echo $getSurveylist["answer_id1"]; ?>
                                            </p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-1">
                                    <div class="">
                                        <p class="response-content-row-sub">2</p>
                                    </div>
                                </div> -->
                                <div class="col-md-12">

                                    <div class="response-titles" style="justify-content: space-between;">
                                        <div class="response-titles-content">

                                            <p>
                                                <?php echo $getSurveylist["questiondata"][1] ? $getSurveylist["questiondata"][1]['question_name'] : ""; ?>
                                            </p>
                                        </div>
                                        <div class="response-titles-content" style="text-align:right;width:360px;">
                                            <p>
                                                <?php echo $getSurveylist["answer_id2"]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="text-center">
                        <p class="fs-3"> <span class="text-danger">Oops!</span>There is no record for this survey.</p>
                    </div>
                <?php } ?>

            </div>


            <!-- 
            <table class="table mt-6 table-striped table-bordered">
                <tbody>
                    <?php if (!empty($getSurveyData)) {
                        foreach ($getSurveyData as $getSurveylist) {
                            $timestamp = strtotime($getSurveylist["created_at"]);
                            ?>
                            <tr>
                                <td scope="row">
                                    <div class="d-flex flex-column">
                                        <div class="p-2 bd-highlight">
                                            <p>Completed</p>
                                        </div>
                                        <div class="p-2 bd-highlight"> <span class="rounded-circle">1</span></div>
                                        <div class="p-2 bd-highlight"> <span class="rounded-circle">2</span></div>
                                    </div>
                                </td>
                                <td scope="row">
                                    <div class="d-flex flex-column">
                                        <div class="p-2 bd-highlight container">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-2 col-md-2"> <i class="bi bi-clock"></i>
                                                    <?php echo date("h:m:s", $timestamp); ?>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4"> <i class="bi bi-calendar"></i>
                                                    <?php echo date("l,m d,Y", $timestamp); ?>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4"> <i class="bi bi-telephone"></i>
                                                    <?php echo isset($getSurveylist['userdata']) ? $getSurveylist['userdata']['contact_details'] : ""; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 bd-highlight"> <span>
                                                <?php echo $getSurveylist["questiondata"][0] ? $getSurveylist["questiondata"][0]['question_name'] : ""; ?>
                                            </span></div>
                                        <div class="p-2 bd-highlight"> <span>
                                                <?php echo $getSurveylist["questiondata"][1] ? $getSurveylist["questiondata"][1]['question_name'] : " "; ?>
                                            </span></div>
                                    </div>
                                </td>
                                <td scope="row">
                                    <div class="d-flex flex-column">
                                        <div class="p-2 bd-highlight container">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12"> <i class="bi bi-envelope"></i>
                                                    <?php echo isset($getSurveylist['userdata']) ? $getSurveylist['userdata']['email_id'] : ''; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 bd-highlight"> <span>
                                                <?php echo $getSurveylist["answer_id1"]; ?>
                                            </span></div>
                                        <div class="p-2 bd-highlight"> <span>
                                                <?php echo $getSurveylist["answer_id2"]; ?>
                                            </span></div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <div class="text-center">
                            <p class="fs-3"> <span class="text-danger">Oops!</span>There is no record for this survey.
                            </p>
                        </div>
                    <?php } ?>
                </tbody>
            </table> -->
        </form>
    </div>
</section>
<script type="text/javascript">
    $("#tenantchange").change(function () {
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
<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>

<?php echo script_tag('js/jquery.min.js'); ?>

<?php echo script_tag('js/editor/jquery-3.6.0.min.js'); ?>
<?php echo script_tag('js/tinymce/tinymce.min.js'); ?>
<?php echo script_tag('js/editor/tinymce-jquery.min.js'); ?>
<style>
  ul li:hover {
    cursor: pointer;
    background-color: royalblue;
  }

  .form-row .control-label {
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: 600;
    line-height: 20px;
    padding: 6px 0px;
    /* 168.75% */
  }


  .file-drop-area {
    position: relative;
    display: flex;
    align-items: center;
    width: 450px;
    max-width: 100%;
    padding: 25px;
    border: 1px dashed rgb(0 0 0 / 40%);
    border-radius: 3px;
    transition: 0.2s;
    justify-content: center;
  }

  .choose-file-button {
    flex-shrink: 0;
    background-color: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 3px;
    padding: 8px 15px;
    margin-right: 10px;
    font-size: 12px;
    text-transform: uppercase;
  }

  .file-message {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #0A2472;
    text-align: center;
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  .file-message .browse {
    color: #0A2472;
    text-align: center;
    font-family: 'Inter', sans-serif;
    font-size: 8px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    text-decoration: underline;
  }

  .file-input {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    cursor: pointer;
    opacity: 0;

  }

  #dynamic_field .send-cam .form-group .form-row input {
    border-radius: 5px;
    background: #EBF3FC;
  }

  #dynamic_field .send-cam .form-group .form-row select {
    border-radius: 5px;
    /* background: #EBF3FC; */
  }

  #dynamic_field .send-cam .form-group .form-row input::placeholder {
    color: #868686;
    font-size: 12px;
    opacity: 1;
    /* Firefox */
  }

  .search-input::placeholder {
    color: #868686;
    font-size: 12px;
    opacity: 1;
  }

  .backgrd {
    background: #FFFFFF;
    border-right: 1px solid #EBF3FC;
    border-radius: 15px 0px 0px 15px;
  }

  .backgrd-1 {
    background: #FFFFFF;
    border-right: 1px solid #EBF3FC;
    border-radius: 0px 15px 15px 0px;
  }

  .snd-mail {
    border-radius: 50px !important;
    background: #0A2472 !important;
    padding: 5px 20px;
    float: right;
    border: 0px;
  }

  .prw-mail {
    border-radius: 50px !important;
    background: #868686 !important;
    padding: 5px 20px;
    border: 0px;
    color: #fff;
    float: left;
  }

  /* Style the container */
  .search-container {
    /* position: relative; */
    margin: 20px 0px;

  }

  /* Style the input field */
  .search-input {
    padding: 3px 10px;
    padding-right: 40px;
    /* Space for the search icon */
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 200px;
    color: #4B4A4C;
    border-radius: 19px;
    background: #EBF3FC;
  }

  /* Style the search icon */
  .search-icon {
    position: absolute;
    top: 34%;
    left: 200px;
    transform: translateY(-50%);
    cursor: pointer;
    background: url()
  }

  .head-content {
    display: flex;
    justify-content: space-between;
  }

  .contact-list {

    color: #092C4C;

    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 27px;
    /* 168.75% */
  }

  .label {
    color: #092C4C;

    font-family: 'Inter', sans-serif;
    font-size: 14px;
  }

  .customer-list-det {
    display: flex;
    justify-content: space-between;
  }

  .customer-list-det p {
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    margin: 10px 0px;
  }

  #dynamic_field .send-cam .form-group .form-row .form-select {
    background-color: #EBF3FC !important;
  }

  /* width */
  .card ::-webkit-scrollbar {
    width: 4px;
    border-radius: 20px;
  }

  /* Track */
  .card ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  /* Handle */
  .card ::-webkit-scrollbar-thumb {
    background: #888;
  }

  /* Handle on hover */
  .card ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  .form-row .download {
    display: grid;
    justify-content: flex-end;
    text-align: center;
  }

  .form-row .download div span {
    color: #0A2472;
    text-align: center;
    font-family: 'Inter', sans-serif;
    font-size: 8px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  .form-row .download button {
    display: flex;
    padding: 10px 20px;
    background: #0A2472;
    border-radius: 20px;
    border: 0px;
    text-align: center;
    margin: auto;
  }

  .form-row .download button a {
    color: #fff;
    text-decoration: none;
    text-align: center;
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  .help-block {
    font-size: 12px;
  }
</style>
<section class="home">
  <div class="container">
    <!-- Breadcrumbs-->
    <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
    <!-- Page Content -->
    <h1 class="dash">Send Campaign</h1>
    <hr>
    <?php if (session()->getFlashdata('response') !== NULL) : ?>
      <p style="color:green; font-size:18px;">
        <?php echo session()->getFlashdata('response'); ?>
      </p>
    <?php endif; ?>
    <?php if (isset($validation)) : ?>
      <p style="color:red; font-size:18px;" align="center">
        <?= $validation->showError('validatecheck') ?>
      </p>
    <?php endif; ?>

    <form class="form-horizontal" action="<?= base_url('sendEmail') ?>" id="SubmitSendMail" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 backgrd">
          <div id="dynamic_field" class="card border-canc">
            <div class="card-body send-cam">
              <?php //if (isset($to)) : 
              ?>
              <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-2 col-lg-2 col-md-2" for="search">To</label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <input type="text" id="search" list="emailResults" class="form-control" style="height: 75px" placeholder="" name="search" autocomplete="off">
                    <!-- value="<?= "h" // if (isset($to)) : echo $to;endif; 
                                ?>"> -->
                    <?php if (isset($validation)) : ?>
                      <div style="color:red">
                        <?= $validation->showError('To') ?>
                      </div>
                    <?php endif; ?>
                    <input type="hidden" id="To" name="To">
                    <ul id="emailResults" style="padding: 0px; height:auto;" class="dropdown-menu">

                    </ul>
                    <!-- <datalist id="emailResults">
                    </datalist> -->

                    <div id="emailList"></div>


                  </div>
                </div>
              </div>
              <?php //endif; 
              ?>
              <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-2 col-lg-2 col-md-2" for="From">From</label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <input type="text" class="form-control" id="from" placeholder="xxx@gmail.com" name="From" autocomplete="off">
                    <?php if (isset($validation)) : ?>
                      <div style="color:red">
                        <?= $validation->showError('From') ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-2 col-lg-2 col-md-2" for="Name">Name</label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <input type="text" class="form-control" id="Name" placeholder="Name" name="Name" autocomplete="off">
                    <?php if (isset($validation)) : ?>
                      <div style="color:red">
                        <?= $validation->showError('Name') ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-3 col-lg-3 col-md-3" for="Send Email">Send Email to
                    (Upload):</label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <div class="input-group custom-file-button">
                      <label class="input-group-text" for="inputGroupFile">Upload Email data:</label>
                      <input type="file" name="file" style="display:none" class="form-control file" id="inputGroupFile">
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-2 col-lg-2 col-md-2" for="subject">subject</label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <input type="text" class="form-control" id="subject" placeholder="Survey on H&C - New Hair Extension Campaign June 2023" name="subject" autocomplete="off">
                  </div>
                </div>
              </div>

              <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-2 col-lg-2 col-md-2" for="Campaign Name">Survey /</br>
                    Campaign Name </label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <select class="custom-select form-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="survey">
                      <?php foreach ($getSurvey as $getSurveylist) { ?>
                        <option value="<?php echo $getSurveylist['campaign_id']; ?>">
                          <?php echo $getSurveylist['campaign_name']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <!-- <div class="col-xl-7 col-lg-7 col-md-7">
                  <select class="custom-select form-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="survey" >
                  <?php foreach ($getSurvey as $getSurveylist) { ?> 
                    <option value="<?php echo $getSurveylist['campaign_id']; ?>"><?php echo $getSurveylist['campaign_name']; ?></option>
                  <?php } ?>
                  </select>
                </div> -->
                </div>
              </div>

              <!-- <div class="form-group mb-3">
            <div class="form-row row"> 
              <label class="control-label  col-xl-5 col-lg-5 col-md-5" for="Send Email">Send Email to:</label>
                <div class="col-xl-7 col-lg-7 col-md-7">
                <input type="text" class="form-control" id="sendemail" placeholder="Send Email to" name="sendemail" autocomplete="off" >
                </div>
              </div>
            </div> -->
              <!-- <div class="form-group">
                <div class="form-row row">
                  <label class="control-label  col-xl-2 col-lg-2 col-md-2" for="From"></label>
                  <div class="col-xl-9 col-lg-9 col-md-9">
                    <div class="file-drop-area mb-3">
                      <img src="<?php echo base_url(); ?>images/icons/CSV.png" class="img-centered img-fluid">
                      <span class="file-message">Drag CSV here
                        </br><span class="browse">or click to browse<span></span>
                          <input class="file-input file" name="file" type="file" multiple id="inputGroupFile">
                          <p>Please upload File Size below 20mb</p> 
                    </div>
                    <div class="download">
                      <button>
                        <a href="<?php echo base_url(); ?>uploads/template.csv" id="output" download>Download</a></button>
                      <div><span>(click here to download CSV template)</span></div>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- <script>
  
$output = ...
$filename = "output.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-Length: " . strlen($output));
echo $output;
exit;
</script> -->


              <div class="form-group mb-3">
                <div class="form-row row">
                  <label class="control-label  col-xl-12 col-lg-12 col-md-5" for="Send Email">Message</label>
                  <div class="col-xl-12 col-lg-12 col-md-12">
                    <textarea id="editor" name="editor" value="" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group mt-4">
                <div class="form-row row">
                  <!-- <div class="col-md-6">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block prw-mail" value="Preview" />
                  </div> -->
                  <div class="col-md-6">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block snd-mail" value="Send Mail" />
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- Ending col space -->

        <!-- <div class="col-xl-4 col-lg-4 col-md-4 backgrd-1">
          <div class="card border-canc">
            <div class="card-body send-cam">
              <div class="form-group mb-3">
                <div class="form-row row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="panel panel-primary" id="result_panel">
                      <div class="panel-heading">
                        <ul class="" style="padding:0px 0px" id="">
                          <li class="list-group-item">
                            <div class="">
                              <div class="row">
                                <div class="">

                                  <div class="customer-list-head">
                                    <div class="head-content">
                                      <div>
                                        <label class="contact-list" for="contact-list">Contact List
                                        </label>
                                      </div>
                                      <div>
                                        <label class="label">Select All</label>
                                        <input type="checkbox" id="select-all" style="">
                                      </div>

                                    </div>
                                    <?php if (isset($validation)) : ?>
                                      <div style="color:red">
                                        <?= $validation->showError('checkoutemail') ?>
                                      </div>
                                    <?php endif; ?>
                                    <div class="search-container">
                                          <input type="text" class="search-input" placeholder="Search...">
                                          <div class="search-icon"><img
                                              src="<?php echo base_url(); ?>images/icons/search.png"
                                              class="img-centered img-fluid">
                                          </div>
                                        </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="panel-body">
                        <ul class="list-group" id="append_list">
                          <?php ?>
                          <?php if ($externalList) {
                            foreach ($externalList as $externalData) { ?>
                              <li class="list-group-item">
                                <div class="">
                                  <div class="row">
                                    <div class="">


                                    </div>
                                    <div class="customer-list-det">
                                      <p>
                                        <?php echo $externalData["email_id"]; ?>
                                      </p>
                                      <input type="checkbox" id="checkoutemail" name="checkoutemail[]" <?php if (isset($to) && $to == $externalData["email_id"]) : ?>checked <?php endif; ?> value="<?php echo $externalData["email_id"]; ?>" />
                                    </div>
                                  </div>
                                </div>
                              </li>
                          <?php }
                          } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

        <!-- <div class="col-xl-12 col-lg-12 col-md-12">

        </div> -->
      </div>
    </form>

  </div>
  <style>
    .list-group {
      max-height: 275px;
      margin-bottom: 10px;
      overflow-y: scroll;
      -webkit-overflow-scrolling: touch;
    }
  </style>
</section>
<script type="text/javascript">
  // document.getElementById('select-all').onclick = function() {
  //   var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  //   for (var checkbox of checkboxes) {
  //     checkbox.checked = this.checked;
  //   }
  // }
  // $(document).on('change', 'input[type="file"]', function() {
  //   // console.log(file1);
  //   var file = null;
  //   var file = $('#inputGroupFile').prop('files')[0];
  //   console.log(file);

  //   var formData = new FormData();
  //   formData.append('formData', file);
  //   console.log(formData);

  //   $.ajax({
  //     url: '<?php echo base_url('uploadFile'); ?>',
  //     type: 'post',
  //     dataType: 'json',
  //     data: formData,
  //     contentType: false,
  //     processData: false,
  //     success: function(response) {
  //       if (response.query) {
  //         let email = response.query;
  //         const myArray = email.split(",");
  //         console.log(myArray);
  //         $.each(myArray, function(index, value) {
  //           $("#append_list").append('<li class="list-group-item"><div class="container"><div class= "row"><div class="col-xl-11 col-lg-11 col-md-11">' + value + '</div><div class="col-xl-1 col-lg-1 col-md-1"><input type="checkbox"  id="checkoutemail" name="checkoutemail[]"  value="' + value + '"/></div></div></div></li>');


  //         });
  //         $("#sendemail").val(response.query);
  //       }
  //       window.location.reload();
  //     },
  //     error: function(response) {
  //       console.log(response);
  //     }
  //   });
  // });
  tinymce.init({
    menubar: false,
    selector: '#editor',
    setup: function(editor) {
      editor.on('init', function(e) {
        editor.setContent('<p>We value your feedback and encourage you to share your thoughts with us.</p><p>Your feedback is crucial to our improvement and helps us better cater to your needs.</p><p>Let us know what you think; your insights are important to our ongoing commitment to excellence.</p>');
      });
    }
  });
  $('textarea#editor').tinymce({
    height: 160,
    menubar: false,
    plugins: [
      'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
      'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
      'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent | removeformat | code table help'
  });
</script>
<script>
  $(document).on('change', '.file-input', function() {


    var filesCount = $(this)[0].files.length;

    var textbox = $(this).prev();

    if (filesCount === 1) {
      var fileName = $(this).val().split('\\').pop();
      textbox.text(fileName);
    } else {
      textbox.text(filesCount + ' files selected');
    }
  });

  $(document).ready(function() {
    $('#search').keyup(function() {
      var query = $(this).val();
      var selectedList=GetSelectedList();
      console.log("selectedList",selectedList);
      if (query != '') {
        $.ajax({
          url: '<?php echo base_url("searchMails"); ?>',
          method: 'get',
          dataType: 'json',
          data: {
            like: query,
            notLike: selectedList
          },
          success: function(response) {
            if (response.success) {
              let email = response.output;
              console.log(email);
              console.log("entry in se");
              $('#emailResults').html('');

              $.each(email, function(index, value) {
                console.log(value.name);
                //$("#emailResults").append('<option value="' + value.email_id + '">' + value.email_id + '</option>');
                innerText = value.count ? value.name + ' - ' + value.count + ' customers' : value.name;
                $("#emailResults").append("<li onclick='AddEmails(" + JSON.stringify(value) + ")'>" + innerText + "</li>");


                // $("#emailResults").show();
                //datalist()
              });
              //             let element = document.getElementById("search");
              // element.setAttribute("data-bs-toggle", "dropdown");
              // $("#search").click();
              // let dropdown = document.querySelector(".dropdown-menu");
              //   dropdown.classList.add("show");
              //     $('#emailResults').html(data);
            } else {
              $('#emailResults').html('');
            }
          }
        });
      } else {
        $('#emailResults').html('');
      }
    });
  });


  let element = document.getElementById("search");
  element.setAttribute("data-bs-toggle", "dropdown");


  // document.addEventListener('DOMContentLoaded', e => {
  //   console.log("entry");
  //     $('#input-datalist').autocomplete()
  // }, false);

  function AddEmails(object) {
    console.log('hi');
    // var labelInput = document.getElementById('search');
    //   var emailid = labelInput.value.trim();

    console.log(object.name);
    var emailsContainer = document.getElementById('emailList');
    var email = document.createElement('div');



    if (object.status == '0') {
      email.className = 'segment';
      email.innerText = object.name;


    } else {
      email.innerText = object.name;
      email.className = 'email';
    }
    var removeButton = document.createElement('button');
    removeButton.innerText = 'X';
    removeButton.onclick = function() {
      emailsContainer.removeChild(email);
    };
    console.log("appended")
    email.appendChild(removeButton);
    if (object.status == '0') {
      var emailCount = document.createElement('div');
      emailCount.className = 'emailCount';
      emailCount.innerText = object.count + ' customers';
      console.log("k", email.innerText);
      email.appendChild(emailCount);
    }
    email.id = object.id;
    // var inputElement = document.createElement('input');
    // inputElement.value = object.name;


    emailsContainer.appendChild(email);

  }
  var To = "<?php if (isset($to)) : echo $to; ?><?php endif; ?>";

  console.log("to:", To);
  if (To) {
    var custObject = {
      name: To,
      status: 1
    };
    AddEmails(custObject)
  }
  $("#SubmitSendMail").submit(function(event) {
    //event.preventDefault();


    var elements = document.getElementsByClassName('email');
    var segments = document.getElementsByClassName('segment');
    var emailArray = [];
    var segmentArray = [];
    for (var i = 0; i < elements.length; i++) {
      console.log(elements[i].childNodes);
      var node = elements[i].childNodes[0];
      console.log("n", node);
      emailArray.push(node.textContent.trim());
    }
    for (var i = 0; i < segments.length; i++) {
      console.log(segments[i].childNodes);
      var node = segments[i].id;
      console.log("n", node);
      segmentArray.push(node);
    }

    var toArray = [emailArray, segmentArray]
    console.log(toArray);
    $('#To').val(JSON.stringify(toArray));

    console.log("submit");
  });

  function GetSelectedList(){
    var elements = document.getElementsByClassName('email');
    var segments = document.getElementsByClassName('segment');
    var emailArray = [];
    var segmentArray = [];
    for (var i = 0; i < elements.length; i++) {
      console.log(elements[i].childNodes);
      var node = elements[i].childNodes[0];
      console.log("n", node);
      emailArray.push(node.textContent.trim());
    }
    for (var i = 0; i < segments.length; i++) {
      console.log(segments[i].childNodes);
      var node = segments[i].id;
      console.log("n", node);
      segmentArray.push(node);
    }

    var toArray = [emailArray, segmentArray]
    console.log(toArray);
    return toArray;
  }
</script>
</section>
<?= $this->endSection() ?>
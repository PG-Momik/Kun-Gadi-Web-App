<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kun Gadi</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

  <?php include_once 'assets/php/partials/_nav.php'; ?>

  <!-- Section home -->
  <section id="home">
    <div class="row">
      <div class="col-lg-6 textx">
        <h1>Ease your journey with our mobile app.</h1>
        <div>
          <button class="btn btn-dark btn-lg download-button"><i class="fab fa-apple"></i> Download</button>
          <button class="btn btn-outline-light btn-lg download-button"><i class="fab fa-google-play"></i>
            Download</button>
        </div>
      </div>
      <div class="col-lg-6">
        <img class="title-image" src="./assets/images//app.png " alt="">
      </div>
    </div>
    </div>
  </section>

  <!-- Section Get Started -->
  <section id="get-started">
    <div style="padding:40px">
      <h1>Get Started</h1>
      <br>
      <form action="">
        <select class="form-select" style="padding-left: 20px;
        padding-right:20px;width:40%; margin-left: 30%;
        margin-right:30%">
          <option selected>Select search option</option>
          <option value="1">Search by route number</option>
          <option value="2">Search by place name</option>
          <option value="3">Search by From - To</option>
        </select>
        <div>
          <input type="text" name="input1" id="input1" class="form-control"
            style="width: 50%; margin-left:25%; padding:10px 20px; border-radius:25px; margin-top:4vh; margin-bottom:4vh;background:#dcdcdc"
            placeholder="Route Number" hidden>

        </div>
        <div>
          <input type="text" name="input2" id="input2" class="form-control"
            style="width: 50%; margin-left:25%; padding:10px 20px; border-radius:25px; margin-top:4vh; margin-bottom:4vh;background:#dcdcdc"
            placeholder="Place Name" hidden>

        </div>
        <div style="display:flex;">
          <input type="text" name="input3" id="input3" class="form-control"
            style="width: 25%; margin-left:25%; padding:10px 20px; border-radius:25px 0 0 25px; margin-top:4vh; margin-bottom:4vh;background:#dcdcdc"
            placeholder="From">
          <input type="text" name="input3" id="input4" class="form-control"
            style="width: 25%; margin-left:0; padding:10px 20px; border-radius:0 25px 25px 0 ; margin-top:4vh; margin-bottom:4vh;background:#dcdcdc"
            placeholder="To">
        </div>

        <button class="btn btn-md"
          style="width:30%; margin-left:35%; background:#27285c; color:white; border-radius:25px; padding:10px; font-size:1.4rem">Search
        </button>
      </form>
    </div>
  </section>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Tangerine:400,700%7cRoboto:300,400,500%7cMegrim%7cPoiret+One" rel="stylesheet">

  <link href="css/table-style.css" rel="stylesheet" />

  <!-- Social Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">






  <title>Frontend</title>
</head>

<body>
  <main class="main-wrapper">
    <h1>Hello from the Frontend!</h1>
    <section class="section-wrapper">
      <div id="myContainer" class="container">
      </div>
    </section>
    <section class="section-wrapper">
      <h1>Add a user</h1>
        <div class="section-row">
            <div class="col-1-2">
              <label for="name">User name*</label><br>
              <label for="number">Password*</label><br>
            </div>
            <div class="col-1-2">
              <input type="text" name="name" id="username" ><br>
              <input type="password" name="number" id="password" ><br>
              <input type="submit" class="submit" onclick="addUser()"  value="Add user">

                <form class="contact-form" method="GET">
                </form>
            </div>
        </div>
    </section>
    <section class="section-wrapper">
      <h1>Add a post</h1>
      <div class="form-group">
        <input type="text" id="title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="article" placeholder="Article name">
        <textarea name="post" id="comment" rows="8" cols="120" placeholder="Your post should not be more tha 10000 characters! Remember!"></textarea>
        <br/>
        <input type="submit" onclick="addEntry()" class="btn btn-primary" value="Post">


      </div>
    </section>

  </main>
</body>
<script src="scripts/jquery-latest.js"></script>
<script src="scripts/jquery.tablesorter.js"></script>
<script src="scripts/jquery.tablesorter.pager.js"></script>
<script src="scripts/main.js"></script>

<footer class="footer-wrapper">
</footer>

</html>

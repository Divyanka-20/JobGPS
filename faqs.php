<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Career Cracker - Q&A</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background: url("https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg") no-repeat center center;
      background-size: cover;
      color: #fff;
    }

    main {
        flex: 1;
        padding: 100px 20px 40px; /* top padding = navbar height + some space */
        max-width: 800px;
        margin: 0 auto;
    }


    .question-box {
      background: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      margin-bottom: 15px;
      padding: 15px 20px;
      cursor: pointer;
      position: relative;
      transition: background 0.3s ease;
    }

    .answer {
    max-height: 0;
    overflow: hidden;
    background-color: rgba(230, 226, 226, 0.81);
    transition: max-height 0.25s ease;
    text-align: center;
    }

    .faq.active .answer {
    max-height: 1000px; /* enough height to show content */
    transition: max-height 0.25s ease;
    color: rgb(14, 92, 182);
    font-size: 16px;
    font-family: 'Times New Roman', Times, serif;
    }


    .question h3 {
    position: relative;
    padding-right: 20px;
    color: rgb(190, 16, 77);
    font-family: 'Times New Roman', Times, serif;
    font-size: 17px;
    }

    .faq .question h3:after {
    content: '+';
    position: absolute;
    right: 0;
    font-size: 20px;
    transition: 0.3s ease;
    }

    .faq.active .question h3:after {
    content: '−';
    }

  </style>
</head>
<body>

  <?php include 'navbar.php'; ?>

  <main>
  <?php
    include 'database_connection.php'; // your DB connection file

    $query = "SELECT * FROM faqs";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $question = htmlspecialchars($row['question'], ENT_QUOTES);
        $answer = htmlspecialchars($row['answer'], ENT_QUOTES);
        echo "
          <div class='faq'>
            <div class='question'>
              <h3>$question</h3>
            </div>
            <div class='answer'>
              <p>$answer</p>
            </div>
          </div>
        ";
      }
    } else {
      echo "<p style='color: rgb(190, 16, 77); font-size:20px; font-weight:bold;'>No FAQs found.</p>";
    }
  ?>
</main>


  <?php include 'footer.php'; ?>

  <script>
  document.querySelectorAll(".faq").forEach(faq => {
    faq.addEventListener("click", () => {
      faq.classList.toggle("active");
    });
  });
</script>

</body>
</html>

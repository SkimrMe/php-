<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="./js/sweetalert.min.js"></script>
  <title>留言板 | Message boards</title>
</head>

<body>

  <nav class="navbar fixed-top navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">留言板 | Message boards</span>
  </nav>
  <br><br>
  <div class="container">
    <br>
    <div class="jumbotron">
      <h1 class="display-3">Message boards <span class="badge badge-warning">NEW</span></h1>
      <p class="lead">欢迎你来此留言,谢谢你 | You are welcome to leave a message here, Thank you | AWA</p>
    </div>



    <div class="container">
        <div class="row">
          <div class="col">

            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">留言</h5>
                <h6 class="card-subtitle mb-2 text-muted">请留下您的宝贵意见</h6>
                <form method="POST">
                  <div class="form-group">
                    <label for="name">用户名</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="用户名">
                    <!-- 留言内容 -->
                    <label for="content">留言内容</label>
                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                  </div>
                  <center><button type="submit" class="btn btn-info">提交 | Submit</button></center>
                </form>
                <br>
                <!-- 结束 -->
              </div>
            </div>

          </div>
          <div class="col">
          <div class="alert alert-dark" role="alert">
            <center>留言列表 | Message List</center>
</div>
            <?php
            //链接数据库
            $servername = "localhost";
            $username = "message";
            $password = "message";
            $dbname = "message";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
              die("连接失败: " . $conn->connect_error);
            }
            //查询数据
            // 1	id	varchar(255)	utf8_general_ci
            // 2	username	varchar(20)	utf8_general_ci
            // 3	message	varchar(255)	utf8_general_ci
            // 4	time	datetime	
            
            //时间倒序查询
            $sql = "SELECT * FROM message ORDER BY time DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              // 输出数据
              while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row["username"] . "</h5>";
                echo "<h6 class='card-subtitle mb-2 text-muted'>时间:" . $row["time"] . "</h6>";
                echo '<h6 class="card-text"><span class="badge badge-success">留言内容</span>:' . $row["message"] . '</h6>';
                echo "</div>";
                echo "</div>";
                echo "<br>";
              }
            } else {
              //没有数据
              echo "<div class='alert alert-warning' role='alert'>";
              echo "<center> 暂无留言 </center>";
              echo "</div>";
            }
            $conn->close();

            ?>
          </div>

        </div>
      </div>

    </div>
  </div>
  </div>
  <!-- footer -->
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text">
      <center>Copyright © 2024 STON</center>
    </span>
  </nav>
  <!-- js -->
  <script src="./js/jquery-3.3.1.slim.min.js"></script>
  <script src="./js/popper.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
</body>

</html>
<?php
//插入数据message数据库,包含表如下
// 1	id	varchar(255)	utf8_general_ci
// 2	username	varchar(20)	utf8_general_ci
// 3	message	varchar(255)	utf8_general_ci
// 4	time	datetime	

// 1.连接数据库,用户密码全是message
$servername = "localhost";
$username = "message";
$password = "message";
$dbname = "message";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("连接失败: " . $conn->connect_error);
}
// 2.插入数据
// 判断是否POST提交
if ($_POST['name'] && $_POST['content']) {
  if ($_POST['name'] != null && $_POST['content'] != null) {
    $name = $_POST['name'];
    $content = $_POST['content'];
    //生成随机id 12位,md5加密内容和时间戳
    $id = substr(md5($content . time()), 0, 20);
    $sql = "INSERT INTO message (id, username, message, time) VALUES ('$id', '$name', '$content', now())";
    if ($conn->query($sql) === TRUE) {
      //sweet alert插入成功,点击确定后刷新页面
      echo '
    <script>
    swal({
      title: "留言成功",
      text: "感谢您的留言",
      icon: "success",
      button: "AWA! GO!",
    }).then(function() {
      location.href="index.php";
      });
    </script>';
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    //sweet alert插入失败,点击确定后刷新页面
    echo '
  <script>
  swal({
    title: "留言失败",
    text: "请填写完整信息",
    icon: "error",
    button: "快看看写的是什么",
  }).then(function() {
    location.href="index.php";
    });
  </script>';
  }
}

?>
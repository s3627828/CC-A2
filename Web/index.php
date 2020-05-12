<?
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $file = '/tmp/sample-app.log';
  $message = file_get_contents('php://input');
  file_put_contents($file, date('Y-m-d H:i:s') . " Received message: " . $message . "\n", FILE_APPEND);
}
else
{
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>CC-A2</title>
    <link rel="stylesheet" href="/styles.css" type="text/css">
</head>
<body>
  <header>
    <h1>CC_A2</h1>
    <h2>s3653373 - Abhinav Gupta|s3627828 - Ming Yin Wong</h2>
  </header>
    <section class="congratulations">
      <h1>Select a requirenment</h1>
      <form action="index.php" method="post">
        <div>
          Requirenment:
          <select id="requirenment" name="requirenment">
            <option value="1">Average sitting time</option>
            <option value="2">The total time of exercise</option>
            <option value="3">Average exercise time</option>
            <option value="4">Average step </option>
            <option value="5">The Average distance walk</option>
            <option value="6">How much Calories burned</option>
          </select>
        </div>
      <br>
      <div>
        Period:
        <select id="period" name="period">
          <option value="D">Day</option>
          <option value="W">Week</option>
          <option value="M">Month</option>
        </select>
      </div>

        <input type="submit" value="Submit"></div>
      </form>
    </section>

    <section class="instructions">
      <h1>Chart</h1>
      <h2>The chart will display here!!!!</h2>
    </section>

</body>
</html>
<?
}
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="/styles.css" type="text/css">
<title>CC-A2-dataset</title>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.7.16.min.js"></script>
<script type="text/javascript">

//Graph for the Total exercise minstes
window.onload = function() {

  //Connect with DynamoDB
  AWS.config.update({
    region: "us-east-1",
    endpoint: 'dynamodb.us-east-1.amazonaws.com',
    // accessKeyId default can be used while using the downloadable version of DynamoDB.
    // For security reasons, do not store AWS Credentials in your files. Use Amazon Cognito instead.
    accessKeyId: "AKIAYCZWEEWDY5OSUM7Q",
    // secretAccessKey default can be used while using the downloadable version of DynamoDB.
    // For security reasons, do not store AWS Credentials in your files. Use Amazon Cognito instead.
    secretAccessKey: "O17+KZkL0c2WNTBEYqKh5IvinwelpxX/f9dIk+5C"
  });

  var docClient = new AWS.DynamoDB.DocumentClient();

       var params = {
        TableName: "Fitbit1",
    };
    //Make the textarea like a table
    //document.getElementById('textarea').innerHTML += "Dataset: "+"\n";
    //document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Minutes of slow activity" + "\t\t\t" + "Minutes of moderate activity" + "\t" + "Minutes of intense activity" + "\n";

    //get item from DynamoDB
    docClient.scan(params,onScan);

    function onScan(err, data) {
            if (err) {
                //document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
            } else {
                // Print all the item
                //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                data.Items.forEach(function(fitbit) {
                    var table = document.getElementById("table");
                    var row = table.insertRow(-1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    var cell6 = row.insertCell(5);
                    var cell7 = row.insertCell(6);
                    var cell8 = row.insertCell(7);
                    var cell9 = row.insertCell(8);
                    var cell10 = row.insertCell(9);

                    cell1.innerHTML = fitbit.D;
                    cell2.innerHTML = fitbit.Calories;
                    cell3.innerHTML = fitbit.Steps;
                    cell4.innerHTML = fitbit.Distance;
                    cell5.innerHTML = fitbit.floors;
                    cell6.innerHTML = fitbit.Minutes_sitting;
                    cell7.innerHTML = fitbit.Minutes_of_slow_activity;
                    cell8.innerHTML = fitbit.Minutes_of_moderate_activity;
                    cell9.innerHTML = fitbit.Minutes_of_intense_activity;
                    cell10.innerHTML = fitbit.Calories_Activity;

                });

                //Just use to check the value correct or not
                //document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"
            }
          }
}
</script>



</head>
<body>
  <header>
    <div class="header">
      <img src="IMAGE3.png" alt="fitbit" width="200" height="150">
      <h1 class = "title" align="center" font-size:60px>  Fitbit Dataset analysis</h1>
  </div>
  </header>
    <section class="congratulations">
      <img src="IMAGE2.jpg" alt="Fitbit ChargeHr" width="200" height="450">
      <br>
      <img src="IMAGE4.jpg" alt="Fitbit ChargeHr" width="300" height="170">
      <br>
      <img src="IMAGE1.jpg" alt="Fitbit ChargeHr" width="300" height="170">
    </section>

    <section class="instructions">
    <!-- <textarea readonly id= "textarea" style="width:700px; height:200px"></textarea> -->
    <table id="table">
      <td>Date</td>
      <td>Calories</td>
      <td>Steps</td>
      <td>Distance</td>
      <td>Floors</td>
      <td>Minutes of Sitting</td>
      <td>Minutes of slow Activity</td>
      <td>Minutes of Moderate Activity</td>
      <td>Minutes of intense Activity</td>
      <td>Calories Activity</td>
    </table>
    </section>

</body>
</html>

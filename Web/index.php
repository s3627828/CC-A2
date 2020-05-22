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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.7.16.min.js"></script>
    <script type="text/javascript">
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

    //Graph for the Total exercise minutes
    function firstGraph() {
      var may = 0;
      var june = 0;
      var july = 0
      var aug = 0;
      var sept = 0;
      var oct = 0;
      var nov = 0;
      var dec = 0;
      var jan = 0;
      var feb = 0;
      var mar = 0;
      var apr = 0;
      var secondMay = 0;
           var params = {
            TableName: "Fitbit1",
        };
        //Clean the TextArea
        document.getElementById('textarea').innerHTML = "Dataset: "+"\n";
        //Make the textarea like a table
        document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Minutes of slow activity" + "\t\t\t" + "Minutes of moderate activity" + "\t" + "Minutes of intense activity" + "\n";

        //get item from DynamoDB
        docClient.scan(params,onScan);

        function onScan(err, data) {
                if (err) {
                    document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
                } else {
                    // Print all the item
                    //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                    data.Items.forEach(function(fitbit) {
                      var str = fitbit.D;

                        document.getElementById('textarea').innerHTML += str + "\t\t\t\t\t\t" + fitbit.Minutes_of_slow_activity + "\t\t\t\t\t\t" +
                              fitbit.Minutes_of_moderate_activity + "\t\t\t\t\t\t\t" + fitbit.Minutes_of_intense_activity + "\n";

                        //set data for graph
                        if(str.substring(0,1)=="5"&&str.substr(str.length-4,str.length)=="2015"){
                          may += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,1)=="6"){
                          june +=parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,1)=="7"){
                          july +=parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,1)=="8"){
                          aug += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if (str.substring(0,1)=="9"){
                          sept += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,2)=="10"){
                          oct += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,2)=="11"){
                          nov += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,2)=="12"){
                          dec += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,1)=="1"&&str.substr(str.length-4)=="2016"){
                          jan += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if (str.substring(0,1)=="2"){
                          feb += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if((str.substring(0,1)=="3")){
                          mar += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if(str.substring(0,1)=="4"){
                          apr += parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }else if (str.substring(0,1)=="5"&&str.substr(str.length-4)=="2016"){
                          secondMay +=parseFloat(fitbit.Minutes_of_intense_activity)+parseFloat(fitbit.Minutes_of_slow_activity)+parseFloat(fitbit.Minutes_of_moderate_activity);
                        }
                    });

                    //Just use to check the value correct or not
                    // document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"+aug+"\n" +sept+"\n" +oct+"\n" +nov+"\n" +dec +"\n"+
                    // jan +"\n" + feb+"\n" +mar+"\n" +apr+"\n" + secondMay+"\n";
                }

                //display graph
                var chart = new CanvasJS.Chart("chartContainer", {
                  title:{
                    text: "The total exercise minutes in a month"
                  },
                  data: [
                  {
                    // Change type to "doughnut", "line", "splineArea", etc.
                    type: "column",
                    dataPoints: [
                      { label: "May 2015",  y: may  },
                      { label: "June 2015", y: june },
                      { label: "July 2015", y: july  },
                      { label: "August 2015",  y: aug  },
                      { label: "September 2015",  y: sept  },
                      { label: "October 2015",  y: oct  },
                      { label: "November 2015",  y: nov  },
                      { label: "December 2015",  y: dec  },
                      { label: "January 2016",  y: jan  },
                      { label: "February 2016",  y: feb  },
                      { label: "March 2016",  y: mar  },
                      { label: "April 2016",  y: apr  },
                      { label: "May 2016",  y: secondMay  }
                    ]
                  }
                  ]
                });
                //document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"
                chart.render();
              }
    }

    //Graph for Slow activity vs Moderate activity vs intense_activity in month
    function secondGraph(){
      //For slow activity
      var maySlow= 0;
      var juneSlow = 0;
      var julySlow = 0
      var augSlow = 0;
      var septSlow = 0;
      var octSlow = 0;
      var novSlow = 0;
      var decSlow = 0;
      var janSlow = 0;
      var febSlow = 0;
      var marSlow = 0;
      var aprSlow = 0;
      var secondMaySlow = 0;
      //For moderate activity
      var mayMod = 0;
      var juneMod = 0;
      var julyMod = 0
      var augMod = 0;
      var septMod = 0;
      var octMod = 0;
      var novMod = 0;
      var decMod = 0;
      var janMod = 0;
      var febMod = 0;
      var marMod = 0;
      var aprMod = 0;
      var secondMayMod = 0;
      //For intense activity
      var mayInten = 0;
      var juneInten = 0;
      var julyInten = 0
      var augInten = 0;
      var septInten = 0;
      var octInten = 0;
      var novInten = 0;
      var decInten = 0;
      var janInten = 0;
      var febInten = 0;
      var marInten = 0;
      var aprInten = 0;
      var secondMayInten = 0;
           var params = {
            TableName: "Fitbit1",
        };
        //Clean the TextArea
        document.getElementById('textarea').innerHTML = "Dataset: "+"\n";
        //Make the textarea like a table
        document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Minutes of slow activity" + "\t\t\t" + "Minutes of moderate activity" + "\t" + "Minutes of intense activity" + "\n";

        //get item from DynamoDB
        docClient.scan(params,onScan);

        function onScan(err, data) {
          if (err) {
              document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
          } else {
              // Print all the item
              //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
              data.Items.forEach(function(fitbit) {
                var str = fitbit.D;

                  document.getElementById('textarea').innerHTML += str + "\t\t\t\t\t\t" + fitbit.Minutes_of_slow_activity + "\t\t\t\t\t\t" +
                        fitbit.Minutes_of_moderate_activity + "\t\t\t\t\t\t\t" + fitbit.Minutes_of_intense_activity + "\n";

                  //set data for graph
                  if(str.substring(0,1)=="5"&&str.substr(str.length-4,str.length)=="2015"){
                    maySlow += parseFloat(fitbit.Minutes_of_slow_activity);
                    mayMod += parseFloat(fitbit.Minutes_of_moderate_activity);
                    mayInten+= parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,1)=="6"){
                    juneSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    juneMod+= parseFloat(fitbit.Minutes_of_moderate_activity);
                    juneInten +=parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,1)=="7"){
                    julySlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    julyMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    julyInten +=parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,1)=="8"){
                    augSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    augMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    augInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if (str.substring(0,1)=="9"){
                    septSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    septMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    septInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,2)=="10"){
                    octSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    octMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    octInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,2)=="11"){
                    novSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    novMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    novInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,2)=="12"){
                    decSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    decMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    decInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,1)=="1"&&str.substr(str.length-4)=="2016"){
                    janSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    janMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    janInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if (str.substring(0,1)=="2"){
                    febSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    febMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    febInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if((str.substring(0,1)=="3")){
                    marSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    marMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    marInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if(str.substring(0,1)=="4"){
                    aprSlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    aprMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    aprInten += parseFloat(fitbit.Minutes_of_intense_activity);
                  }else if (str.substring(0,1)=="5"&&str.substr(str.length-4)=="2016"){
                    secondMaySlow+=parseFloat(fitbit.Minutes_of_slow_activity);
                    secondMayMod+=parseFloat(fitbit.Minutes_of_moderate_activity);
                    secondMayInten +=parseFloat(fitbit.Minutes_of_intense_activity);
                  }
              });

              //Just use to check the value correct or not
              // document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"+aug+"\n" +sept+"\n" +oct+"\n" +nov+"\n" +dec +"\n"+
              // jan +"\n" + feb+"\n" +mar+"\n" +apr+"\n" + secondMay+"\n";
          }
          //display Graph
          var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
              text: "Slow activity vs Moderate activity vs Intense activity in month"
            },
            axisY: {
              title: "Minutes",
            },
            legend:{
              cursor: "pointer",
              fontSize: 16,
              itemclick: toggleDataSeries
            },
            toolTip:{
              shared: true
            },
            data: [{
              name: "Slow activity",
              type: "spline",
              showInLegend: true,
              dataPoints: [
                { label: "May 2015",  y: maySlow  },
                { label: "June 2015", y: juneSlow },
                { label: "July 2015", y: julySlow  },
                { label: "August 2015",  y: augSlow  },
                { label: "September 2015",  y: septSlow  },
                { label: "October 2015",  y: octSlow  },
                { label: "November 2015",  y: novSlow  },
                { label: "December 2015",  y: decSlow  },
                { label: "January 2016",  y: janSlow  },
                { label: "February 2016",  y: febSlow  },
                { label: "March 2016",  y: marSlow  },
                { label: "April 2016",  y: aprSlow  },
                { label: "May 2016",  y: secondMaySlow  }
              ]
            },
            {
              name: "Moderate activity",
              type: "spline",
              showInLegend: true,
              dataPoints: [
                { label: "May 2015",  y: mayMod  },
                { label: "June 2015", y: juneMod },
                { label: "July 2015", y: julyMod  },
                { label: "August 2015",  y: augMod  },
                { label: "September 2015",  y: septMod  },
                { label: "October 2015",  y: octMod  },
                { label: "November 2015",  y: novMod  },
                { label: "December 2015",  y: decMod  },
                { label: "January 2016",  y: janMod  },
                { label: "February 2016",  y: febMod  },
                { label: "March 2016",  y: marMod  },
                { label: "April 2016",  y: aprMod  },
                { label: "May 2016",  y: secondMayMod  }
              ]
            },
            {
              name: "Intense activity",
              type: "spline",
              showInLegend: true,
              dataPoints: [
                { label: "May 2015",  y: mayInten  },
                { label: "June 2015", y: juneInten },
                { label: "July 2015", y: julyInten },
                { label: "August 2015",  y: augInten  },
                { label: "September 2015",  y: septInten  },
                { label: "October 2015",  y: octInten  },
                { label: "November 2015",  y: novInten  },
                { label: "December 2015",  y: decInten },
                { label: "January 2016",  y: janInten},
                { label: "February 2016",  y: febInten  },
                { label: "March 2016",  y: marInten  },
                { label: "April 2016",  y: aprInten  },
                { label: "May 2016",  y: secondMayInten  }
              ]
            }]
          });
          chart.render();

          function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
            }
            else{
              e.dataSeries.visible = true;
            }
            chart.render();
          }
        }}

    //Graph for Calories burned per day in a month
    function thridGraph(){
      var may = 0;
      var june = 0;
      var july = 0
      var aug = 0;
      var sept = 0;
      var oct = 0;
      var nov = 0;
      var dec = 0;
      var jan = 0;
      var feb = 0;
      var mar = 0;
      var apr = 0;
      var secondMay = 0;
      var maycount=0;
      var junecount=0;
      var julycount=0;
      var augcount=0;
      var septcount=0;
      var octcount=0;
      var novcount=0;
      var deccount=0;
      var jancount=0;
      var febcount=0;
      var marcount=0;
      var aprcount=0;
      var secondMaycount=0;

           var params = {
            TableName: "Fitbit1",
        };
        //Clean the TextArea
        document.getElementById('textarea').innerHTML = "Dataset: "+"\n";
        //Make the textarea like a table
        document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Calories Activity " + "\n";

        //get item from DynamoDB
        docClient.scan(params,onScan);

        function onScan(err, data) {
                if (err) {
                    document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
                } else {
                    // Print all the item
                    //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                    data.Items.forEach(function(fitbit) {
                      var str = fitbit.D;

                        document.getElementById('textarea').innerHTML += str + "\t\t\t\t" + fitbit.Calories_Activity+ "\n";

                        //set data for graph
                        if(str.substring(0,1)=="5"&&str.substr(str.length-4,str.length)=="2015"){
                          may += parseFloat(fitbit.Calories_Activity);
                          maycount++;
                        }else if(str.substring(0,1)=="6"){
                          june +=parseFloat(fitbit.Calories_Activity);
                          junecount++
                        }else if(str.substring(0,1)=="7"){
                          july +=parseFloat(fitbit.Calories_Activity);
                          julycount++;
                        }else if(str.substring(0,1)=="8"){
                          aug += parseFloat(fitbit.Calories_Activity);
                          augcount++;
                        }else if (str.substring(0,1)=="9"){
                          sept += parseFloat(fitbit.Calories_Activity);
                          septcount++;
                        }else if(str.substring(0,2)=="10"){
                          oct += parseFloat(fitbit.Calories_Activity);
                          octcount++;
                        }else if(str.substring(0,2)=="11"){
                          nov += parseFloat(fitbit.Calories_Activity);
                          novcount++;
                        }else if(str.substring(0,2)=="12"){
                          dec += parseFloat(fitbit.Calories_Activity);
                          deccount++;
                        }else if(str.substring(0,1)=="1"&&str.substr(str.length-4)=="2016"){
                          jan += parseFloat(fitbit.Calories_Activity);
                          jancount++;
                        }else if (str.substring(0,1)=="2"){
                          feb += parseFloat(fitbit.Calories_Activity);
                          febcount++;
                        }else if((str.substring(0,1)=="3")){
                          mar += parseFloat(fitbit.Calories_Activity);
                          marcount++;
                        }else if(str.substring(0,1)=="4"){
                          apr += parseFloat(fitbit.Calories_Activity);
                          aprcount++;
                        }else if (str.substring(0,1)=="5"&&str.substr(str.length-4)=="2016"){
                          secondMay +=parseFloat(fitbit.Calories_Activity);
                          secondMaycount++;
                        }
                    });

                    //Just use to check the value correct or not
                    // document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"+aug+"\n" +sept+"\n" +oct+"\n" +nov+"\n" +dec +"\n"+
                    // jan +"\n" + feb+"\n" +mar+"\n" +apr+"\n" + secondMay+"\n";
                }
                var chart = new CanvasJS.Chart("chartContainer", {
                  animationEnabled: true,
                  title: {
                    text: "Calories burned per day in a month"
                  },

                  axisY: {
                    title: "Calories",
                    titleFontColor: "#4F81BC",
                  },
                  data: [{
                    indexLabelFontColor: "darkSlateGray",
                    name: "views",
                    type: "area",
                    dataPoints: [
                      { label: "May 2015",  y: may/maycount  },
                      { label: "June 2015", y: june/junecount , indexLabel: "Highest", markerColor: "red"  },
                      { label: "July 2015", y: july/julycount  },
                      { label: "August 2015",  y: aug/augcount  },
                      { label: "September 2015",  y: sept/septcount  },
                      { label: "October 2015",  y: oct/octcount  },
                      { label: "November 2015",  y: nov/novcount  },
                      { label: "December 2015",  y: dec/deccount  },
                      { label: "January 2016",  y: jan/jancount  },
                      { label: "February 2016",  y: feb/febcount  },
                      { label: "March 2016",  y: mar/marcount  },
                      { label: "April 2016",  y: apr/aprcount  },
                      { label: "May 2016",  y: secondMay/secondMaycount}
                    ]
                  }]
                });
                chart.render();
                  }
  }

    //Graph for Total steps per month
    function fourGraph(){
      var may = 0;
      var june = 0;
      var july = 0
      var aug = 0;
      var sept = 0;
      var oct = 0;
      var nov = 0;
      var dec = 0;
      var jan = 0;
      var feb = 0;
      var mar = 0;
      var apr = 0;
      var secondMay = 0;
           var params = {
            TableName: "Fitbit1",
        };
        //Clean the TextArea
        document.getElementById('textarea').innerHTML = "Dataset: "+"\n";
        //Make the textarea like a table
        document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Steps"+ "\n";

        //get item from DynamoDB
        docClient.scan(params,onScan);

        function onScan(err, data) {
                if (err) {
                    document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
                } else {
                    // Print all the item
                    //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                    data.Items.forEach(function(fitbit) {
                      var str = fitbit.D;

                        document.getElementById('textarea').innerHTML += str + "\t\t\t" + fitbit.Steps + "\n";

                        //set data for graph
                        if(str.substring(0,1)=="5"&&str.substr(str.length-4,str.length)=="2015"){
                          may += parseFloat(fitbit.Steps);
                        }else if(str.substring(0,1)=="6"){
                          june +=parseFloat(fitbit.Steps);
                        }else if(str.substring(0,1)=="7"){
                          july +=parseFloat(fitbit.Steps);
                        }else if(str.substring(0,1)=="8"){
                          aug += parseFloat(fitbit.Steps);
                        }else if (str.substring(0,1)=="9"){
                          sept += parseFloat(fitbit.Steps);
                        }else if(str.substring(0,2)=="10"){
                          oct += parseFloat(fitbit.Steps);
                        }else if(str.substring(0,2)=="11"){
                          nov += parseFloat(fitbit.Steps);
                        }else if(str.substring(0,2)=="12"){
                          dec += parseFloat(fitbit.Steps);
                        }else if(str.substring(0,1)=="1"&&str.substr(str.length-4)=="2016"){
                          jan += parseFloat(fitbit.Steps);
                        }else if (str.substring(0,1)=="2"){
                          feb += parseFloat(fitbit.Steps);
                        }else if((str.substring(0,1)=="3")){
                          mar += parseFloat(fitbit.Steps);
                        }else if(str.substring(0,1)=="4"){
                          apr += parseFloat(fitbit.Steps);
                        }else if (str.substring(0,1)=="5"&&str.substr(str.length-4)=="2016"){
                          secondMay +=parseFloat(fitbit.Steps);
                        }
                    });

                    //Just use to check the value correct or not
                    // document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"+aug+"\n" +sept+"\n" +oct+"\n" +nov+"\n" +dec +"\n"+
                    // jan +"\n" + feb+"\n" +mar+"\n" +apr+"\n" + secondMay+"\n";
                }
                //display graph
                var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title:{
                text: "Total steps per month"
                },
                axisY: {
                title: "Steps",
                },
                data: [{
                type: "splineArea",
                color: "rgba(54,158,173,.7)",
                markerSize: 5,

                dataPoints: [
                { label: "May 2015",  y: may  },
                { label: "June 2015", y: june },
                { label: "July 2015", y: july  },
                { label: "August 2015",  y: aug  },
                { label: "September 2015",  y: sept  },
                { label: "October 2015",  y: oct  },
                { label: "November 2015",  y: nov  },
                { label: "December 2015",  y: dec  },
                { label: "January 2016",  y: jan  },
                { label: "February 2016",  y: feb  },
                { label: "March 2016",  y: mar  },
                { label: "April 2016",  y: apr  },
                { label: "May 2016",  y: secondMay  }
                ]
                }]
                });
                chart.render();

              }
    }

    //Graph for Stitting time per day in a month
    function fifGraph(){
      var may = 0;
      var june = 0;
      var july = 0
      var aug = 0;
      var sept = 0;
      var oct = 0;
      var nov = 0;
      var dec = 0;
      var jan = 0;
      var feb = 0;
      var mar = 0;
      var apr = 0;
      var secondMay = 0;
      var maycount=0;
      var junecount=0;
      var julycount=0;
      var augcount=0;
      var septcount=0;
      var octcount=0;
      var novcount=0;
      var deccount=0;
      var jancount=0;
      var febcount=0;
      var marcount=0;
      var aprcount=0;
      var secondMaycount=0;

           var params = {
            TableName: "Fitbit1",
        };
        //Clean the TextArea
        document.getElementById('textarea').innerHTML = "Dataset: "+"\n";
        //Make the textarea like a table
        document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Sitting Minutes " + "\n";

        //get item from DynamoDB
        docClient.scan(params,onScan);

        function onScan(err, data) {
                if (err) {
                    document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
                } else {
                    // Print all the item
                    //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                    data.Items.forEach(function(fitbit) {
                      var str = fitbit.D;

                        document.getElementById('textarea').innerHTML += str + "\t\t\t\t" + fitbit.Minutes_sitting+ "\n";

                        //set data for graph
                        if(str.substring(0,1)=="5"&&str.substr(str.length-4,str.length)=="2015"){
                          may += parseFloat(fitbit.Minutes_sitting);
                          maycount++;
                        }else if(str.substring(0,1)=="6"){
                          june +=parseFloat(fitbit.Minutes_sitting);
                          junecount++
                        }else if(str.substring(0,1)=="7"){
                          july +=parseFloat(fitbit.Minutes_sitting);
                          julycount++;
                        }else if(str.substring(0,1)=="8"){
                          aug += parseFloat(fitbit.Minutes_sitting);
                          augcount++;
                        }else if (str.substring(0,1)=="9"){
                          sept += parseFloat(fitbit.Minutes_sitting);
                          septcount++;
                        }else if(str.substring(0,2)=="10"){
                          oct += parseFloat(fitbit.Minutes_sitting);
                          octcount++;
                        }else if(str.substring(0,2)=="11"){
                          nov += parseFloat(fitbit.Minutes_sitting);
                          novcount++;
                        }else if(str.substring(0,2)=="12"){
                          dec += parseFloat(fitbit.Minutes_sitting);
                          deccount++;
                        }else if(str.substring(0,1)=="1"&&str.substr(str.length-4)=="2016"){
                          jan += parseFloat(fitbit.Minutes_sitting);
                          jancount++;
                        }else if (str.substring(0,1)=="2"){
                          feb += parseFloat(fitbit.Minutes_sitting);
                          febcount++;
                        }else if((str.substring(0,1)=="3")){
                          mar += parseFloat(fitbit.Minutes_sitting);
                          marcount++;
                        }else if(str.substring(0,1)=="4"){
                          apr += parseFloat(fitbit.Minutes_sitting);
                          aprcount++;
                        }else if (str.substring(0,1)=="5"&&str.substr(str.length-4)=="2016"){
                          secondMay +=parseFloat(fitbit.Minutes_sitting);
                          secondMaycount++;
                        }
                    });

                    //Just use to check the value correct or not
                    // document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"+aug+"\n" +sept+"\n" +oct+"\n" +nov+"\n" +dec +"\n"+
                    // jan +"\n" + feb+"\n" +mar+"\n" +apr+"\n" + secondMay+"\n";
                }
                var chart = new CanvasJS.Chart("chartContainer", {
                  animationEnabled: true,
                  title: {
                    text: "Stitting time per day in a month"
                  },

                  axisY: {
                    title: "Minutes",
                    titleFontColor: "#4F81BC",
                  },
                  data: [{
                    indexLabelFontColor: "darkSlateGray",
                    name: "views",
                    type: "area",
                    dataPoints: [
                      { label: "May 2015",  y: may/maycount  },
                      { label: "June 2015", y: june/junecount},
                      { label: "July 2015", y: july/julycount ,indexLabel: "Highest", markerColor: "red"},
                      { label: "August 2015",  y: aug/augcount  },
                      { label: "September 2015",  y: sept/septcount  },
                      { label: "October 2015",  y: oct/octcount  },
                      { label: "November 2015",  y: nov/novcount  },
                      { label: "December 2015",  y: dec/deccount  },
                      { label: "January 2016",  y: jan/jancount  },
                      { label: "February 2016",  y: feb/febcount  },
                      { label: "March 2016",  y: mar/marcount  },
                      { label: "April 2016",  y: apr/aprcount  },
                      { label: "May 2016",  y: secondMay/secondMaycount}
                    ]
                  }]
                });
                chart.render();
                  }
    }

    //Graph for Total Distance walked in a month
    function sixthGraph(){
      var may = 0;
      var june = 0;
      var july = 0
      var aug = 0;
      var sept = 0;
      var oct = 0;
      var nov = 0;
      var dec = 0;
      var jan = 0;
      var feb = 0;
      var mar = 0;
      var apr = 0;
      var secondMay = 0;
           var params = {
            TableName: "Fitbit1",
        };
        //Clean the TextArea
        document.getElementById('textarea').innerHTML = "Dataset: "+"\n";
        //Make the textarea like a table
        document.getElementById('textarea').innerHTML += "Date" + "\t\t\t\t" + "Distance"+ "\n";

        //get item from DynamoDB
        docClient.scan(params,onScan);

        function onScan(err, data) {
                if (err) {
                    document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
                } else {
                    // Print all the item
                    //document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                    data.Items.forEach(function(fitbit) {
                      var str = fitbit.D;
                      var distancesStr = fitbit.Distance;

                        document.getElementById('textarea').innerHTML += str + "\t\t\t\t\t\t" + fitbit.Distance+ "\n";

                        //set data for graph
                        if(str.substring(0,1)=="5"&&str.substr(str.length-4,str.length)=="2015"){
                          may += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,1)=="6"){
                          june +=parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,1)=="7"){
                          july +=parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,1)=="8"){
                          aug += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if (str.substring(0,1)=="9"){
                          sept += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,2)=="10"){
                          oct += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,2)=="11"){
                          nov += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,2)=="12"){
                          dec += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,1)=="1"&&str.substr(str.length-4)=="2016"){
                          jan += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if (str.substring(0,1)=="2"){
                          feb += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if((str.substring(0,1)=="3")){
                          mar += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if(str.substring(0,1)=="4"){
                          apr += parseFloat(distancesStr.substring(1,distancesStr.length));
                        }else if (str.substring(0,1)=="5"&&str.substr(str.length-4)=="2016"){
                          secondMay +=parseFloat(distancesStr.substring(1,distancesStr.length));
                        }
                    });

                    //Just use to check the value correct or not
                    // document.getElementById('textarea').innerHTML += may +"\n" +june +"\n"+ july + "\n"+aug+"\n" +sept+"\n" +oct+"\n" +nov+"\n" +dec +"\n"+
                    // jan +"\n" + feb+"\n" +mar+"\n" +apr+"\n" + secondMay+"\n";
                }

                //display graph
                var chart = new CanvasJS.Chart("chartContainer", {
                  title:{
                    text: "Total distances walked in a month"
                  },
                  axisY: {
                  title: "meter",
                  },
                  data: [
                  {
                    // Change type to "doughnut", "line", "splineArea", etc.
                    type: "column",
                    dataPoints: [
                      { label: "May 2015",  y: may  },
                      { label: "June 2015", y: june },
                      { label: "July 2015", y: july  },
                      { label: "August 2015",  y: aug  },
                      { label: "September 2015",  y: sept  },
                      { label: "October 2015",  y: oct  },
                      { label: "November 2015",  y: nov  },
                      { label: "December 2015",  y: dec  },
                      { label: "January 2016",  y: jan  },
                      { label: "February 2016",  y: feb  },
                      { label: "March 2016",  y: mar  },
                      { label: "April 2016",  y: apr  },
                      { label: "May 2016",  y: secondMay  }
                    ]
                  }
                  ]
                });
                chart.render();
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
      <div>
        <form action="showdata.php">
          <input type="submit" value="Year of fitbit data" class="btn-primary"/>
        </form>
      </div>
      <h1>Select a requirement</h1>

      <br>
      <br>
      <input id="createData" type="button" value="The total exercise minutes in a month" onclick="firstGraph();" />
      <br>
      <input id="createData" type="button" value="Slow activity vs Moderate activity vs intense_activity" onclick="secondGraph();" />
      <br>
      <input id="createData" type="button" value="Calories burned per day in a month" onclick="thridGraph();" />
      <br>
      <input id="createData" type="button" value="Total steps per month" onclick="fourGraph();" />
      <br>
      <input id="createData" type="button" value="Stitting time per day in a month" onclick="fifGraph();" />
      <br>
      <input id="createData" type="button" value="Total distances walked in a month" onclick="sixthGraph();" />
    </section>

    <section class="instructions">
      <h1>Chart</h1>
      <textarea readonly id= "textarea" style="width:700px; height:200px"></textarea>
      <br>
      <div id="chartContainer" style="height: 300px; width: 700px;"></div>
    </section>

</body>
</html>
<?
}
?>

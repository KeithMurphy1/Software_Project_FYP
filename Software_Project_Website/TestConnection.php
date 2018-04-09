<?php
include ('CONFIG/connection.php');
?>

<!DOCTYPE html>
<html>
    <head>
      <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
 <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
 <link rel="stylesheet" href="./CSS/bootstrap.min.css">
 <title>From Info Windows to a Database: Saving User-Added Form Data</title>
 <style>
   /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
   #map {
     height: 100%;
   }
   /* Optional: Makes the sample page fill the window. */
   html, body {
     height: 100%;
     margin: 0;
     padding: 0;
   }
 </style>
    </head>
    <body>
      <div id="map" height="460px" width="100%"></div>
      <form class="" action="<?php echo'./TestConnectionPHP';?>" method="get">
        <div id="form">
          <table>
          <tr><td>Name:</td> <td><input type='text' id='name'/> </td> </tr>
          <tr><td>Address:</td> <td><input type='text' id='address'/> </td> </tr>
          <tr><td>Type:</td> <td><select id='type'> +
                     <option value='bar' SELECTED>bar</option>
                     <option value='restaurant'>restaurant</option>
                     </select> </td></tr>
                     <tr><td></td><td><input type='button' value='Save' onclick='saveData()' /></td></tr>
          </table>
        </div>
        <div id="message">Location saved</div>
        </form>






        <script>
          var map;
          var marker;
          var infowindow;
          var messagewindow;

          function initMap() {
            var california = {lat: 37.4419, lng: -122.1419};
            map = new google.maps.Map(document.getElementById('map'), {
              center: california,
              zoom: 13
            });

            infowindow = new google.maps.InfoWindow({
              content: document.getElementById('form')
            });

            messagewindow = new google.maps.InfoWindow({
              content: document.getElementById('message')
            });

            google.maps.event.addListener(map, 'click', function(event) {
              marker = new google.maps.Marker({
                position: event.latLng,
                map: map
              });

              google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
                var latitude = this.position.lat();
                var longitude = this.position.lng();
                alert(this.position);
              });
            });
          }

          function saveData() {
       var name = escape(document.getElementById('name').value);
       var address = escape(document.getElementById('address').value);
       var type = document.getElementById('type').value;
       var latlng = marker.getPosition();
       var url = './TestConnection.php?name=' + name + '&address=' + address +
                  '&type=' + type + '&lat=' + latlng.lat() + '&lng=' + latlng.lng();

       downloadUrl(url, function(data, responseCode) {

         if (responseCode == 200 && data.length <= 1) {
           infowindow.close();
           messagewindow.open(map, marker);
         }
       });
     }

     function downloadUrl(url, callback) {
       var request = window.ActiveXObject ?
           new ActiveXObject('Microsoft.XMLHTTP') :
           new XMLHttpRequest;

       request.onreadystatechange = function() {
         if (request.readyState == 4) {
           request.onreadystatechange = doNothing;
           callback(request.responseText, request.status);
         }
       };

       request.open('GET', url, true);
       request.send(null);
     }

     function doNothing () {
     }



        </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCTJAUnNDdnvMhkqtHencorjWQyAJBQz0&callback=initMap">
    </script>







    <!-- // $name = $_GET['name'];
    // $address = $_GET['address'];
    // $lat = $_GET['lat'];
    // $lng = $_GET['lng'];
    // $type = $_GET['type'];
    // $connect = mysqli_connect('localhost','root','','event_management_system');


    // Inserts new row with place data.
// UPDATE business SET address= '$address',type= '$type',lat='$lat',lng= '$lng'  WHERE emailB = 'Nathan@gmail.com'");
    // mysqli_query($connect,"UPDATE business SET address= '$address',type= '$type',lat='$lat',lng= '$lng'  WHERE emailB = 'Nathan@gmail.com'");
    //
    // if(mysqli_affected_rows($connect) >0){
    //   echo "Welcome, you have now created an account.";
    // }
    // else {
    //   echo "Sorry, an error has occurred please try again.  <br>";
    //   echo mysqli_error($connect);
    // }


    // ?> -->

    <script src="./JS/jquery.min.js"></script>
    <script src="./JS/bootstrap.min.js"></script>
    <script src="./JS/myJS.js"></script>

</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/05/08
 * Time: 9:02 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shipping calculator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="col-sm-6" style="padding-top: 5%">

        <div class="form-group">
            <label>Destination</label>
            <input class="form-control" id="destination">
        </div>
        <br>
        <div class="form-group">
            <label>Street Address</label>
            <input type="text" class="form-control" id="address">
        </div>
        <div class="form-group">
            <label>Suburb</label>
            <input type="text" class="form-control" id="suburb">
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" class="form-control" id="city"
        </div>
        <div class="form-group">
            <label>Province</label>
            <select class="form-control">
                <option value="gauteng" id="province">gauteng</option>
            </select>
        </div>
        <div class="form-group">
            <label>Country</label>
            <input type="text" class="form-control" id="country" value="South Africa" readonly>
        </div>
        <button id="get_results" type="button" class="btn btn-primary btn-sm">Get Result</button>
    </div><br>


    <h5>Distance is:<p id="distance_result"></p></h5>
    <h5>Cost for shipping is:<p id="shipping_cost"></p></h5>
</div>


<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script>

    $(function(){
        // calculate distance
        $('#get_results').click(function () {

            // street validation
            var streetAddress = $("#address").val();
            var suburb = $("#suburb").val();
            var city = $("#city").val();
            var province = $("#province").val();
            var country = $("#country").val();
            if(streetAddress == '' && suburb == '' && city == '' && province =='' && country == ''){
                alert('Please check your inputs!');
            } else{
                var destination = streetAddress + ', ' + suburb + ', ' + city + ', ' + country;

            }

        var origin = 'paul smit street, boksburg, south africa'
        var destination = destination;

        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
            {
                origins: [origin],
                destinations: [destination,],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false,
            }, callback);

        function callback(response, status) {
            if (status == 'OK') {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;

                for (var i = 0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    for (var j = 0; j < results.length; j++) {
                        var element = results[j];
                        var distance = element.distance.text;
                        var distance_val = element.distance.value;
                        var distance_in_km = distance_val /1000;
                    }

                    $("#distance_result").text(distance_in_km);
                    // Shipping cost calculator
                    if(distance_in_km <= 5){
                        $("#shipping_cost").text("Free shipping applies");
                    }else{
                        var cost_per_kilo = 6;
                        var distance_less_free_shipping = distance_in_km - 5;
                        var shipping_final_cost = Math.floor(distance_less_free_shipping * cost_per_kilo);
                        $("#shipping_cost").text(shipping_final_cost);

                    }
                }
            }
        }
        });


    });


</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPwjkdQEg9eLknV7RPE-6I6lsoZkIyk8c">
</script>
</body>
</html>

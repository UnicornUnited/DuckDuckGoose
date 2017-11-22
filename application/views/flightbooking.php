<div class="container-fluid">
    <div class="jumbotron">
        <h2><span class="glyphicon glyphicon-plane"></span> Flight Booking</h2>
        
        <form method="post" action="/booking/availableflights" >
            <!--Dropdown of departure airports for Goose Airlines-->
            <div class="container">
                <label class="col-xs-6" for="departure">Departure Airport:</label>
                <select class="col-xs-6" id="departure" name="departure">
                    {airports}
                        <option value="{id}" >{airport} ({id})</option>
                    {/airports}
                </select>
            </div>

            <!--Dropdown of destination airports for Goose Airlines-->
            <div class="container">
                <label class="col-xs-6" for="destination">Destination Airport:</label>
                <select class="col-xs-6" id="destination" name="destination">
                    {airports}
                        <option value="{id}" >{airport} ({id})</option>
                    {/airports}
                </select>        
            </div>

            <button type="submit" class="btn btn-primary">Search Flights</button>
        </form>
        
    </div>
</div>
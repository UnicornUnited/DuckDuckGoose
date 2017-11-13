<div class="container-fluid">
    <div class="jumbotron">
        <h1>Welcome to Goose Airlines</h1>
        <p>We fly out of Golden Airport to South Cariboo Regional Airport (108 Mile Ranch Airport),
            Victoria International Airport, and Vernon Regional Airport.</p>

        <!--Display number of flights and number of planes in fleet-->
        {airlineData}
        <div class="container text-center">
            <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary">Flights Available</button>
                <button type="button" class="btn btn-primary">{flights}</button>
            </div>



            <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary">Planes Available</button>
                <button type="button" class="btn btn-primary">{planes}</button>
            </div>
        </div>
        {/airlineData}
    </div>
</div>
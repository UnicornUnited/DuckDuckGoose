<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h2><span class="glyphicon glyphicon-plane"></span> Plane Info</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>Id:</td>
                        <td>{plane_id}</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>{model}</td>
                    </tr>
                    <tr>
                        <td>Type:</td>
                        <td>{id}</td>
                    </tr>
                    <tr>
                        <td>Manufacturer:</td>
                        <td>{manufacturer}</td>
                    </tr>
                    <tr>
                        <td>Speed:</td>
                        <td>{cruise} Kph</td>
                    </tr>
                    <tr>
                        <td>Price (CAD):</td>
                        <td>{price}</td>
                    </tr>
                    <tr>
                        <td>Seats:</td>
                        <td>{seats}</td>
                    </tr>
                    <tr>
                        <td>Reach:</td>
                        <td>{reach} Km</td>
                    </tr>
                    <tr>
                        <td>Take off:</td>
                        <td>{takeoff}</td>
                    </tr>
                    <tr>
                        <td>Running cost (CAD):</td>
                        <td>{hourly} per hour</td>
                    </tr>
                    <tr>
                        <td>Flights:</td>
                        <td>
                        {flights}
                            <button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-tag"></span> {id}
                            </button>
                        {/flights}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="/fleet" class="btn btn-info btn-md">
                        <span class="glyphicon glyphicon-chevron-left"></span> Planes
                      </a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

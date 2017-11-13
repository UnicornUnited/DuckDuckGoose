<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><h2>Planes in Fleet</h2></td>
                    </tr>
                    {plane_items}
                    <tr>
                        <td>Name:</td>
                        <td><a href="/fleet/plane/{id}">{model_id}</a></td>
                    </tr>
                    {/plane_items}
                </tbody>
            </table>
        </div>
    </div>
</section>

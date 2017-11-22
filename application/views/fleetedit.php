<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h2><span class="glyphicon glyphicon-plane"></span> Manage Our Fleet</h2>
                        </td>
                    </tr>
                    <tr>
                        <th>Plane Id</th>
                        <th>Model</th>
                    </tr>
                    {plane_items}
                    <tr>
                        <td>
                            <a href="/fleet/edit/{id}">
                                <button type="button" class="btn btn-primary">{id}</button>
                            </a>
                        </td>
                        <td><a href="/fleet/plane/{id}">{model_id}</a></td>
                    </tr>
                    {/plane_items}
                    <tr>
                        <td colspan="2">
                            <a href="/fleet/add">
                                <button type="button" class="btn btn-primary">
                                    Add Plane
                                </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

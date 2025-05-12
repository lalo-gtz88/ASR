<div>
    <table class="table table-sm table-bordered table-details">
        <tr>
            <td class="bg-dark text-white text-right"">Proveedor</td>
            <td>{{$proveedor}}</td>
        </tr>
        <tr>
            <td class=" bg-dark text-white text-right"">A color</td>
            <td>@if($aColor)<i class="fa fa-check" aria-hidden="true"></i>@endif</td>
        </tr>
        <tr>
            <td class=" bg-dark text-white text-right"">Multifuncional</td>
            <td>@if($multifuncional)<i class="fa fa-check" aria-hidden="true"></i>@endif</td>
        </tr>

    </table>
</div>
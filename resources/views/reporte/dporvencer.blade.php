<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DEUDAS VENCIDAS</title>
    <link href="/css/pdf1.css" rel="stylesheet">
  </head>
  <body onload="window.print()">
  <div>
          <table class="table">
            <tr>
              <th>RUC ó DNI</th>
              <th>Razón Social</th>
              <th>Tipo de Documento</th>
              <th>Nro. Comprobante</th>
              <th>Fecha de Vencimiento</th>
              <th>Monto Total</th>
              <th>Saldo</th>
              <th>Días de Vencimiento</th>
            </tr>

        @if(sizeof($comprobantes)>0)
          

          @foreach ($comprobantes as $comprobante)
            @if($comprobante->comp_cond=='AL CREDITO')
              <?php $hoy=(strtotime(date('Y-m-d',strtotime($comprobante->comp_fven)))-strtotime(date('Y-m-d')))/86400; ?>
              @if($hoy<'0')
                <tr>
                  <td>{{$comprobante->entidad->ent_ruc}}</td>
                  <td>{{$comprobante->entidad->ent_rz}}</td>
                  <td>{{$comprobante->tipocomprobante->tcomp_desc}}</td>
                  <td>{{$comprobante->comp_nro}}</td>
                  <td>{{$comprobante->comp_fven}}</td>
                  <td>{{number_format($comprobante->comp_tot,2,'.',',')}}</td>
                  <td>{{number_format($comprobante->comp_saldo,2,'.',',')}}</td>
                  <td>{{$hoy}}</td>
                </tr>
              @endif
            @endif
          @endforeach

        @else
          <div class="alert alert-danger">
            <p>Al parecer no tiene comprobantes</p>
          </div>

        </table>
            <div class="alert alert-danger">
              <p>Al parecer no tiene productos</p>
            </div>
          @endif
  </div>
  </body>
</html>
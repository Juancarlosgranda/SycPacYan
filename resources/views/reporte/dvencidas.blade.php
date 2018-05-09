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
              </tr>
          @if(sizeof($dvencidas)>0)
             @foreach ($dvencidas as $dvencida)
              <tr>
                <td>{{$dvencida->ent_ruc}}</td>
                <td>{{$dvencida->ent_rz}}</td>
                <td>{{$dvencida->tipocomprobante->tcomp_desc}}</td>
                <td>{{$dvencida->comp_nro}}</td>
                <td>{{date('d/m/Y', strtotime($dvencida->comp_fven))}}</td>
                <td>{{$dvencida->comp_tot}}</td>
                <td>{{$dvencida->comp_saldo}}</td>
              </tr>
            @endforeach
          @else          
          </table>
            <div class="alert alert-danger">
              <p>Al parecer no tiene productos</p>
            </div>
          @endif
  </div>
  </body>
</html>
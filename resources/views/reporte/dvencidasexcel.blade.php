<?php
  ob_start();
?>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  </head>
  <table border=\"1\" align=\"center\">
    <font size='6' color='#084B8A'><center>REPORTE DE COMPRAS</center><font size='5' color=\"#ffffff\">
            <tr bgcolor=\"#ffffff\"  align=\"center\"  height='40'>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>RUC ó DNI</strong></font></th>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>Razón Social</strong></font></th>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>Tipo de Documento</strong></font></th>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>Nro. Comprobante</strong></font></th>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>Fecha de Vencimiento</strong></font></th>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>Monto Total</strong></font></th>
                <th bgcolor='#ADB8C2' ><font color=\"#ffffff\"><strong>Saldo</strong></font></th>
              </tr>
          @if(sizeof($dvencidas)>0)
             @foreach ($dvencidas as $dvencida)
              <tr>
                <td><strong>{{$dvencida->ent_ruc}}</strong></td>
                <td><strong>{{$dvencida->ent_rz}}</strong></td>
                <td><strong>{{$dvencida->tipocomprobante->tcomp_desc}}</strong></td>
                <td><strong>{{$dvencida->comp_nro}}</strong></td>
                <td><strong>{{date('d/m/Y', strtotime($dvencida->comp_fven))}}</strong></td>
                <td><strong>{{$dvencida->comp_tot}}</strong></td>
                <td><strong>{{$dvencida->comp_saldo}}</strong></td>
              </tr>
            @endforeach
          @else          
          </table>
            <div class="alert alert-danger">
              <p>Al parecer no tiene productos</p>
            </div>
          @endif
</html>


<?php
  $reporte = ob_get_clean();
  header("Content-type: application/vnd.ms-excel");  
  header("Content-Disposition: attachment; filename=Reporte Compras.xls");  
  header("Pragma: no-cache");  
  header("Expires: 0");   

  echo $reporte;  
?>
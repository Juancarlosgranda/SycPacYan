@extends('app')

<script>
    function getUp(sel)
	{	    
	    var prod_id = sel.value;

        $.get('{{ url('information') }}/create/ajax-state?prod_id=' + prod_id, function(data) {
            $('#um_id').empty();
            $.each(data, function(index,subCatObj){
                $('#um_id').append($('<option>', { 
			        value: subCatObj.um_id,
			        text: subCatObj.um_desc
			    }));
            });
        });
	}
</script>


@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nuevo Detalle</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> Al parecer algo está mal.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="/validado/detallesalida/crear">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" class="form-control" name="comp_id" value='{{$comp_id}}'>
						<div class="form-group">
							<label class="col-md-4 control-label">Cantidad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="dcomp_cant">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Producto</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" id="prod_id" name="prod_id" onchange="getUp(this)">
									<option value=0>Elija Producto</option>
									@foreach ($productos as $producto)										
									   	<option  value='{{$producto->prod_id}}'>{{$producto->prod_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-4 control-label">Unidad Medida</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" id="um_id" name="um_id">
									 <option value=0>Elija Unidad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Precio Unitario</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="dcomp_prec">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Crear
								</button>
								<a href="/validado/detallesalida?comp_id={{$comp_id}}" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@extends('app')

@section('content')
@if (Session::has('creado'))
	<div class="alert alert-success">
		{{Session::get('creado')}}
	</div>
@endif
@if (Session::has('actualizado'))
	<div class="alert alert-success">
		{{Session::get('actualizado')}}
	</div>
@endif
@if (Session::has('eliminado'))
	<div class="alert alert-success">
		{{Session::get('eliminado')}}
	</div>
@endif
@if (Session::has('error'))
	<div class="alert alert-danger">
		{{Session::get('error')}}
	</div>
@endif
<div class="container-fluid">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Categoria</div>

			<div class="panel-body">
				<a href="/validado/categoria/crear" class="btn btn-success" role="button">Crear Categoria</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Descripción</th>
							<th>Familia</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($categorias)>0)
					

					@foreach ($categorias as $categoria)
						<tr>
							<td>{{$categoria->cat_desc}}</td>
							<td>{{$categoria->familia->fam_desc}}</td>
							<td><a href="/validado/categoria/editar?cat_id={{$categoria->cat_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/categoria/eliminar?cat_id={{$categoria->cat_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene categorias</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection

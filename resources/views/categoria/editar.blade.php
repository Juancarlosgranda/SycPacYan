@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Categoria</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/categoria/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="cat_id" value="{{$categoria->cat_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">Descripción</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="cat_desc" value="{{$categoria->cat_desc}}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Familia</label>
							<div class="col-md-6">
								<select name="fam_id" class="form-control text-uppercase">
									@foreach ($familias as $familia)
										@if($familia->fam_id == $categoria->fam_id)
									   		<option selected value='{{$familia->fam_id}}'>{{$familia->fam_desc}}</option>
									   	@else
											<option  value='{{$familia->fam_id}}'>{{$familia->fam_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Editar
								</button>
								<a href="/validado/categoria" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

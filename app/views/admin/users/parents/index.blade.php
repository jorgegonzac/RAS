@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">

                <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Parents
                <small>You can either delete, create or edit Parents</small>
            </h1>

			<div class="row centered-form">
			  	<div class="col-xs-12 col-sm-12 col-md-12">
				    <div class="panel panel-default">
				      	<br>
						<!-- Button to Create new parent -->
							<a href="../parents/create"><button type="submit" class="btn btn-success"><i class="fa fa-lg fa-plus-circle"></i> New Parent</button></a>
						<br>
						<br>

						<!-- Show errors or success of deleting -->
						<div class="panel-body">
					        @if(Session::get('errors'))
					          	<div class="alert alert-danger alert-dismissable">
					            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					            <h5>There were some errors:</h5>
					            @foreach($errors->all('<li>:message</li>') as $message)
					              {{$message}}
					            @endforeach
					          </div>
					        @elseif($success = Session::get('success'))        	
						        <div class="alert alert-success alert-dismissable">
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						            <h5>Success:</h5>
						          	{{$success}}
					    	    </div>	
					        @endif
					    </div>

						<!-- This table was created with the datatable api -->
						<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th>First Name</th>
					                <th>Last Name</th>
					                <th>Username</th>
					                <th>Email</th>
					                <th>Actions</th>
					            </tr>
					        </thead>
					 
					        <tfoot>
					            <tr>
					                <th>First Name</th>
					                <th>Last Name</th>
					                <th>Username</th>
					                <th>Email</th>
					                <th>Actions</th>
					            </tr>
					        </tfoot>
					 
					        <tbody>
					        	@foreach($users as $user)
					        	<tr>
					        		<!-- Ticket Info -->
					                <td>{{$user->first_name}}</td>
					                <td>{{$user->last_name}}</td>
					                <td>{{$user->username}}</td>
					                <td>{{$user->email}}</td>
									<td>
					                	<div class="row">
					                		<div class="col-sm-6 pull-right text-center">
					                			<!-- Form that delete ticket-->
								                {{ Form::open(array('url' => 'parents/' . $user->id )) }}

								                    {{ Form::hidden('_method', 'DELETE') }}
								                    {{ Form::button('<i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="left" title="Delete"></i>', array('type' => 'submit', 'class' => 'delete-btn')) }}
								                
								                {{ Form::close() }}
					                		</div>

					                		<div class="col-sm-6 text-center">
					                			<!-- Form that edit ticket-->
						             	   		<a  href="{{ URL::to('parents/' . $user->id . '/edit') }}"> <i class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
					                		
					                		</div>
					                	</div>	                		                
					            	</td>
					            </tr>
					            @endforeach
					        </tbody>
					    </table>
					</div>
				</div>
			</div>
		    <ol class="breadcrumb">
		    	<li>
		                <i class="fa fa-dashboard"></i>  <a href="../admin">Dashboard</a>
		        </li>
				<li class="active">
					<i class="fa fa-file"></i> Show parents
		        </li>
		    </ol>
		</div>
	</div>
</div>
@stop

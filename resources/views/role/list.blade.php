@extends('layouts.app')

@section('content')

<div class="pagetitle">
    <h1>Roles</h1>
</div>
<div class="pagetitle">
      <h1>General Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">General</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Role List</h5>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <a href="{{ url('/role/add') }}" class="btn btn-primary mt-2" >Add</a>
                    </div>
                </div>
              <!-- Default Table -->
              <table class="table">
                <thead>
                
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                
                </thead>
                <tbody>
                @foreach($getRecord as $key=>$value)    
                  <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$value->name}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>
                        <a href="{{ url('/role/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('/role/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                @endforeach  
                  
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
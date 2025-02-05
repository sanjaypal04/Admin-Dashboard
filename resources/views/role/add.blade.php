@extends('layouts.app')

@section('content')

<div class="pagetitle">
    <h1>Add Role</h1>
</div>

  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add New Role</h5>

          <!-- General Form Elements -->
          <form action="{{url('/role')}}" method="post">
            @csrf
            <div class="row mb-3">
              <label for="inputText" class="col-sm-12 col-form-label">Name</label>
              <div class="col-sm-12">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
        

            <div class="row mb-3">
              <div class="col-sm-12" style="text-align: right;">
                <button type="submit" class="btn btn-primary" >Submit Form</button>
              </div>
            </div>

          </form><!-- End General Form Elements -->

        </div>
      </div>

    </div>
  </div>


    

@endsection
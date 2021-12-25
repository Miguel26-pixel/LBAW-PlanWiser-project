@extends('layouts.app')

@section('homepage')


<div class="homepage">
    <div class="homepage-title">Project wiser</br> with</br><h class="green-planwiser">PlanWiser</h></div>

  <div class="container">
    <div class="input-group" style="height:10%;margin-top:10%;margin-right:2%;width:50%;margin-left:35%; margin-bottom:2%;">
    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
    aria-describedby="search-addon"/>
    <button type="button" class="btn btn-outline-success">search</button>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-success btn-lg" style="height:20%;margin-right:2%;width:50%;margin-left:35%;text-align:left;">Project 1</button>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-success btn-lg" style="height:20%;margin-right:2%;width:50%;margin-left:35%;text-align:left;">Project 2</button>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-success btn-lg" style="height:20%;margin-right:2%;width:50%;margin-left:35%;text-align:left;">Project 3</button>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-success btn-lg" style="height:20%;margin-right:2%;width:50%;margin-left:35%;text-align:left;">Project 4</button>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-success btn-lg" style="height:20%;margin-right:2%;width:50%;margin-left:35%;text-align:left;">Project 5</button>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-success btn-lg" style="height:20%;margin-right:2%;width:50%;margin-left:35%;text-align:left;">Project 6</button>
    </div>
  </div>

</div>


@endsection
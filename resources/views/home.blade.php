@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <!-- let people make clients -->
                <passport-clients></passport-clients>
                <!-- list of clients people have authorized to access our account -->
                <passport-authorized-clients></passport-authorized-clients>
                <!-- make it simple to generate a token right in the UI to play with -->
                <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>
</div>
@endsection

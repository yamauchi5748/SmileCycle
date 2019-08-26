@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                <div id="app" class="container-fluid">
                    <home-component
                        :member="'{{ $member }}'"
                        :api_token="'{{ $member->api_token }}'"
                    ></home-component>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid mainContainer toggleContainer">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card customCard homeCard">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

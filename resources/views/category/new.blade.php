@extends('mage2-framework::layouts.admin')

@section('content')
    <div class="container">

        <div class="h1">Category List
            <a style="" href="{{ route('admin.category.create') }}" class="btn btn-primary float-right">Create
                Category</a>
        </div>

        {!! $dataGrid->render() !!}

    </div>
@stop
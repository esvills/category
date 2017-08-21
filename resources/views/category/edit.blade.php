@extends('mage2-framework::layouts.admin')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-12">

            <div class="card-default card">
                <div class="card-header">
                    Edit Category
                </div>
                <div class="card-body">

                    {!! Form::bind($category, ['method' => 'PUT', 'action' => route('admin.category.update', $category->id)]) !!}
                    @include('mage2-category::category._fields')

                    {!! Form::submit("Update Category",['class' => 'btn btn-primary']) !!}
                    {!! Form::button("cancel",['class' => 'btn disabled','onclick' => 'location="' . route('admin.category.index'). '"']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
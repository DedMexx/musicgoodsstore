@extends('category.from')
@section('actionRoute', route('category.update', ['category' => $category]))
@section('method')
    @method('PUT')
@endsection
@section('name', old('name', $category->name))
@section('description', old('description', $category->description))
@section('buttonText', 'Сохранить')

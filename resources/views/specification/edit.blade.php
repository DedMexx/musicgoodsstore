@extends('specification.from')
@section('actionRoute', route('specification.update', ['specification' => $specification]))
@section('method')
    @method('PUT')
@endsection
@section('name', old('name', $specification->name))
@section('description', old('description', $specification->description))
@section('buttonText', 'Сохранить')

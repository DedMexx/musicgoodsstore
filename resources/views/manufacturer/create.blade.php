@extends('manufacturer.from')
@section('actionRoute', route('manufacturer.store'))
@section('name', old('name'))
@section('description', old('description'))
@section('country', old('country'))
@section('region', old('region'))
@section('city', old('city'))
@section('street', old('street'))
@section('house', old('house'))
@section('post_index', old('post_index'))
@section('buttonText', 'Добавить')
@extends('supplier.from')
@section('actionRoute', route('supplier.store'))
@section('name', old('name'))
@section('email', old('email'))
@section('country', old('country'))
@section('region', old('region'))
@section('city', old('city'))
@section('street', old('street'))
@section('house', old('house'))
@section('post_index', old('post_index'))
@section('last_name', old('last_name'))
@section('first_name', old('first_name'))
@section('third_name', old('third_name'))
@section('phone', old('phone'))
@section('buttonText', 'Добавить')

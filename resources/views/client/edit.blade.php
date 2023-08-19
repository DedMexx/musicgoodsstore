@extends('client.from')
@section('actionRoute', route('client.update', ['client' => $client]))
@section('method')
    @method('PUT')
@endsection
@section('last_name', old('last_name', $client->last_name))
@section('first_name', old('first_name', $client->first_name))
@section('third_name', old('third_name', $client->third_name))
@section('phone', old('phone', $client->phone))
@section('email', old('email', $client->email))
@section('country', old('country', $client->country))
@section('region', old('region', $client->region))
@section('city', old('city', $client->city))
@section('street', old('street', $client->street))
@section('house', old('house', $client->house))
@section('post_index', old('post_index', $client->post_index))
@section('buttonText', 'Сохранить')

@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
    <h1>Hubungi Saya</h1>

    <form action="{{ route('contact.store') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nama">

        <input type="email" name="email" placeholder="Email">

        <input type="text" name="subject" placeholder="Subjek">

        <textarea name="message" placeholder="Pesan"></textarea>

        <button type="submit">Kirim Pesan</button>
    </form>
@endsection
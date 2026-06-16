@php
    $isAjax = request()->header('X-Requested-With') === 'XMLHttpRequest' || request()->has('_fragment');
@endphp

@if (!$isAjax)
    @extends('layouts.guru')
    @section('title', 'Detail Catatan')
    @section('page-title', 'Detail Pencatatan')
    @section('content')
    @endif

    {{-- ============ KONTEN DOKUMEN ============ --}}
    @include('guru.catatan._catatan_content', ['isPdf' => false])
    {{-- ============ /KONTEN DOKUMEN ============ --}}

    @if (!$isAjax)
    @endsection
@endif

@extends('layouts/user-layout')
@section('space-work')
<div class="container">
    <livewire:guest-profile-view :guestId="$guest_id" />
    {{-- the guestId should match with parameter in mount function --}}
</div>
@endsection
@extends('layouts.app')

@section('content')
    <h1>MoneyTree Realty</h1>
    <ul>
        <li><a href="/real-estate-projects/goa">Goa projects (3 active: must be indexable)</a></li>
        <li><a href="/real-estate-projects/goa?bhk=2">Goa filtered (noindex, canonical to clean)</a></li>
        <li><a href="/real-estate-projects/goa?utm_source=ads">Goa with utm (still indexable)</a></li>
        <li><a href="/real-estate-projects/mumbai?page=2">Mumbai page 2 (noindex)</a></li>
        <li><a href="/real-estate-projects/thane">Thane (empty: real 404)</a></li>
        <li><a href="/3-bhk-flats-in-goa">Landing page</a></li>
        <li><a href="/contact.php?x=1">.php URL (301 to /contact?x=1)</a></li>
        <li><a href="/old-project">Redirect table (301 to /real-estate-projects/goa)</a></li>
    </ul>
@endsection

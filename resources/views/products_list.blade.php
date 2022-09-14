@extends('layouts.app')

@section('content')
<div class="container">
    <center>
    <div class="row justify-content-center">
        <div class="container mt-3">
            <h2>Products List</h2>
            <table class="table table-bordered" style="width:70%">
                <thead style="text-align:center;">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Descripion</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>                   
                    @foreach($products as $prod)
                        <tr>
                            <td>{{ $prod['name'] }}</td>
                            <td>{{ $prod['price'] }}</td>
                            <td>{{ $prod['description'] }}</td>
                            <td style="text-align:center;width:150px"><a class="btn btn-primary" href="{{url('payment/'.$prod['name'].'/'.$prod['price'])}}">Buy Now</a></td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
    </center>
</div>
@endsection

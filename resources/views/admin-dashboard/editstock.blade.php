@extends('admin-layout.template')
@section('admin-content')

<form method="post" id="inputform">
        @csrf
        <div class="row">
            <div class="col">
                <input type="text" name="inbarcode2" id="inbarcode2" class="form-control" placeholder="Barcode" value="{{$stock->barcode}}">
            </div>
            <div class="col">
                <input type="text"  name="instock2" id="instock2" class="form-control" placeholder="Item" value="{{$stock->description}}">
            </div>
            <div class="col">
                <input type="number" name="inqty2" id="inqty2" class="form-control" placeholder="Qty" value="{{$stock->qty}}">
            </div>
        </div>
        <br>
        <!--input class="btn btn-primary float-right" value="INSERT"  id="INSERT" type="submit"-->
    </form>

@endsection
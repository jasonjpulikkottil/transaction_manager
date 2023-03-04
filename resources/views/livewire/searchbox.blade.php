<div class="search-box">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form method="post" id="inputform">
        @csrf
        <div class="row">
            <div class="col">
                <input type="text" wire:change="searchempty" wire:model="searchbar" wire:keyup="searchResult2" name="inbarcode" id="inbarcode" class="form-control" placeholder="Barcode">
            </div>
            <div class="col">
                <input type="text" wire:model="searchproduct" wire:keyup="searchResult" name="instock" id="instock" class="form-control" placeholder="Stock">
            </div>
            <div class="col">
                <input type="number"  wire:model="searchqty" name="inqty" id="inqty" class="form-control" placeholder="Qty" value="1">
            </div>
        </div>
        <br>
        <!--input class="btn btn-primary float-right" value="INSERT"  id="INSERT" type="submit"-->
    </form>

    <!-- Search result list -->
    @if($showdiv)
        <style>
            li {
                cursor: pointer;
            }
        </style>
        <ul class="list-group list-group-flush">
            @if(!empty($records))
                @foreach($records as $record)
                    <li class="list-group-item" wire:click="fetchStockDetail({{ $record->no }})">{{ $record->description }}</li>
                @endforeach
            @endif
        </ul>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
@include('js')
</div>

<div class = "purchase_in_history">
    <h4>Order Number: {{$purchase->id}}</h4>
    <h5>{{$purchase->date}}</h5>
    <table class="table">
        <thead>
            <th>Quantity</th>
            <th>Product</th>
            <th class="price_history">Price($)</th>
        </thead>
        <tbody>
        @foreach($purchase->product as $product)
            <tr class="product_purchase_history">
                <td class="quantity">{{$product->pivot->quantity}}</td>
                <td><a href="{{ url('product/'.$product->id) }}">{{$product->name}}</a></td>
                <td class="price_history product_history_price">{{$product->price}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</td>
                <td></td>
                <td class="price_history total_purchase_history">$ 0.00</td>
            </tr>
        </tfoot>
    </table>
</div>
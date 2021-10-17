<tr>
    <td>
        <a href="{{ route('products.show', $row->id) }}"><strong>{{ $row->name }}</strong></a>
{{--        <p>{{ ($row->options->has('size') ? $row->options->size : '') }}</p>--}}
    </td>
    <td>
        <form action="{{ route('cart.count.update', $row->id) }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $row->rowId }}" name="rowId">
            <input type="number" min="1" value="{{ $row->qty }}" name="product_count">
            <input type="submit" class="btn btn-outline-success" value="Update count">
        </form>
    </td>
    <td>{{ $row->price }}$</td>
    <td>{{ $row->subtotal }}$</td>
    <td>
        <form action="{{ route('cart.delete') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $row->rowId }}" name="rowId">
            <input type="submit" class="btn btn-outline-danger" value="{{ __('Delete') }}">
        </form>
    </td>
</tr>

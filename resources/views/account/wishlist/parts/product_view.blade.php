<tr>
    <td>
        @if(Storage::has($row->model->thumbnail))
            <img src="{{ Storage::url($row->model->thumbnail) }}" alt="{{ $row->name }}" style="width: 50px;">
        @endif
    </td>
    <td>
        <a href="{{ route('products.show', $row->id) }}"><strong>{{ $row->name }}</strong></a>
    </td>
    <td>{{ $row->price }}$</td>
    <td>
        <form action="{{ route('wishlist.delete', $row->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="rowId" value="{{ $row->rowId }}">
            <input type="submit" class="btn btn-danger" value="Remove">
        </form>
    </td>
</tr>

@extends('masterdb')
@section('konten')
<td>
    <select class="js-example-placeholder-single js-states form-control">
        @foreach ($produk as $product)
        <option value="{{ $product->name }}">{{ $product->name }}</option>
        @endforeach
    </select>
</td>
<script>
    $(document).ready(function() {
        $(".js-example-placeholder-single").select2({
            placeholder: "Select a state",
            allowClear: true
        });
    });
</script>
@endsection
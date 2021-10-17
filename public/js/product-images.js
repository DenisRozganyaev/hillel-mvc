$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // <a class="remove-product-image">x</a>
    $(document).on('click', '.remove-product-image', function(e) {
        e.preventDefault();
        let $btn = $(this);

        $.ajax({
            url: $btn.data('route'), // route from btn data attribute
            type: 'DELETE',
            dataType: 'json',
            success: function(data) {
                $btn.parent().remove();
            },
            error: function(data) {
                console.log('Error: ', data);
            }
        });
    });
});

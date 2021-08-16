<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>      

<script>

    $(document).ready(function(){
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});        $('.delete').click(function (e){
    console.log('hi');

            e.preventDefault();
            var id=$(this).closest("tr").find(".hidden").val();

            swal({
                    title: "Are you sure?",
                    text: "You want to delete this book",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var data={
                                "_token":$('input[name=_token]').val(),
                                "id":id,
                            };
                        $.ajax({
                           type:"DELETE",
                           url:'/books/'+id,
                           data:data,
                           success:function(response){
                                    swal(response.status, {
                                icon: "success",
                                })
                                .then((result)=>{
                                    location.reload();
                                })
                           }
                        })
                    } 
                });
        })

    })
   
</script>
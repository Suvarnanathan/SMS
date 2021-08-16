<script>
    $(function() {
        var usersTable = $('#books_table');
        var resultsContainer = $('#search_results');
        var clearSearchTrigger = $('.clear-search');
        var searchform = $('#search_books');
        var searchformInput = $('#book_search_box');
        var searchSubmit = $('#book-trigger');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        searchform.submit(function(e) {
            e.preventDefault();
            resultsContainer.html('');
            usersTable.hide();
            clearSearchTrigger.show();
            let noResulsHtml = '<tr>' +
                                '<td>No Results</td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>';

            $.ajax({
                type:'POST',
                url: "{{ route('search.books') }}",
                data: searchform.serialize(),
                success: function (result) {
                    console.log(result);
                    let jsonData = JSON.parse(result);
                    if (jsonData.length != 0) {
                        $.each(jsonData, function(index, val) {
                            let editCellHtml = '<a  href="books/' + val.id + '/edit" data-toggle="tooltip" ><button type="button" class="btn btn-primary"">Edit</button></a>';
                            let deleteCellHtml =
                                '<form  action="/delete-book/'+val.id+'" method="post">'+
            '@csrf'+
            '@method("DELETE")'+
        '<input class="btn btn-danger"type="submit" value="delete " >'+
    '</form>' ;
                            resultsContainer.append('<tr>' +
                                '<td>' + val.book_name + '</td>' +
                                '<td class="hidden-xs">' + val.author + '</td>' +
                                '<td class="hidden-xs">' + val.description + '</td>' +
                                '<td class="hidden-xs">' + val.number_of_books + '</td>' +
                                '<td>' + deleteCellHtml + '</td>' +
                                // '<td>' + showCellHtml + '</td>' +
                                '<td>' + editCellHtml + '</td>' +
                            '</tr>');
                        });
                    } else {
                        resultsContainer.append(noResulsHtml);
                    };
                    
                },
                error: function (response, status, error) {
                    if (response.status === 422) {
                        resultsContainer.append(noResulsHtml);
                       
                    };
                },
            });
        });
        searchSubmit.click(function(event) {
            event.preventDefault();
            searchform.submit();
        });
        searchformInput.keyup(function(event) {
            if ($('#user_search_box').val() != '') {
                clearSearchTrigger.show();
            } else {
                clearSearchTrigger.hide();
                resultsContainer.html('');
                usersTable.show();
               
            };
        });
        clearSearchTrigger.click(function(e) {
            e.preventDefault();
            clearSearchTrigger.hide();
            usersTable.show();
            resultsContainer.html('');
            searchformInput.val('');
       
        });
    });
</script>


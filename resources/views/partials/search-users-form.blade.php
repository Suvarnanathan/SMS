<div class="row" style="margin-right:75px;">
    <div class="col-sm-8 offset-sm-4 col-md-6 offset-md-6 col-lg-5 offset-lg-7 col-xl-4 offset-xl-8">    
        <form action="/search-books" method="POST" class="needs-validation" id="search_books" >
       @csrf 
            <div class="input-group">
            <input type="text" class="form-control" style="height:35px"name="book_search_box" id="book_search_box"placeholder="Search">
                <div class="input-group-append">
                    <a href="#" class="input-group-addon btn btn-light clear-search" data-toggle="tooltip" title="" style="display:none;background-color:#006DCC">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
</svg>              
   </a>
                    <a href="#" id="book-trigger" data-toggle="tooltip"  data-placement="bottom" title="search" >
                    <button type="button" style="height:35px;"class="btn btn-primary">Search</button>
             </a>
                </div>
            </div>
</form>    
</div>
</div>
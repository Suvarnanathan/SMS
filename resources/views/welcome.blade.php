<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<section class="login-block">
    <div class="container">
	<div class="row">
		<div class="col-md-5 banner-sec">
	</div>
    <div class="col-md-2">
	</div>
    <div class="col-md-4 login-sec">
		    <h2 class="text-center">Sign In                      
</h2>
		    <form class="login-form" method="POST" action="{{ route('login') }}">
          @csrf
  <div class="form-group">
    <label for="exampleInputEmail1" class="text-uppercase">Email</label>
    <input type="email" class="form-control" placeholder="" name="email" required>
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="text-uppercase">Password</label>
    <input type="password" class="form-control" placeholder="" name="password" required>
  </div>
  
  
    <div class="form-check">
    <label class="form-check-label">
    <a href="/new-member" style="text-align:center;">Don't Have an Account?</a>

    </label>
    <button type="submit" class="btn btn-login float-right">Submit</button>
  </div>
  <br>
 
</form>
</div>
</section>
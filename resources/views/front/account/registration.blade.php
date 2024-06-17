@extends('front.layout.app')

@section('main')


<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="" name="register" id="register">
                        <div class="mb-3">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Password*</label>
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" name="cpass" id="cpass" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div> 
                        <button class="btn btn-primary mt-2">Register</button>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJS')
    <script>
$('#register').submit(function(e){
    e.preventDefault();


    $.ajax({
        url:'{{ route("account.proccessRegistration") }}',
        type:'post',
        data:$('#register').serializeArray(),
        datatype:'json',
        success:function(response){

if(response.status == false){

var errors = response.errors;
if(errors.name){
    $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name)
}
else{
    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
}
if(errors.email){
    $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email)
}
else{
    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
}
if(errors.pass){
    $("#pass").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.pass)
}
else{
    $("#pass").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
}
if(errors.cpass){
    $("#cpass").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.cpass)
}
else{
    $("#cpass").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
}
}else{
    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
    $("#pass").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
    $("#cpass").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
    window.location.href='{{ route("account.login") }}';
    
}
        }
    })
})
    </script>
@endsection
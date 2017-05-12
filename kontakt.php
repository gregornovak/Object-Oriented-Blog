<?php
require_once 'core/init.php';
require_once 'header.php';
?>
<div class="main-wrapper contact-me">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <h2 class="contact-me-h">Če želite me lahko kontaktirate, preko spodnjega obrazca.</h2>
                <hr class="contact-hr">
                <form id="contact-me-form" method="post" action="">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 controls">
                            <label for="name">Ime</label>
                            <input type="text" name="name" class="form-control form-control-custom" id="name">
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 controls">
                            <label for="email">Email naslov</label>
                            <input type="email" name="email" class="form-control form-control-custom" id="email">
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 controls">
                            <label for="message">Sporočilo</label>
                            <textarea rows="5" name="message" class="form-control form-control-custom" id="message" ></textarea>
                        </div>
                    </div>
                    <br>
                    <div id="contact-response"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default btn-contact">Pošlji</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'footer.php';
?>
<script>
    $(function(){
        var submit = $("button[type='submit']");
        submit.on("click", function(event){
            event.preventDefault();
            var name    = $("#name").val();
            var email   = $("#email").val();
            var message = $("#message").val();
            var resp    = $("#contact-response");
            $.ajax({
                method: "post",
                url:    "core/kontakt_poslji_email.php",
                data: {
                    name: name,
                    email: email,
                    message: message
                },
                success: function(response) {
                    resp.html(response);
                    resp.css('display', 'block');
                },
                error: function(response) {
                    resp.html(response);
                    resp.css('display', 'block');
                }
            });
        });
    });
</script>

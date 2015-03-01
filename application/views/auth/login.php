
  <div class="col-md-4 col-md-offset-4">

    <?php if(!empty($message)){ ?>
      <div class="text-danger fade in"><?php echo $message;?></div>
    <?php } ?>

    <div class="well google-well">

      <span class="help-block">Trip Expense Manager Account</span>

      <form role="form" method="post" accept-charset="utf-8">
        <fieldset>
          <div class="form-group">
            <input class="form-control" placeholder="E-mail" id="identity" name="identity" type="text" autofocus="" required >
            <input class="form-control" placeholder="Password" id="password" name="password" type="password" value="" required >
          </div>

          <!-- Change this to a button or input when using this as a form -->
          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary" id="login">Login</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

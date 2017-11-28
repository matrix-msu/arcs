<style media="screen">
  .login-link-back{
    position: absolute;
    right: 60px;
    font-size: 14px;
    top: 28px;
  }
  .login-link-back a{
    color:white;
  }
  .reverse-filter img, .reverse-filter-desktop img{
    -webkit-filter: none !important;
    filter:none !important;

  }
  .registerContainer input{
      color:white !important;
  }

  .loginContainer .input input{
    color:#0093be !important;
  }
  #register-mobile{
    display: none;
    text-transform: uppercase;
  }
  .mobile-only{
    display: none !important;
  }
  .desktop-only{
    display: initial;
  }
  #loginModal{
    transition: .5s opacity;
    transition-delay: inherit;
  }
  #registerModal{
    pointer-events: none;
    transition: .5s opacity;
    transition-delay: inherit;
  }

  #loginModal:target{
    transition-delay: .5s ;
  }
  #registerModal:target{
    pointer-events: auto;
    transition-delay: .5s ;
  }
  #login-mobile{
    position: relative;
    display: block;
    bottom: 0;
    padding-top: 20px;
    left: 0;
    text-align: center;
    /* margin: auto; */
    right: 0;
    color: white;
    text-transform: UPPERCASE;

  }
  /*#registerModal .register-content .left{
    height: auto;
  }*/
  #registerModal .register-content .left .btn{
    position: relative;
    margin: auto;
    bottom:auto;
    left: auto;
    background: white;
    color: #0093be !important;
    line-height: 48px;

  }
  @media screen and (max-width: 1000px) {
    .mobile-only{
      display: inherit !important;
    }
    .desktop-only{
       display: none;
    }
    .login-link{
      position: absolute;
      bottom: 20%;
      left: 0;
      text-align: center;
      margin: auto;
      right: 0;
      color: #0093be;
    }
    #loginModal .login-content .loginSect .btn{
      bottom: 26% !important;
    }
    #register-mobile{
      display: initial;
      bottom: 8%;
    }
    .registerSect{
      display: none;
    }
    #loginModal .login-content{
      width: 30em;
    }
    .loginContainer input{
      margin-top: 2% !important;
      margin-bottom: 2% !important;
      position: inherit !important;
      padding: 0 !important;
      text-align: center;
      border: 2px solid #0093be !important;
      border-radius: 2px !important;

    }
    .registerContainer input{
      text-align: center;
      border: 2px solid white !important;
      color:white !important;
    }
    #loginModal .login-content .loginSect{
      width: 100%;
    }
    #loginModal .login-content{
      height: 32em;
      position: absolute;
      right: 0;
      left: 0;
      top: 0;
      bottom: 0;
      margin: auto;

    }
    .register{
      background: none !important;


    }

    #registerModal .register-content{
      position: absolute;
      right: 0;
      left: 0;
      top: 0;
      bottom: 0;
      display: table;
      margin: auto;

    }
    #registerModal .register-content .right{
      display: none;
    }
    #registerModal .register-content{
      width: 30em;
    }
    /*#registerModal .register-content .left{
      width: 100%;
    }*/
    .reverse-filter-desktop img{
      filter: invert(60%) !important;
      -webkit-filter: invert(60%) !important;
    }

    #registerModal .left {
      width: 100% !important;
    }

    #registerModal .left .requiredfield {
      margin-top: -15px !important;
    }

    #registerModal .left #projectDropdown {
      position: relative;
    }

    #registerModal .left .selectDiv:after {
      bottom: 158px !important;
      /*
      position: initial !important;
      margin-bottom: 3px;
      margin-left: 80px;
      */
    }

  }

  @media screen and (max-width: 430px) {
    .register-content, .login-content{
      width: 100% !important;
      display: inherit;
    }
    .register-content input, .login-content input{
      width: 100% !important;
    }
  }
</style>
<div id="loginModal" class="login desktop-login">
    <div class="login-content reverse-filter-desktop">
        <a id="#close" href="#"><?= $this->Html->image('Close.svg', array('class' => 'exit'));?></a>
        <div class="loginSect">
            <div class="loginContainer">

                <h1 id="loginHeader">Login</h1>

                <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'special_login')); ?>

				<p id="loginInfo"></p>

                <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username')); ?>

                <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password')); ?>

                <p class="login-link" id="forgot-password">Forgot your password?</p>
                <a class="login-link" id="register-mobile" href="#registerModal">Register</a>

                <?php echo $this->Form->input('forgot_password', array('type' => 'hidden')) ?>

                <?php echo $this->Form->submit('Login', array('class' => 'btn')); ?>

                <?php echo $this->Form->end() ?>
            </div>
        </div>

        <div class="registerSect">
            <div class="loginContainer">

                <h1>Register</h1>
                <p style="margin-top:32px;">All annotation, discussion, and metadata editing tools require an account to use. In order to create an account, please click on the Register link below.</p>

                <a class='btn' href='#registerModal'>Register</a>
            </div>
        </div>
    </div>
</div>

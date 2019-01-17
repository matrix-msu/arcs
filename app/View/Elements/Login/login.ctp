
<div id="loginModal" class="login desktop-login">
    <div class="login-content reverse-filter-desktop">

        <div class="loginSect">
            <a id="#close" class="exit" href="#" style="float:right;">
                <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
            </a>
            <div class="loginContainer">

                <div class="headers">
                    <h1 id="loginHeader">Login</h1>
                    <p class="login-err">
                        <?php if(isset($_SESSION['LoginError'])){
                            echo $_SESSION['LoginError'];
                            $_SESSION['LoginError'] = '';
                        }?>
                    </p>
                </div>


                <?php
                // echo $this->Form->create('User', array('controller' => 'users', 'url' => 'special_login'));
                echo $this->Form->create('User', array('url' => array('controller'=>'users', 'action'=>'special_login')));
                ?>

                <p id="loginInfo"></p>

                <label for="username" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username', 'id'=>'username')); ?>

                <label for="loginPassword" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('password', array('label' => false, 'id'=>'loginPassword', 'placeholder' => 'Password')); ?>


<!--                <input name="data[User][username]" placeholder="Username" maxlength="100" type="text" id="UserUsername" required="required">-->
<!--                <input name="data[User][password]" id="loginPassword" placeholder="Password" type="password" required="required" class="unfocused">-->


                <p class="login-link" id="forgot-password">Forgot your password?</p>
                <a class="login-link" id="register-mobile" href="#registerModal">Register</a>

                <?php echo $this->Form->input('forgot_password', array('type' => 'hidden')) ?>

                <?php echo $this->Form->submit('Login', array('class' => 'btn')); ?>

                <?php echo $this->Form->end() ?>

                <!--form action="/~josh.christ/arcs/users/special_login" id="UserSpecialLoginForm" method="post" accept-charset="utf-8">

                    <input type="text" id="UserUsername" tabindex="0"></input>
                    <input type="text" required="required" tabindex="1"></input>

                </form-->


            </div>
        </div>

        <div class="registerSect">
            <a id="#close" class="reverse-filter" href="#" style="float:right;">
                <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
            </a>
            <div class="loginContainer">

                <h1>Register</h1>
                <p style="margin-top:32px;">All annotation, discussion, and metadata editing tools require an account to use. In order to create an account, please click on the Register link below.</p>

                <a class='btn' href='#registerModal'>Register</a>
            </div>
        </div>
    </div>
</div>

<script>
//    $(document).unbind('keydown').off('keydown')
//    $(document).on('keydown', function(e){
//        console.log('keydown;')
//        if ( e.which == 9 && !e.shiftKey && $("#UserUsername").is(":focus") ) {
//            console.log('hi')
//            e.preventDefault();
//            e.stopPropagation();
//            console.log('keydown in focus')
//        }
//    });
    $(document).on('keyup', function(e){
        var focus = false;
        if( $('.desktop-login').find('#UserUsername:focus').length > 0 ){
            focus = true;
        }
        if( $('#registerModal').find('#UserPassword:focus').length > 0){
            focus = true;
        }
        var url = window.location.href;
        var loginModal = false;
        if( url.includes('#loginModal') ){
            loginModal = true;
        }
        if ( e.which == 9 && !e.shiftKey && focus && loginModal ){
            e.preventDefault();
            e.stopPropagation();
            $('#loginPassword').get(0).focus();
            $('#loginPassword').get(0).select();
        }
        focus = false;
        return;
    });
</script>

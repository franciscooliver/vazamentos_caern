 <?php
        session_start();
        $email_usuario_log = isset($_SESSION["email_usuario"])?$_SESSION["email_usuario"]:"";
        $usuario_logado = isset($_SESSION["nome_usuario"])?$_SESSION["nome_usuario"]:"";
        $msg = isset($_SESSION["msg_login"])?$_SESSION["msg_login"]:"";
 ?>
<script src="../public/script_site.js"></script>
 <!--botão face-->
<script>(function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=131535117502383";
        fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<!--Efeito botão face
<script>
    var finished_rendering = function() {
    console.log("finished rendering plugins");
    var spinner = document.getElementById("spinner");
    spinner.removeAttribute("style");
    spinner.removeChild(spinner.childNodes[0]);
    }
    FB.Event.subscribe('xfbml.render', finished_rendering);
    </script>
    <div id="spinner"
        style="
            background: #4267b2;
            border-radius: 5px;
            color: white;
            height: 40px;
            text-align: center;
            width: 250px;">
        Loading
        <div
        class="fb-login-button"
        data-max-rows="1"
        data-size="large"
        data-button-type="continue_with"
        ></div>
    </div>
-->

<div class="container" style="margin-top: 10px">
    <a href="<?= $urlFace ?>">Efetuar login com Facebook</a>
          <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            
         
         
                <form id="form_user" action="http://<?php echo APP_HOST;?>usuario/validaLogin" method="post">
                    <div class="form-group">
                            <div class="btn-group" role="group"  >
                                    <button type="button" style="width: 240px; height: 40px;" class="btn btn-default">Google ???</button>
                            </div>
                            <div class="btn-group" role="group">
                                            <div id="fb-root">
                                                <div class="fb-login-button"  data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true">
                                                </div>
                                            </div>
                                        
                            
                            </div>
                    </div>
                    
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email*</label>
                    <input type="email" class="form-control" id="email_log" name="email_log" aria-describedby="emailHelp" placeholder="Digite seu email" value="<?php echo $email_usuario_log?>">

                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Senha*</label>
                    <input type="password" class="form-control" id="senha_log" name="senha_log" placeholder="Digite sua senha">
                    </div>

                  <button type="submit" id="btn_login" class="btn btn-primary pull-right" >Login</button>
                    <a href="http://<?php echo APP_HOST; ?>usuario/Cadastro" ><label>Não possui conta?</label></a>
                    <div class="fb-login-button" style="margin-left: 20px" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true">
                    </div>
               </form>
              <p id="msg" style="color: #d9534f"></p>
                <?php if(!empty($usuario_logado)){?>
                  <?php echo '<p id="cronometro" >'.'</p>'?>
                  
                <?php }else{
                    echo $_SESSION["msg_erro_login"];
                    unset($_SESSION["msg_erro_login"]);
                }?>
              </div>
          
          <div class="col-md-3"></div>
          </div>
      </div>
      <br/><br/><br/><br/><br/><br/>
<script>
  var contador = 5;
        function contar() {
            
            document.getElementById('cronometro').innerHTML = "Você será redirecionado em: "+contador;
            contador--;
        }
        function redirecionar() {
            contar();
            if (contador == 0) {
                
                document.location.href = 'http://<?php echo APP_HOST;?>vazamento';
            }
        }
        setInterval(redirecionar, 1000);


        
</script>


